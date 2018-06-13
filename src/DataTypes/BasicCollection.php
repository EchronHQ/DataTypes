<?php
declare(strict_types=1);

namespace Echron\DataTypes;

abstract class BasicCollection implements \Iterator, \Countable, \JsonSerializable
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

    public final function next(): void
    {
        next($this->collection);
    }

    public final function key()
    {
        return key($this->collection);
    }

    public final function valid(): bool
    {
        return !!current($this->collection);
    }

    public final function rewind(): void
    {
        reset($this->collection);
    }

    public function current()
    {
        return current($this->collection);
    }
}