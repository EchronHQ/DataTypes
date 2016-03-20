<?php
declare(strict_types = 1);
namespace DataTypes;

use DataTypes\Exception\NotInCollectionException;
use DataTypes\Exception\ObjectAlreadyInCollectionException;
use DataTypes\Helper\IdHelper;

trait CodeCollectionTrait
{
    use IdCollectionTrait {
        IdCollectionTrait::put as putByKey;
    }

    protected $code_max_length = -1;
    private $codeHashMap = [];

    public function getCodes():array
    {
        return array_keys($this->codeHashMap);
    }

    public final function removeByCode(string $code):bool
    {
        $code = IdHelper::formatKey($code, $this->allowSlashInCode());

        $index = $this->getObjectIndexByCode($code);
        if ($index !== null) {
            if (isset($this->_collection[$index])) {
                unset($this->_collection[$index]);
                unset($this->codeHashMap[$code]);

                $key = $this->getObjectIdByIndex($index);
                if ($key) {
                    unset($this->_hashMap[$key]);
                }
                $this->length--;

                return true;
            }
        }

        return false;
    }

    protected function allowSlashInCode():bool
    {
        return false;
    }

    protected function getObjectIndexByCode(string $code):int
    {
        $code = IdHelper::formatKey($code, $this->allowSlashInCode(), $this->code_max_length);

        if (isset($this->codeHashMap[$code])) {
            return $this->codeHashMap[$code];
        }

        return null;
    }

    protected function put(int $id, string $code, $object)
    {
        if ($this->hasCode($code)) {
            throw new ObjectAlreadyInCollectionException('Unable to add object to collection, code "' . $code . '" already in collection');
        }

        $index = $this->putByKey($id, $object);

        $code = IdHelper::formatKey($code, $this->allowSlashInCode());

        $this->setObjectIndexByCode($code, $index);

        return $index;
    }

    public function hasCode(string $code):bool
    {
        $code = IdHelper::formatKey($code, $this->allowSlashInCode(), $this->code_max_length);

        if (isset($this->codeHashMap[$code])) {
            return true;
        }

        return false;
    }

    protected function setObjectIndexByCode(string $code, int $index)
    {
        $this->codeHashMap[$code] = $index;
    }

    public final function removeById(int $id):bool
    {

        $index = $this->getObjectIndexById($id);
        if ($index !== null) {
            if (isset($this->_collection[$index])) {
                unset($this->_collection[$index]);
                unset($this->_hashMap[$id]);

                $code = $this->getObjectCodeByIndex($index);
                if ($code) {
                    unset($this->codeHashMap[$code]);
                }

                $this->length--;

                return true;
            }
        }

        return false;
    }

    protected function getObjectCodeByIndex(int $index)
    {
        return array_search($index, $this->codeHashMap);
    }

    protected function getByCode(string $code)
    {
        $code = IdHelper::formatKey($code, $this->allowSlashInCode(), $this->code_max_length);

        if (isset($this->codeHashMap[$code])) {
            $index = $this->codeHashMap[$code];

            if (isset($this->_collection[$index])) {
                return $this->_collection[$index];
            }
        }

        throw new NotInCollectionException('No item with code "' . $code . '" not in collection');

    }

    protected function updateCode(string $before, string $after)
    {

        $before = IdHelper::formatKey($before, $this->allowSlashInCode());
        $after = IdHelper::formatKey($after, $this->allowSlashInCode());

        $this->codeHashMap = $this->updateCollectionId($this->codeHashMap, $before, $after);
    }

}
