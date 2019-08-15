<?php
/*
 * (c) Leonardo Brugnara
 *
 * Full copyright and license information in LICENSE file.
 */

namespace Gekko\Serialization;

trait JsonSerializable
{
    /**
     * Returns an array with the properties that will be serialized
     * when calling json_encode.
     * If object implements \Gekko\Serialization\IJsonSerializable, the
     * JsonDescriptor object will be used to determine the properties
     * to be serialized. For other objects this method returns the 
     * result of the \get_object_vars function called with the current
     * instance as argument
     */
    public function jsonSerialize() : array
    {
         $classes = class_implements($this);

        if (!isset($classes[IJsonSerializable::class]))
            return \get_object_vars($this);
        
        $properties = [];

        $descriptor = $this->getJsonDescriptor();

        foreach ($descriptor->properties as $propertyDescriptor)
        {
            $name = $propertyDescriptor->name;

            if (!isset($this->{$name}) && isset($propertyDescriptor->default_value))
                $properties[$name] = $propertyDescriptor->default_value;
            else
                $properties[$name] = $this->{$name};
        }

        return $properties;
    }
}