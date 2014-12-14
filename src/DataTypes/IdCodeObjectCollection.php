<?php

namespace DataTypes;

abstract class IdCodeObjectCollection extends IdObjectCollection
{
    private $codeHashMap;

    final public function __construct()
    {
        $this->codeHashMap = [];
    }

    public function getCodes()
    {
        return array_keys($this->codeHashMap);
    }

    final protected function add(CodeObject $object)
    {
        if (isset($this->codeHashMap[$object->getCode()])) {
            throw new \Exception('Code `' . $object->getCode() . '` already in collection');
        }
        $key = $this->_put($object->getId(), $object);
        if ($key === false) {
            throw new \Exception('Id `' . $object->getId() . '` already in collection');
        }
        $this->codeHashMap[$object->getCode()] = $key;
    }

    protected function getByCode($code)
    {
        $code = self::formatId($code);
        if (isset($this->codeHashMap[$code])) {
            $id = $this->codeHashMap[$code];

            return $this->_get($id);
        }

        return null;
    }
}
