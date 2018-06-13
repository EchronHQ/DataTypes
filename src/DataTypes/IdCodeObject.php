<?php
declare(strict_types=1);

namespace Echron\DataTypes;

use Echron\DataTypes\Helper\KeyHelper;
use Echron\DataTypes\Observable\Context\PropertyChangeContext;

class IdCodeObject extends IdObject
{
    protected $code_max_length = -1;
    private $code;

    public function __construct(int $id, string $code)
    {

        parent::__construct($id);
        $this->setCode($code);
    }

    public function __toString(): string
    {
        return $this->getCode() . ' (id: ' . $this->getId() . ')';
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code)
    {
        $before = $this->code;
        $code = KeyHelper::formatKey($code, false, $this->code_max_length);

        if ($code !== $before) {
            $this->code = $code;
            $this->notify(new PropertyChangeContext('code', $before, $this->getCode()));
        }

    }

}
