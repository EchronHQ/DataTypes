<?php
declare(strict_types = 1);

class IdObjectCollectionImplementation extends \DataTypes\IdObjectCollection
{
    public function add(IdObjectImplementation $object)
    {
        return parent::addIdObject($object);
    }

    public function current():IdObjectImplementation
    {
        return parent::_current();
    }
}
