<?php

namespace App\Attribute;
#[\Attribute]
class Version
{
    public function __construct(public string $version) {}
}