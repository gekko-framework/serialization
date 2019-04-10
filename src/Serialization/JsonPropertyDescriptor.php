<?php
/*
 * (c) Leonardo Brugnara
 *
 * Full copyright and license information in LICENSE file.
 */

namespace Gekko\Serialization;

use \Gekko\Types\Type;
use \Gekko\Types\Byte;
use \Gekko\Types\Int16;
use \Gekko\Types\Int32;
use \Gekko\Types\Int64;
use \Gekko\Types\Float32;
use \Gekko\Types\Double64;
use \Gekko\Types\Decimal;
use \Gekko\Types\Boolean;
use \Gekko\Types\Varchar;
use \Gekko\Types\Text;
use \Gekko\Types\Char;
use \Gekko\Types\Binary;
use \Gekko\Types\Blob;
use \Gekko\Types\DateTime;
use \Gekko\Types\Time;
use \Gekko\Types\Timestamp;

class JsonPropertyDescriptor
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var \Gekko\Types\Type
     */
    public $type;

    /**
     * @var bool
     */
    public $isarray;

    public function __construct($name)
    {
        $this->name = $name;
        $this->isarray = false;
    }

    public function type(string $type) : self
    {
        $this->type = Type::new($type);
        return $this;
    }

    public function byte() : self
    {
        $this->type = Byte::instance();
        return $this;
    }

    public function int16() : self
    {
        $this->type = Int16::instance();
        return $this;
    }

    public function int32() : self
    {
        $this->type = Int32::instance();
        return $this;
    }

    public function int64() : self
    {
        $this->type = Int64::instance();
        return $this;
    }

    public function float() : self
    {
        $this->type = Float32::instance();
        return $this;
    }

    public function double() : self
    {
        $this->type = Double64::instance();
        return $this;
    }

    public function decimal() : self
    {
        $this->type = Decimal::instance();
        return $this;
    }

    public function boolean() : self
    {
        $this->type = Boolean::instance();
        return $this;
    }

    public function string() : self
    {
        $this->type = Varchar::instance();
        return $this;
    }

    public function text() : self
    {
        $this->type = Text::instance();
        return $this;
    }

    public function char() : self
    {
        $this->type = Char::instance();
        return $this;
    }

    public function varchar() : self
    {
        $this->type = Varchar::instance();
        return $this;
    }

    public function binary() : self
    {
        $this->type = Binary::instance();
        return $this;
    }

    public function blob() : self
    {
        $this->type = Blob::instance();
        return $this;
    }

    public function dateTime() : self
    {
        $this->type = DateTime::instance();
        return $this;
    }

    public function time() : self
    {
        $this->type = Time::instance();
        return $this;
    }

    public function timestamp() : self
    {
        $this->type = Timestamp::instance();
        return $this;
    }

    public function array() : self
    {
        $this->isarray = true;
        return $this;
    }
}