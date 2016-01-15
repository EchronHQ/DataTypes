<?php
declare(strict_types = 1);
namespace DataTypes;

class IdCollection extends BasicObject implements \Iterator, \Countable, \JsonSerializable
{
    use IdCollectionTrait;

    public function count()
    {
        return $this->getLength();
    }

    function jsonSerialize()
    {
        //TODO: good idea to remove keys?
        return array_values($this->_collection);
    }
}
