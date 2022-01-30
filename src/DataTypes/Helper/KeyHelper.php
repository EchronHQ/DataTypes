<?php
declare(strict_types=1);

namespace Echron\DataTypes\Helper;

use Echron\DataTypes\Exception\InvalidKeyException;

class KeyHelper
{
    public static function formatKey(string $key, bool $allowSlash = false, int $maxLength = 0): string
    {
        //TODO: only allow int?
        if (!is_string($key) && !is_int($key)) {
            if (is_array($key)) {
                throw new InvalidKeyException('Id must be int or string, `' . self::getObjectType($key) . '` given (' . json_encode($key) . ') (' . json_encode(debug_backtrace()) . ')');
            }

            throw new InvalidKeyException('Id must be int or string, `' . self::getObjectType($key) . '` given');
        }

        // $id = iconv("UTF-8", "UTF-8//IGNORE", $id);
        //$id = mb_convert_encoding($id, 'UTF-8', 'UTF-8');
        //$id = mb_strtolower($id);
        $key = str_replace([
            'ë',
            'é',
            'è',
            'ç',
            'ò',
            '�',
        ], [
            'e',
            'e',
            'e',
            'c',
            'o',
            '_',

        ], $key);
        //Remove special characters (http://regexr.com/3cpha)
        //Don't use \w as character groop, it will allow special non utf-8 characters
        $regex = '/([^a-z0-9]+)|(\_{2,})/mi';
        if ($allowSlash) {
            $regex = '/([^a-z0-9\/]+)|(\s{2,})|(\_{2,})|(\/{2,})/im';
        }

        //        if ($allowWhiteSpace) {
        //            $regex = '/([^\w\s]+)|(\s{2,})|(\_{2,})/im';
        //            if ($allowSlash) {
        //                $regex = '/([^\w\s\/]+)|(\s{2,})|(\_{2,})|(\/{2,})/im';
        //            }
        //        }

        $key = preg_replace($regex, '_', $key);

        if (strlen($key) < 1) {
            $ex = new InvalidKeyException('Id must be longer than 1 character');
            echo $ex->getTraceAsString();
            throw $ex;
        }

        $key = strtolower($key);

        if ($maxLength > 0) {
            $key = substr($key, 0, $maxLength);
        }

        //Remove leading or trailing slashes
        $key = trim($key, '_');
        //Remove multi underscores
        //        $code = preg_replace('!\s+!', ' ', $code);
        //        $code = trim($code);
        //        $code = str_replace(' ', '_', $code);

        return $key;
    }

    private static function getObjectType($var): string
    {
        $type = gettype($var);
        if ($type === 'object') {
            $type = get_class($var);
        }

        return $type;
    }
}
