<?php
namespace DataTypes;

use DataTypes\Helper\IdHelper;

trait CodeCollectionTrait
{
    use IdCollectionTrait {
        IdCollectionTrait::put as putByKey;
    }

    protected $code_max_length = -1;
    private $codeHashMap = [];

    public function getCodes()
    {
        return array_keys($this->codeHashMap);
    }

    protected function put($id, $code, $object)
    {
        if ($this->hasCode($code)) {
            throw new \Exception('Unable to add object to collection, code "' . $code . '" already in collection');
        }

        $index = $this->putByKey($id, $object);

        $code = IdHelper::formatId($code);

        $this->setObjectIndexByCode($code, $index);

        return $index;
    }

    protected function hasCode($code)
    {
        $code = IdHelper::formatId($code);

        if (isset($this->codeHashMap[$code])) {
            return true;
        }

        return false;
    }

    protected function setObjectIndexByCode($code, $index)
    {
        $this->codeHashMap[$code] = $index;
    }

    protected function deleteById($key)
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

    protected function getByCode($code)
    {
        $code = IdHelper::formatId($code);

        if (isset($this->codeHashMap[$code])) {
            $index = $this->codeHashMap[$code];

            if (isset($this->_collection[$index])) {
                return $this->_collection[$index];
            }
        }

        throw new \Exception('No item with code "' . $code . '" not in collection');

    }

    protected function deleteByCode($code)
    {
        $code = IdHelper::formatId($code);

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

    protected function getObjectIndexByCode($code)
    {
        $code = IdHelper::formatId($code);

        if (isset($this->codeHashMap[$code])) {
            return $this->codeHashMap[$code];
        }

        return null;
    }

    protected function allowSlashInCode()
    {
        return false;
    }

}
