<?php

/*
 * CKFinder
 * ========
 * https://ckeditor.com/ckfinder/
 * Copyright (c) 2007-2022, CKSource Holding sp. z o.o. All rights reserved.
 *
 * The software, this file and its contents are subject to the CKFinder
 * License. Please read the license.txt file before using, installing, copying,
 * modifying or distribute this file or part of its contents. The contents of
 * this file is part of the Source Code of CKFinder.
 */

namespace CKSource\CKFinder\Acl;

use CKSource\CKFinder\Acl\User\RoleContextInterface;
use CKSource\CKFinder\Filesystem\Path;

/**
 * The Acl class.
 */
class Acl implements AclInterface
{
    /**
     * @brief The list of Access Control Lists entries.
     *
     * A list of array entries in the following form:
     * <pre>[folderPath][role][resourceType] => MaskBuilder</pre>
     *
     * @var array
     */
    protected $rules = [];

    /**
     * @brief The role context Interface.
     *
     * By default an instance of SessionRoleContext is used as a role context.
     * You can easily add a new class that implements RoleContextInterface to
     * better fit your application.
     *
     * @var RoleContextInterface
     */
    protected $roleContext;

    /**
     * @brief Cache for computed masks.
     *
     * This array contains computed mask results to avoid double checks
     * for the same path.
     *
     * @var array
     */
    protected $cachedResults = [];

    /**
     * Constructor.
     */
    public function __construct(RoleContextInterface $roleContext)
    {
        $this->roleContext = $roleContext;
    }

    /**
     * Sets rules for Access Control Lists using configuration nodes.
     *
     * It is assumed that Acl configuration nodes used here have the following form:
     *
     * @code
     * array(
     *      'role'          => 'foo',
     *      'resourceType'  => 'Images',
     *      'folder'        => '/bar',
     *
     *      // Permissions
     *      'FOLDER_VIEW'   => true,
     *      'FOLDER_CREATE' => true,
     *      'FOLDER_RENAME' => true,
     *      'FOLDER_DELETE' => true,
     *
     *      'FILE_VIEW'     => true,
     *      'FILE_CREATE'   => true,
     *      'FILE_RENAME'   => true,
     *      'FILE_DELETE'   => true
     * )
     *
     * @endcode
     *
     * If any permission is missing, it is inherited from the parent folder.
     *
     * @param array $aclConfigNodes Access Control Lists configuration nodes
     */
    public function setRules(array $aclConfigNodes)
    {
        foreach ($aclConfigNodes as $node) {
            $role = $node['role'] ?? '*';

            $resourceType = $node['resourceType'] ?? '*';

            $folder = $node['folder'] ?? '/';

            $permissions = Permission::getAll();

            foreach ($permissions as $permissionName => $permissionValue) {
                if (isset($node[$permissionName])) {
                    $allow = (bool) $node[$permissionName];

                    if ($allow) {
                        $this->allow($resourceType, $folder, $permissionValue, $role);
                    } else {
                        $this->disallow($resourceType, $folder, $permissionValue, $role);
                    }
                }
            }
        }
    }

    /**
     * Allows a permission for a given role.
     *
     * @param string $resourceType
     * @param string $folderPath
     * @param int    $permission
     * @param string $role
     *
     * @return $this|Acl
     */
    public function allow($resourceType, $folderPath, $permission, $role)
    {
        $folderPath = Path::normalize($folderPath);

        if (!isset($this->rules[$folderPath][$role][$resourceType])) {
            $this->rules[$folderPath][$role][$resourceType] = new MaskBuilder();
        }

        /** @var MaskBuilder $ruleMask */
        $ruleMask = $this->rules[$folderPath][$role][$resourceType];

        $ruleMask->allow($permission);

        return $this;
    }

    /**
     * Disallows a permission for a given role.
     *
     * @param string $resourceType
     * @param string $folderPath
     * @param int    $permission
     * @param string $role
     *
     * @return $this|Acl
     */
    public function disallow($resourceType, $folderPath, $permission, $role)
    {
        $folderPath = Path::normalize($folderPath);

        if (!isset($this->rules[$folderPath][$role][$resourceType])) {
            $this->rules[$folderPath][$role][$resourceType] = new MaskBuilder();
        }

        /** @var MaskBuilder $ruleMask */
        $ruleMask = $this->rules[$folderPath][$role][$resourceType];

        $ruleMask->disallow($permission);

        return $this;
    }

    /**
     * Checks if a given role has a permission.
     *
     * @param string      $resourceType
     * @param string      $folderPath
     * @param int         $permission
     * @param null|string $role
     *
     * @return bool
     */
    public function isAllowed($resourceType, $folderPath, $permission, $role = null)
    {
        $mask = $this->getComputedMask($resourceType, $folderPath, $role);

        return ($mask & $permission) === $permission;
    }

    /**
     * Returns a computed mask.
     *
     * @param string      $resourceType
     * @param string      $folderPath
     * @param null|string $role
     *
     * @return int
     */
    public function getComputedMask($resourceType, $folderPath, $role = null)
    {
        $computedMask = 0;

        $role = $role ?: $this->roleContext->getRole();

        $folderPath = trim($folderPath, '/');

        if (isset($this->cachedResults[$resourceType][$folderPath])) {
            return $this->cachedResults[$resourceType][$folderPath];
        }

        $pathParts = explode('/', $folderPath);

        $currentPath = '/';

        $pathPartsCount = \count($pathParts);

        for ($i = -1; $i < $pathPartsCount; ++$i) {
            if ($i >= 0) {
                if (!\strlen($pathParts[$i])) {
                    continue;
                }

                if (\array_key_exists($currentPath.'*/', $this->rules)) {
                    $computedMask = $this->mergePathComputedMask($computedMask, $resourceType, $role, $currentPath.'*/');
                }

                $currentPath .= $pathParts[$i].'/';
            }

            if (\array_key_exists($currentPath, $this->rules)) {
                $computedMask = $this->mergePathComputedMask($computedMask, $resourceType, $role, $currentPath);
            }
        }

        $this->cachedResults[$resourceType][$folderPath] = $computedMask;

        return $computedMask;
    }

    /**
     * Merges permission masks to allow permission inheritance from parent folders.
     *
     * @param int    $currentMask  the current mask numeric value
     * @param string $resourceType the resource type identifier
     * @param string $role         the user role name
     * @param string $folderPath   the folder path
     *
     * @return int computed mask numeric value
     */
    protected function mergePathComputedMask($currentMask, $resourceType, $role, $folderPath)
    {
        $folderRules = $this->rules[$folderPath];

        $possibleRules = [
            ['*', '*'],
            ['*', $resourceType],
            [$role, '*'],
            [$role, $resourceType],
        ];

        foreach ($possibleRules as $rule) {
            list($role, $resourceType) = $rule;

            if (isset($folderRules[$role][$resourceType])) {
                /** @var MaskBuilder $ruleMask */
                $ruleMask = $folderRules[$role][$resourceType];

                $currentMask = $ruleMask->mergeRules($currentMask);
            }
        }

        return $currentMask;
    }
}
