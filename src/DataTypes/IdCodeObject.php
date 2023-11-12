<?php
declare(strict_types=1);

namespace Echron\DataTypes;

use Echron\DataTypes\Observable\Context\PropertyChangeContext;
use Echron\Tools\Normalize\NormalizeConfig;
use Echron\Tools\Normalize\Normalizer;

class IdCodeObject extends IdObject
{
    protected int|null $code_max_length = null;
    private string|null $code = null;
    protected NormalizeConfig|null $keyFormatConfig = null;

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

    public function setCode(string $code): void
    {
        $before = $this->code;
        if ($this->keyFormatConfig === null) {
            $this->keyFormatConfig = new NormalizeConfig();
            if ($this->code_max_length !== null) {
                $this->keyFormatConfig->setMaxLength($this->code_max_length);
            }
        }
        $code = Normalizer::normalize($code, $this->keyFormatConfig);


        if ($code !== $before) {
            $this->code = $code;
            $this->notify(new PropertyChangeContext('code', $before, $this->getCode()));
        }

    }

}
