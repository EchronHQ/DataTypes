<?php
declare(strict_types=1);

namespace Echron\DataTypes;

use Echron\DataTypes\Observable\Context\Context;
use Echron\DataTypes\Observable\Context\PropertyChangeContext;
use Echron\DataTypes\Observable\Observable;
use Echron\DataTypes\Observable\Observer;

class IdCodeObjectCollection extends BasicCollection implements Observer
{
    private $idValueStore;
    private $codeValueStore;

    public function __construct()
    {
        parent::__construct();
        $this->idValueStore = new KeyValueStore();
        $this->codeValueStore = new KeyValueStore();

    }

    public function add(IdCodeObject $idCodeObject): int
    {
        $index = $this->addToCollection($idCodeObject);
        $this->idValueStore->add($idCodeObject->getId(), $index);
        $this->codeValueStore->add($idCodeObject->getCode(), $index);

        return $index;
    }

    public function removeByCode(string $code)
    {

        $index = $this->codeValueStore->getValueByKey($code);

        $this->idValueStore->removeByValue($index);
        $this->codeValueStore->removeByValue($index);

        $this->removeFromCollection($index);

    }

    public function removeById(int $id)
    {
        $index = $this->idValueStore->getValueByKey($id);

        $this->idValueStore->removeByValue($index);
        $this->codeValueStore->removeByValue($index);

        $this->removeFromCollection($index);
    }

    public function getByCode(string $code)
    {
        $index = $this->codeValueStore->getValueByKey($code);

        return $this->getByIndex($index);
    }

    public function getById(int $id)
    {
        $index = $this->idValueStore->getValueByKey($id);

        return $this->getByIndex($index);
    }

    public function hasCode(string $code): bool
    {
        return $this->codeValueStore->hasKey($code);
    }

    public function hasId(int $id): bool
    {
        return $this->idValueStore->hasKey($id);
    }

    public function getIds(): array
    {
        return $this->idValueStore->getKeys();
    }

    public function getCodes(): array
    {
        return $this->codeValueStore->getKeys();
    }

    //TODO: make this protected
    public function update(Observable $subject, Context $context)
    {
        throw new \Exception('Not implemented');
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

}
