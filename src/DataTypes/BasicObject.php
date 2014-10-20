<?php
namespace DataTypes;

use DataTypes\Exceptions\InvalidIdException;

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

    public static function formatId($id) {
        //TODO: only allow int?
        if (!is_string($id) && !is_int($id)) {
            if (is_array($id)) {
                throw new InvalidIdException('Id must be int or string, `' . get_type($id) . '` given (' . json_encode($id) . ') (' . json_encode(debug_backtrace()) . ')');
            }

            throw new InvalidIdException('Id must be int or string, `' . get_type($id) . '` given');
        }
        $code = trim($id);
        if (strlen($code) < 1) {
            throw new InvalidIdException('Id must be longer than 1 character');
        }
        $code = strtolower($code);
        //Remove special characters
        $code = preg_replace("/([^A-Za-z0-9]+)/", " ", $code);
        //Remove multi underscores
        $code = preg_replace('!\s+!', ' ', $code);
        $code = trim($code);
        $code = str_replace(' ', '_', $code);

        return $code;
    }
}
