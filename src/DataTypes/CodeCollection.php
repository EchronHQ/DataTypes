<?php
declare(strict_types=1);

namespace Echron\DataTypes;

use Echron\Tools\Normalize\NormalizeConfig;

/**
 * @template TValue
 *
 * @extends BasicCollection<TValue>
 */
class CodeCollection extends BasicCollection
{
    private KeyValueStore $codeValueStore;

    public function __construct(NormalizeConfig|null $normalizeConfig = null)
    {
        parent::__construct();
        $this->codeValueStore = new KeyValueStore($normalizeConfig);
    }

    /**
     * @param string $code
     * @param TValue $value
     * @return void
     * @throws Exception\ObjectAlreadyInCollectionException
     */
    public function add(string $code, mixed $value): void
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

    /**
     * @param string $code
     * @return TValue
     * @throws Exception\NotInCollectionException
     */
    public function getByCode(string $code)
    {
        $index = $this->codeValueStore->getValueByKey($code);

        return $this->getByIndex($index);
    }

    public function hasCode(string $code): bool
    {
        return $this->codeValueStore->hasKey($code);
    }

    /**
     * @return string[]
     */
    public function getCodes(): array
    {
        return $this->codeValueStore->getKeys();
    }
}
