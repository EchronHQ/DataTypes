<?php
declare(strict_types = 1);
namespace DataTypes;

use DataTypes\Observable\Context\PropertyChangeContext;
use DataTypes\Observable\Observable;
use DataTypes\Observable\ObservableTrait;

class IdObject extends BasicObject implements Observable
{
    use ObservableTrait;
    protected $id_max_length = -1;
    private $id;

    public function __construct(int $id = null)
    {
        if ($id !== null) {
            $this->setId($id);
        }

    }

    public function getId():int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        if ($id !== $this->id) {
            $before = $this->id;
            $this->id = $id;

            $this->notify(new PropertyChangeContext('id', $before, $id));
        }

    }

    public function hasId():bool
    {
        return $this->id !== null;

    }

}
