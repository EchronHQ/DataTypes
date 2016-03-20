<?php
declare(strict_types = 1);
namespace DataTypes;

class IdCollection extends BasicObject implements \Iterator, \Countable, \JsonSerializable
{
    use IdCollectionTrait;

    public function count():int
    {
        return $this->getLength();
    }

    function jsonSerialize():array
    {
        //TODO: good idea to remove keys?
        return array_values($this->_collection);
    }
}
