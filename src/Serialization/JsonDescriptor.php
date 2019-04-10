<?php
/*
 * (c) Leonardo Brugnara
 *
 * Full copyright and license information in LICENSE file.
 */

namespace Gekko\Serialization;

use \Gekko\Serialization\JsonPropertyDescriptor;

class JsonDescriptor
{
    /**
     * @var \Gekko\Serialization\JsonPropertyDescriptor[]
     */
    public $properties;

    public function __construct()
    {
        $this->properties = [];
    }

    public function property($name) : JsonPropertyDescriptor
    {
        $property = new JsonPropertyDescriptor($name);
        
        $this->properties[] = $property;

        return $property;
    }
}