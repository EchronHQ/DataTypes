<?php
declare(strict_types = 1);
namespace DataTypes;

use DataTypes\Exception\IdAlreadyInCollectionException;
use DataTypes\Exception\NotInCollectionException;

trait IdCollectionTrait
{
    protected $_hashMap = [];
    protected $_collection = [];
    private $length = 0;

    public function length():int
    {
        return $this->getLength();
    }

    protected function getLength():int
    {
        return $this->length;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @deprecated
     */
    public function current()
    {
        // throw new \Exception('This method should be implemented');

        return $this->_current();
    }

    protected function _current()
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
    public function valid():bool
    {
        return !!current($this->_collection);
    }

    //TODO: every implementing class should have the function current, force this

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

    public final function getIds():array
    {
        return array_keys($this->_hashMap);
    }

    protected function put(int $id, $value)
    {

        if ($this->hasId($id)) {
            throw new IdAlreadyInCollectionException('Id "' . $id . '" already in collection');
        }
        $index = count($this->_collection);

        $this->_collection[$index] = $value;

        $this->_hashMap[$id] = $index;
        $this->length++;

        return $index;
    }

    public function hasId(int $id):bool
    {

        return isset($this->_hashMap[$id]);
    }

    protected function getById(int $id)
    {
        if (!$this->hasId($id)) {

            throw new NotInCollectionException('id "' . $id . '" not in collection (' . implode(', ', array_keys($this->_hashMap)) . ' - ' . get_class($this) . ')');

        }

        $index = $this->getObjectIndexById($id);
        if (!isset($this->_collection[$index])) {
            throw new NotInCollectionException('no object for id "' . $id . '" not in collection (' . implode(', ', array_keys($this->_hashMap)) . ' - ' . get_class($this) . ')');
        }

        return $this->_collection[$index];

    }

    protected function getObjectIndexById(int $id):int
    {

        if (isset($this->_hashMap[$id])) {
            return $this->_hashMap[$id];
        }

        throw new NotInCollectionException('id "' . $id . '" not in collection');
    }

    protected function getObjectIdByIndex(int $index):int
    {
        return array_search($index, $this->_hashMap);
    }

    protected function removeById(int $id)
    {
        //TODO: update all hashmaps or not? or just remove the object from collection and the key from the hashmap (do we have 'holes' in our hashmap?)

        if ($this->hasId($id)) {
            $index = $this->getObjectIndexById($id);
            if (isset($this->_collection[$index])) {
                unset($this->_collection[$index]);
                unset($this->_hashMap[$id]);
                $this->length--;

                return true;
            }
        }

        return false;
    }

    protected function _updateId(int $before, int $after)
    {

        $this->_hashMap = self::updateCollectionId($this->_hashMap, $before, $after);
    }

    protected static function updateCollectionId($collection, $before, $after)
    {

        if (!isset($collection[$before])) {

            throw new \Exception('Unable to update id from "' . $before . '" to "' . $after . '", the before id does not exist in collection (available: ' . implode(', ', $collection) . ')');
        }
        if (isset($collection[$after])) {
            throw new \Exception('Unable to update id from "' . $before . '" to "' . $after . '", the after id already exist in collection (available: ' . implode(', ', $collection) . ')');
        }

        $keys = array_keys($collection);
        $keys[array_search($before, $keys)] = $after;

        return array_combine($keys, $collection);

    }
}
