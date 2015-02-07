<?php
namespace DataTypes\Helper;

use DataTypes\Exceptions\InvalidIdException;

class IdHelper
{
    public static function formatId($id)
    {
        //TODO: only allow int?
        if (!is_string($id) && !is_int($id)) {
            if (is_array($id)) {
                throw new InvalidIdException('Id must be int or string');
            }

            throw new InvalidIdException('Id must be int or string');
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
