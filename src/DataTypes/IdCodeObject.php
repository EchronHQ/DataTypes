<?php
namespace DataTypes;

use DataTypes\Exceptions\InvalidCodeException;
use DataTypes\Helper\IdHelper;

class IdCodeObject extends IdObject
{
    protected $code_max_length = -1;
    private $code;

    public function __construct($id, $code)
    {
        parent::__construct($id);
        $this->setCode($code);
    }

    public function __toString()
    {
        return $this->getCode() . ' (id: ' . $this->getId() . ')';
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        if (!is_string($code) && !is_int($code)) {
            throw new InvalidCodeException('Code must be string or int given');
        }

        $this->code = IdHelper::formatId($code);

    }

}
