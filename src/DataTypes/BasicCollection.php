<?php
declare(strict_types=1);

namespace Echron\DataTypes;

abstract class BasicCollection implements \IteratorAggregate, \Countable, \JsonSerializable
{
    private array $collection = [];
    private int $index = 0;

    public function __construct()
    {
    }

    protected final function addToCollection(mixed $data): int
    {
        $index = $this->index;
        $this->collection[$index] = $data;

        $this->index++;

        return $index;
    }

    protected final function removeFromCollection(int $index): void
    {
        unset($this->collection[$index]);
    }

    protected final function getByIndex(int $index): mixed
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
        //        if (\is_null($this->iterator)) {
        //            $this->iterator = new \ArrayIterator($this->collection);
        //        }
        //        $this->iterator->rewind();
        return new \ArrayIterator($this->collection);
    }

}
