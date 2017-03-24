<?php

namespace Absolvent\api;

use Absolvent\swagger\SwaggerValidator;

class AppSwaggerValidator extends SwaggerValidator
{
    public function __construct(AppSwaggerSchema $appSwaggerSchema)
    {
        // leave the above just for typehint
        parent::__construct($appSwaggerSchema);
    }
}
