<?php
declare(strict_types = 1);
namespace DataTypes;

use DataTypes\Exception\InvalidKeyException;
use DataTypes\Helper\IdHelper;

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
            throw new InvalidKeyException('Code must be string');
        }
        $this->code = IdHelper::formatId($code);
    }

}
