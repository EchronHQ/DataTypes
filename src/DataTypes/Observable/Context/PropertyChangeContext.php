<?php
declare(strict_types = 1);
namespace DataTypes\Observable\Context;

class PropertyChangeContext extends Context
{
    private $property, $before, $after;

    public function __construct($property, $before, $after)
    {
        $this->property = $property;
        $this->before = $before;
        $this->after = $after;
    }

    public function getProperty()
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
