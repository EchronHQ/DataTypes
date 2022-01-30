<?php
declare(strict_types=1);

namespace Echron\DataTypes\Observable\Context;

class PropertyChangeContext extends Context
{
    private $before, $after;
    private string $property;

    public function __construct(string $property, $before, $after)
    {
        $this->property = $property;
        $this->before = $before;
        $this->after = $after;
    }

    public function getProperty(): string
    {
        return $this->property;
    }

    public function getBefore()
    {
        return $this->before;
    }

    public function getAfter()
    {
        return $this->after;
    }
}
