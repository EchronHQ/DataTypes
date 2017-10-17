<?php
declare(strict_types=1);

class BasicObjectTest extends \PHPUnit\Framework\TestCase
{
    public function testSetUndefinedProperty()
    {
        $this->expectException('\Exception');
        $object = new \DataTypes\BasicObject();
        /** @noinspection PhpUndefinedFieldInspection */
        $object->property = 'value';

    }

    public function testGetUndefinedProperty()
    {
        $this->expectException('\Exception');
        $object = new \DataTypes\BasicObject();
        /** @noinspection PhpUndefinedFieldInspection */
        /** @noinspection PhpUnusedLocalVariableInspection */
        $value = $object->property;
    }

}
