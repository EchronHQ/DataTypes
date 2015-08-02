<?php
namespace DataTypes;

class IdObjectCollection extends IdCollection
{

    public function getById($id)
    {
        return parent::getById($id);
    }

    public function delete($id)
    {
        return parent::deleteById($id);
    }

    public function getIds()
    {
        return parent::_getIds();
    }

    protected function addObject(IdObject $item)
    {
        $success = parent::put($item->getId(), $item);

        return $success;
    }
}
