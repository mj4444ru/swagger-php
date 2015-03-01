<?php

/**
 * @license Apache 2.0
 */

namespace Swagger\Annotations;

/**
 * @Annotation
 */
class Post extends Operation {

    public $method = 'post';

    /** @inheritdoc */
    public static $parents = [
        'Swagger\Annotations\Path',
        'Swagger\Annotations\Swagger'
    ];

}