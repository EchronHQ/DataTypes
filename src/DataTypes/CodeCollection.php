<?php
declare(strict_types=1);

namespace Echron\DataTypes;

use Echron\Tools\Normalize\NormalizeConfig;

class CodeCollection extends BasicCollection
{
    private KeyValueStore $codeValueStore;

    public function __construct(NormalizeConfig $normalizeConfig = null)
    {
        parent::__construct();
        $this->codeValueStore = new KeyValueStore($normalizeConfig);

    }

    public function add(string $code, $value): void
    {
        $index = $this->addToCollection($value);
        $this->codeValueStore->add($code, $index);

    }

    public function removeByCode(string $code): void
    {
        $index = $this->codeValueStore->getValueByKey($code);

        $this->codeValueStore->removeByValue($index);

        $this->removeFromCollection($index);
    }

    public function getByCode(string $code)
    {
        $index = $this->codeValueStore->getValueByKey($code);

        return $this->getByIndex($index);
    }

    public function hasCode(string $code): bool
    {
        return $this->codeValueStore->hasKey($code);
    }

    public function getCodes(): array
    {
        return $this->codeValueStore->getKeys();
    }
}
