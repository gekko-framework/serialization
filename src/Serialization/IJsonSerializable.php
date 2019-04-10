<?php
/*
 * (c) Leonardo Brugnara
 *
 * Full copyright and license information in LICENSE file.
 */

namespace Gekko\Serialization;

interface IJsonSerializable extends \JsonSerializable
{
    /**
     * Returns an object that contains information
     * about how serialize/deserialize an instance
     * of the implementing class
     * @see \Gekko\Serialization\JsonSerializer
     */
    function getJsonDescriptor() : JsonDescriptor;
}