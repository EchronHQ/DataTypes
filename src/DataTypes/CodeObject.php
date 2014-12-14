<?php

namespace DataTypes;

use DataTypes\Exceptions\InvalidCodeException;

class CodeObject extends IdObject
{

    private $code;

    public function __construct($id, $code)
    {
        $this->setId($id);
        $this->setCode($code);
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        if (!is_string($code) && !is_int($code)) {
            throw new InvalidCodeException('Code must be string');
        }
        $this->code = self::formatId($code);
    }

}
