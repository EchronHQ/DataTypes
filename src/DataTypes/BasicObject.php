<?php
namespace DataTypes;

class BasicObject
{

    /**
     * @param $name
     * @throws \Exception
     * @internal
     * @deprecated
     * @access private
     */
    public function __get($name)
    {
        throw new \Exception('Cannot get new property "' . $name . '" to instance of "' . get_class($this) . '"');
    }

    /**
     * @param $name
     * @param $value
     * @throws \Exception
     * @deprecated
     * @access private
     */
    public function __set($name, $value)
    {
        throw new \Exception('Cannot set new property "' . $name . '" to instance of "' . get_class($this) . '"');
    }

    function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
