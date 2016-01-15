<?php
declare(strict_types = 1);
namespace DataTypes;

use DataTypes\Observable\Context\Context;
use DataTypes\Observable\Context\PropertyChangeContext;
use DataTypes\Observable\Observable;
use DataTypes\Observable\Observer;

class IdObjectCollection extends IdCollection implements Observer
{

    public function getById($id)
    {
        return parent::getById($id);
    }

    public function hasId($id):bool
    {
        return parent::hasId($id);
    }

    public function delete($id)
    {
        return parent::deleteById($id);
    }

    public function getIds()
    {
        return parent::_getIds();
    }

    /**
     * Receive update from subject
     *
     * @param Observable $subject
     * @param $context
     * @return mixed
     */
    public function update(Observable $subject, Context $context)
    {

        if ($context instanceof PropertyChangeContext) {
            switch ($context->getProperty()) {
                case 'id':
                    $this->_updateId($context->getBefore(), $context->getAfter());
                    break;
            }
        }

    }

    protected function addObject(IdObject $item)
    {
        $success = parent::put($item->getId(), $item);
        $item->attach($this);

        return $success;
    }
}
