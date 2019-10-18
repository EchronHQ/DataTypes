<?php
declare(strict_types=1);

require_once 'TypedEnumImpl.php';

class TypedEnumTest extends \PHPUnit\Framework\TestCase
{
    public function testValue()
    {
        $enum = TypedEnumImpl::OptionOne();

        $this->assertEquals(1, $enum->getValue());
    }

    public function testName()
    {
        $enum = TypedEnumImpl::OptionOne();

        $this->assertEquals('OptionOne', $enum->getName());
    }

    public function testInvalidValue()
    {
        $this->expectException(OutOfRangeException::class);

        $this->expectExceptionMessage('nonexistingvalue');
        $enum = TypedEnumImpl::fromValue('Enum value "nonexistingvalue" not found');
    }

    public function testInvalidName()
    {
        $this->expectException(OutOfRangeException::class);

        $this->expectExceptionMessage('nonexistingname');
        $enum = TypedEnumImpl::fromName('Enum value "nonexistingname" not found');
    }
}
