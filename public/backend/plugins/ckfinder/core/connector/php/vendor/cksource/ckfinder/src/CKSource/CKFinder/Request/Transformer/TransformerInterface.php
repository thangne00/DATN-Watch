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

namespace CKSource\CKFinder\Request\Transformer;

use Symfony\Component\HttpFoundation\Request;

/**
 * The TransformerInterface Interface.
 *
 * Request transformers transform any kind of HTTP request to a request
 * format understandable by the CKFinder connector.
 */
interface TransformerInterface
{
    /**
     * Transforms a request to the required format.
     *
     * @param Request $request the original request
     *
     * @return Request the request after the transformation
     */
    public function transform(Request $request);
}
