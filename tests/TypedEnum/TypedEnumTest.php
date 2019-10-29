<?php
declare(strict_types=1);

require_once 'TypedEnumImpl.php';
require_once 'ExtendedTypedEnumImpl.php';

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

        $this->expectExceptionMessage('Enum value "nonexistingvalue" not found');
        $enum = TypedEnumImpl::fromValue('nonexistingvalue');
    }

    public function testInvalidName()
    {
        $this->expectException(OutOfRangeException::class);

        $this->expectExceptionMessage('Enum value "nonexistingname" not found');
        $enum = TypedEnumImpl::fromName('nonexistingname');
    }

    public function testGetFromNameAndValue()
    {
        $enum = TypedEnumImpl::fromValue(0);
        $this->assertEquals($enum, TypedEnumImpl::OptionZero());

        $enum = TypedEnumImpl::fromName('OptionZero');
        $this->assertEquals($enum, TypedEnumImpl::OptionZero());

        $enum = TypedEnumImpl::fromValue(1);
        $this->assertEquals($enum, TypedEnumImpl::OptionOne());

        $enum = TypedEnumImpl::fromName('OptionOne');
        $this->assertEquals($enum, TypedEnumImpl::OptionOne());
    }

    public function testExtended()
    {
        $enum = ExtendedTypedEnumImpl::fromValue(1);
        $this->assertEquals($enum, ExtendedTypedEnumImpl::OptionOne());

        $enum = ExtendedTypedEnumImpl::fromName('OptionOne');
        $this->assertEquals($enum, ExtendedTypedEnumImpl::OptionOne());

        $enum = ExtendedTypedEnumImpl::fromValue(2);
        $this->assertEquals($enum, ExtendedTypedEnumImpl::OptionTwo());

        $enum = ExtendedTypedEnumImpl::fromName('OptionTwo');
        $this->assertEquals($enum, ExtendedTypedEnumImpl::OptionTwo());
    }

    public function testInvalidNameExtended()
    {
        $this->expectException(OutOfRangeException::class);

        $this->expectExceptionMessage('Enum value "nonexistingname2" not found');
        $enum = ExtendedTypedEnumImpl::fromName('nonexistingname2');
    }

    public function testGetFromEmptyValue()
    {
        $this->expectException(OutOfRangeException::class);

        $this->expectExceptionMessage('Enum value "" not found');

        $enum = TypedEnumImpl::fromValue('');
        $this->assertEquals($enum, TypedEnumImpl::OptionZero());
    }

    public function testGetFromEmptyName()
    {
        $this->expectException(OutOfRangeException::class);

        $this->expectExceptionMessage('Enum value "" not found');

        $enum = TypedEnumImpl::fromName('');
        $this->assertEquals($enum, TypedEnumImpl::OptionZero());
    }
}
