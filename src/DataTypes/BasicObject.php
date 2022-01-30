<?php
declare(strict_types=1);

namespace Echron\DataTypes;

class BasicObject
{

    /**
     * @param string $name
     * @throws \Exception
     * @internal
     * @deprecated
     * @access private
     */
    public function __get(string $name)
    {
        throw new \Exception('Cannot get new property "' . $name . '" to instance of "' . get_class($this) . '"');
    }

    /**
     * @param string $name
     * @param $value
     * @throws \Exception
     * @deprecated
     * @access private
     */
    public function __set(string $name, $value)
    {
        throw new \Exception('Cannot set new property "' . $name . '" to instance of "' . get_class($this) . '"');
    }

    function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
