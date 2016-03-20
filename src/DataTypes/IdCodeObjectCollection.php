<?php
declare(strict_types = 1);
namespace DataTypes;

use DataTypes\Observable\Context\Context;
use DataTypes\Observable\Context\PropertyChangeContext;
use DataTypes\Observable\Observable;
use DataTypes\Observable\Observer;

abstract class IdCodeObjectCollection extends IdCodeCollection implements Observer
{

    //TODO: make this protected
    public function update(Observable $subject, Context $context)
    {

        if ($context instanceof PropertyChangeContext) {
            switch ($context->getProperty()) {
                case 'id':
                    $this->_updateId($context->getBefore(), $context->getAfter());
                    break;
                case 'code':
                    $this->updateCode($context->getBefore(), $context->getAfter());
                    break;
            }
        }
    }

    protected function addIdCodeObject(IdCodeObject $object)
    {

        $index = $this->put($object->getId(), $object->getCode(), $object);
        $object->attach($this);

        return $index;
    }
}
