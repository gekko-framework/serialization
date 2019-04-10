<?php
/*
 * (c) Leonardo Brugnara
 *
 * Full copyright and license information in LICENSE file.
 */

namespace Gekko\Serialization;

class JsonSerializer
{
    /**
     * Serialize is a wrapper around \json_encode. For objects that
     * implements \Gekko\Serialization\IJsonSerializable this function
     * will call the jsonSerialize function.
     * If $object uses the trait \Gekko\Serialization\JsonSerializable,
     * this function will use the \Gekko\Serialization\JsonDescriptor
     * returned by getJsonDescriptor
     */
    public static function serialize($object, int $options = 0) : string
    {
        return \json_encode($object, $options);
    }

    /**
     * Deserialize will just return the return value of \json_decode if $class
     * does not implement \Gekko\Serialization\IJsonSerializable otherwise it will
     * deserialize the object by using the \Gekko\Serialization\JsonDescriptor
     * object.
     */
    public static function deserialize(string $jsonsrc, string $class) : object
    {
        $classes = class_implements($class);
        
        if (!isset($classes[IJsonSerializable::class]))
            return \json_decode($jsonsrc);

        return self::deserializeObject($class, \json_decode($jsonsrc, true));
    }

    private static function deserializeObject(string $class, $source)
    {
        $refclass = new \ReflectionClass($class);

        $target = $refclass->newInstanceWithoutConstructor();

        $descriptor = $target->getJsonDescriptor();
        
        // Iterate over descriptor's properties and populate $target
        foreach ($descriptor->properties as $propertyDescriptor)
        {
            $name = $propertyDescriptor->name;
            
            $refproperty = $refclass->getProperty($name);

            $refproperty->setAccessible(true);

            $refproperty->setValue($target, self::getValue($propertyDescriptor, $source[$name]));
        }

        return $target;
    }

    private static function getValue(\Gekko\Serialization\JsonPropertyDescriptor $propertyDescriptor, $object)
    {
        return $propertyDescriptor->isarray
            ? self::getArrayValue($propertyDescriptor, $object) 
            : self::getObjectValue($propertyDescriptor, $object);
    }

    private static function getObjectValue(\Gekko\Serialization\JsonPropertyDescriptor $propertyDescriptor, $object)
    {
        if ($object == null || !isset($propertyDescriptor->type))
            return $object;

        if ($propertyDescriptor->type->raw() == gettype($object))
            return $object;

        // TODO: Move this to a custom resolver
        if ($propertyDescriptor->type == \Gekko\Types\Type::class)
        {
            // \Gekko\Types\Type::$name member
            $typeref = new \ReflectionClass($object['name']);
            $methodref = $typeref->getMethod('instance');
            // Static method
            return $methodref->invoke(null);
        }
        else if (\class_exists($propertyDescriptor->type->__toString()) && \is_subclass_of($propertyDescriptor->type->__toString(), \Gekko\Types\Type::class))
        {
            // TODO: Use TypeConverter
            return $object;
        }

        return self::deserializeObject($propertyDescriptor->type, $object);
    }

    private static function getArrayValue(\Gekko\Serialization\JsonPropertyDescriptor $propertyDescriptor, ?array $array) : ?array
    {
        if ($array === null)
            return null;

        $output = [];

        foreach ($array as $k => $value)
            $output[$k] = !isset($propertyDescriptor->type) 
                ? $value 
                : self::getObjectValue($propertyDescriptor, $value);

        return $output;
    }
}