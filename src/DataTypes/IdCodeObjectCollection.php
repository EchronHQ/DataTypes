<?php
namespace DataTypes;

abstract class IdCodeObjectCollection extends IdCodeCollection
{

    //TODO: make this protected
    public function add(IdCodeObject $object)
    {

        $index = $this->put($object->getId(), $object->getCode(), $object);

        return $index;
    }

}
