<?php
declare(strict_types=1);

namespace Echron\DataTypes;

use Echron\DataTypes\Observable\Context\PropertyChangeContext;
use Echron\DataTypes\Observable\Observable;
use Echron\DataTypes\Observable\ObservableTrait;

class IdObject extends BasicObject implements Observable
{
    use ObservableTrait;

    protected int $id_max_length = -1;
    private int $id = -1;

    public function __construct(int|null $id = null)
    {
        if ($id !== null) {
            $this->setId($id);
        }

    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        if ($id !== $this->id) {
            $before = $this->id;
            $this->id = $id;

            $this->notify(new PropertyChangeContext('id', $before, $id));
        }

    }

    public function hasId(): bool
    {
        return $this->id > -1;

    }

}
