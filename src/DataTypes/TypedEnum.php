<?php
declare(strict_types=1);

namespace Echron\DataTypes;

abstract class TypedEnum extends BasicObject
{
    private static $instancedValues;

    private $value;
    private $name;

    private function __construct(string $value, string $name)
    {
        $this->value = $value;
        $this->name = $name;
    }

    public static function fromValue($value)
    {
        $value = (string)$value;

        return self::_fromGetter('getValue', $value);
    }

    private static function _fromGetter(string $getter, string $value)
    {
        $reflectionClass = new \ReflectionClass(get_called_class());
        $methods = $reflectionClass->getMethods(\ReflectionMethod::IS_STATIC | \ReflectionMethod::IS_PUBLIC);
        $className = get_called_class();

        foreach ($methods as $method) {
            if (self::isEnumOrExtensionOfEnum($method->class, $className)) {
                $enumItem = $method->invoke(null);

                if ($enumItem instanceof $className && $enumItem->$getter() === $value) {
                    return $enumItem;
                }
            }
        }

        throw new \OutOfRangeException('Enum value "' . $value . '" not found');
    }

    private static function isEnumOrExtensionOfEnum(string $methodClass, string $className): bool
    {
        if ($methodClass === BasicObject::class || $methodClass === TypedEnum::class) {
            return false;
        }

        return $methodClass === $className || \is_subclass_of($className, $methodClass);
    }

    public static function fromName(string $value)
    {
        return self::_fromGetter('getName', $value);
    }

    protected static function _create($value): TypedEnum
    {
        $value = (string)$value;
        if (self::$instancedValues === null) {
            self::$instancedValues = [];
        }

        $className = get_called_class();

        if (!isset(self::$instancedValues[$className])) {
            self::$instancedValues[$className] = [];
        }

        if (!isset(self::$instancedValues[$className][$value])) {
            $debugTrace = debug_backtrace();
            $lastCaller = array_shift($debugTrace);

            while ($lastCaller['class'] !== $className && count($debugTrace) > 0) {
                $lastCaller = array_shift($debugTrace);
            }

            self::$instancedValues[$className][$value] = new static($value, (string)$lastCaller['function']);
        }

        return self::$instancedValues[$className][$value];
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
