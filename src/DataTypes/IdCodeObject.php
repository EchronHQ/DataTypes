<?php
declare(strict_types = 1);
namespace DataTypes;

use DataTypes\Exception\InvalidKeyException;
use DataTypes\Helper\IdHelper;
use DataTypes\Observable\Context\PropertyChangeContext;

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
            throw new InvalidKeyException('Code must be string or int, `' . get_type($code) . '` given');
        }
        $before = $this->getCode();
        $this->code = IdHelper::formatId($code, false, $this->code_max_length);

        $this->notify(new PropertyChangeContext('code', $before, $this->getCode()));
    }

}
