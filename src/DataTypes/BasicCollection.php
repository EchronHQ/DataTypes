<?php
declare(strict_types=1);

namespace Echron\DataTypes;

abstract class BasicCollection implements \IteratorAggregate, \Countable, \JsonSerializable
{
    private $collection;
    private $index = 0;

    public function __construct()
    {
        $this->collection = [];
    }

    protected final function addToCollection($data): int
    {
        $index = $this->index;
        $this->collection[$index] = $data;

        $this->index++;

        return $index;
    }

    protected final function removeFromCollection(int $index)
    {
        unset($this->collection[$index]);
    }

    protected final function getByIndex(int $index)
    {
        return $this->collection[$index];
    }

    public final function count(): int
    {
        return count($this->collection);
    }

    function jsonSerialize(): array
    {
        //TODO: good idea to remove keys?
        $data = [];
        /** @var IdCodeObject $item */
        foreach ($this->collection as $item) {
            $data[] = $item->jsonSerialize();
        }

        return $data;
    }

    public function getIterator(): \ArrayIterator
    {
        //TODO: is it possible to not return a new iterator on every call? this is not working for nested iterations!
        //        if (\is_null($this->itterator)) {
        //            $this->itterator = new \ArrayIterator($this->collection);
        //        }
        //        $this->itterator->rewind();
        return new \ArrayIterator($this->collection);
    }

}
