<?php

namespace DataTypes;

use DataTypes\Helper\IdHelper;

trait CollectionTrait
{
    protected $_hashMap = [];
    protected $_collection = [];
    private $length = 0;

    public function length()
    {
        return $this->getLength();
    }

    protected function getLength()
    {
        return $this->length;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current()
    {
        return current($this->_collection);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        next($this->_collection);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return key($this->_collection);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        return !!current($this->_collection);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        reset($this->_collection);
    }

    protected function _getKeys()
    {
        return array_keys($this->_hashMap);
    }

    protected function put($key, $value)
    {

        if ($this->has($key)) {
            throw new \Exception('Key `' . $key . '` already in use');
        }
        $index = count($this->_collection);

        $this->_collection[$index] = $value;

        $key = IdHelper::formatId($key);
        $this->_hashMap[$key] = $index;
        $this->length++;

        return $index;
    }

    protected function has($key)
    {
        $key = IdHelper::formatId($key);

        return isset($this->_hashMap[$key]);
    }

    /**
     * @param $key
     *
     * @return BasicObject
     */
    protected function getByKey($key)
    {
        $index = $this->getObjectIndexByKey($key);
        if ($index !== null) {
            if (isset($this->_collection[$index])) {
                return $this->_collection[$index];
            }
        }

        return null;
    }

    protected function getObjectIndexByKey($key)
    {
        $key = IdHelper::formatId($key);
        if (isset($this->_hashMap[$key])) {
            return $this->_hashMap[$key];
        }

        return null;
    }

    protected function getObjectKeyByIndex($index)
    {
        return array_search($index, $this->_hashMap);
    }

    protected function deleteByKey($key)
    {

        $key = IdHelper::formatId($key);
        $index = $this->getObjectIndexByKey($key);
        if ($index !== null) {
            if (isset($this->_collection[$index])) {
                unset($this->_collection[$index]);
                unset($this->_hashMap[$key]);
                $this->length--;

                return true;
            }
        }

        return false;
    }

}
