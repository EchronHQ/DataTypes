<?php
namespace DataTypes;

class BasicCollection
{
    protected $_hashMap = [];
    protected $_collection = [];
    protected $_currentKeyIndex = null;
    protected $_length = 0;

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current()
    {
        if ($this->_currentKeyIndex === null) {
            return null;
        }
        //TODO: return current($this->_collection);
        $key = $this->_hashMap[$this->_currentKeyIndex];

        return $this->_collection[$key];
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        //TODO: next($this->_collection);
        $this->_currentKeyIndex++;
    }


    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
       
        if ($this->_currentKeyIndex === null) {
            return null;
        }

        return $this->_hashMap[$this->_currentKeyIndex];
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
        return isset($this->_hashMap[$this->_currentKeyIndex]);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        $this->_currentKeyIndex = 0;
    }

    protected function getLength()
    {
        return $this->_length;
    }

    protected function _getKeys()
    {
        return $this->_hashMap;
    }

    /**
     * @param $key
     *
     * @return BasicObject
     */
    protected function _get($key)
    {
        $key = BasicObject::formatId($key);
        if (isset($this->_collection[$key])) {
            return $this->_collection[$key];
        }

        return null;
    }

    protected function _delete($key)
    {
        $key = BasicObject::formatId($key);
        if (isset($this->_collection[$key])) {
            unset($this->_collection[$key]);
            $keyIndex = array_search($key, $this->_hashMap);
            unset($this->_hashMap[$keyIndex]);
            $this->_hashMap = array_values($this->_hashMap);
            $this->_length--;

            return true;
        }

        return false;
    }

    protected function _put($key, $value)
    {
        $key = BasicObject::formatId($key);
        if (isset($this->_collection[$key])) {
            throw new \Exception('Object `' . $key . '` already in use');
        }
        $this->_hashMap[] = $key;
        $this->_collection[$key] = $value;
        $this->_length++;

        return $key;
    }

    protected function _has($key)
    {
        $key = BasicObject::formatId($key);

        return isset($this->_collection[$key]);
    }
}
