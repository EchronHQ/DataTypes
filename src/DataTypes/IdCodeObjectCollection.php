<?php
declare(strict_types=1);

namespace Echron\DataTypes;

use Echron\DataTypes\Observable\Context\Context;
use Echron\DataTypes\Observable\Observable;
use Echron\DataTypes\Observable\Observer;
use Echron\Tools\Normalize\NormalizeConfig;

class IdCodeObjectCollection extends BasicCollection implements Observer
{
    private IdValueStore $idValueStore;
    private KeyValueStore $codeValueStore;

    public function __construct(NormalizeConfig $normalizeConfig = null)
    {
        parent::__construct();
        $this->idValueStore = new IdValueStore();
        $this->codeValueStore = new KeyValueStore($normalizeConfig);
    }

    public function add(IdCodeObject $idCodeObject): int
    {
        $index = $this->addToCollection($idCodeObject);
        $this->idValueStore->add($idCodeObject->getId(), $index);
        $this->codeValueStore->add($idCodeObject->getCode(), $index);

        return $index;
    }

    public function removeByCode(string $code): void
    {
        $index = $this->codeValueStore->getValueByKey($code);

        $this->idValueStore->removeByValue($index);
        $this->codeValueStore->removeByValue($index);

        $this->removeFromCollection($index);
    }

    public function removeById(int $id): void
    {
        $index = $this->idValueStore->getValueByKey($id);

        $this->idValueStore->removeByValue($index);
        $this->codeValueStore->removeByValue($index);

        $this->removeFromCollection($index);
    }

    /**
     * @param string $code
     * @return IdCodeObject
     * @throws Exception\NotInCollectionException
     */
    public function getByCode(string $code)
    {
        $index = $this->codeValueStore->getValueByKey($code);

        return $this->getByIndex($index);
    }

    /**
     * @param int $id
     * @return IdCodeObject
     * @throws Exception\NotInCollectionException
     */
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

    /**
     * @return int[]
     */
    public function getIds(): array
    {
        return $this->idValueStore->getKeys();
    }

    /**
     * @return string[]
     */
    public function getCodes(): array
    {
        return $this->codeValueStore->getKeys();
    }

    //TODO: make this protected
    public function update(Observable $subject, Context $context)
    {
        throw new \Exception('Not implemented');
        //        if ($context instanceof PropertyChangeContext) {
        //            switch ($context->getProperty()) {
        //                case 'id':
        //                    $this->_updateId($context->getBefore(), $context->getAfter());
        //                    break;
        //                case 'code':
        //                    $this->updateCode($context->getBefore(), $context->getAfter());
        //                    break;
        //            }
        //        }
    }

}
