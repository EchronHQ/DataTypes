<?php
declare(strict_types=1);

class ExtendedTypedEnumImpl extends TypedEnumImpl
{

    public static function OptionTwo()
    {
        return self::_create(2);
    }

}
