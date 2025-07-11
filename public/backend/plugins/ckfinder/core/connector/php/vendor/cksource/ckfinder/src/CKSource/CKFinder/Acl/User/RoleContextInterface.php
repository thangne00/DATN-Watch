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

namespace CKSource\CKFinder\Acl\User;

/**
 * The role context Interface.
 *
 * You can implement this Interface to get the current user role in your application.
 * By default Access Control Lists use SessionRoleContext to get the user role from the
 * defined $_SESSION field.
 */
interface RoleContextInterface
{
    /**
     * Returns the name of the current user role.
     *
     * @return null|string the current user role name or `null`
     */
    public function getRole();
}
