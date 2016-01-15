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

    protected function put($id, string $code, $object)
    {
        if ($this->hasCode($code)) {
            throw new ObjectAlreadyInCollectionException('Unable to add object to collection, code "' . $code . '" already in collection');
        }

        $index = $this->putByKey($id, $object);

        $code = IdHelper::formatId($code, $this->allowSlashInCode());

        $this->setObjectIndexByCode($code, $index);

        return $index;
    }

    protected function hasCode(string $code)
    {
        $code = IdHelper::formatId($code, $this->allowSlashInCode(), $this->code_max_length);

        if (isset($this->codeHashMap[$code])) {
            return true;
        }

        return false;
    }

    protected function allowSlashInCode():bool
    {
        return false;
    }

    protected function setObjectIndexByCode($code, $index)
    {
        $this->codeHashMap[$code] = $index;
    }

    protected function deleteById(string $key):bool
    {

        $key = IdHelper::formatId($key);
        $index = $this->getObjectIndexById($key);
        if ($index !== null) {
            if (isset($this->_collection[$index])) {
                unset($this->_collection[$index]);
                unset($this->_hashMap[$key]);

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

    protected function getObjectCodeByIndex($index)
    {
        return array_search($index, $this->codeHashMap);
    }

    protected function getByCode(string $code)
    {
        $code = IdHelper::formatId($code, $this->allowSlashInCode(), $this->code_max_length);

        if (isset($this->codeHashMap[$code])) {
            $index = $this->codeHashMap[$code];

            if (isset($this->_collection[$index])) {
                return $this->_collection[$index];
            }
        }

        throw new NotInCollectionException('No item with code "' . $code . '" not in collection');

    }

    protected function deleteByCode(string $code):bool
    {
        $code = IdHelper::formatId($code, $this->allowSlashInCode());

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

    protected function getObjectIndexByCode(string $code)
    {
        $code = IdHelper::formatId($code, $this->allowSlashInCode(), $this->code_max_length);

        if (isset($this->codeHashMap[$code])) {
            return $this->codeHashMap[$code];
        }

        return null;
    }

    protected function updateCode($before, $after)
    {

        $before = IdHelper::formatId($before, $this->allowSlashInCode());
        $after = IdHelper::formatId($after, $this->allowSlashInCode());

        $this->codeHashMap = $this->updateCollectionId($this->codeHashMap, $before, $after);
    }

}
