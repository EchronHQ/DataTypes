<?php
declare(strict_types = 1);

class IdCodeObjectCollectionImplementation extends \DataTypes\IdCodeObjectCollection
{
    public function add(IdCodeObjectImplementation $object)
    {
        return parent::addIdCodeObject($object);
    }

    public function current():IdCodeObjectImplementation
    {
        return parent::_current();
    }

    public function getById(string $id):IdCodeObjectImplementation
    {
        return parent::getById($id);
    }

    public function getByCode(string $code):IdCodeObjectImplementation
    {
        return parent::getByCode($code);
    }
}
