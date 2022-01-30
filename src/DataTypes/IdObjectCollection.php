<?php
declare(strict_types=1);

namespace Echron\DataTypes;

use Echron\DataTypes\Observable\Context\Context;
use Echron\DataTypes\Observable\Observable;
use Echron\DataTypes\Observable\Observer;

class IdObjectCollection extends BasicCollection implements Observer
{

    private KeyValueStore $idValueStore;

    public function __construct()
    {
        parent::__construct();
        $this->idValueStore = new KeyValueStore();
    }

    public function add(IdObject $idCodeObject)
    {
        $index = $this->addToCollection($idCodeObject);
        $this->idValueStore->add($idCodeObject->getId(), $index);
    }

    public function removeById(int $id)
    {
        $index = $this->idValueStore->getValueByKey($id);

        $this->idValueStore->removeByValue($index);

        $this->removeFromCollection($index);
    }

    public function getById(int $id)
    {
        $index = $this->idValueStore->getValueByKey($id);

        return $this->getByIndex($index);
    }

    public function hasId(int $id): bool
    {
        return $this->idValueStore->hasKey($id);
    }

    public function getIds(): array
    {
        return $this->idValueStore->getKeys();
    }

    public function update(Observable $subject, Context $context)
    {
        throw new \Exception('Not implemented');
        //        if ($context instanceof PropertyChangeContext) {
        //            switch ($context->getProperty()) {
        //                case 'id':
        //                    $this->_updateId($context->getBefore(), $context->getAfter());
        //                    break;
        //            }
        //        }

    }

}
