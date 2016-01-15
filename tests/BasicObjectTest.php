<?php
declare(strict_types = 1);


class BasicObjectTest extends \PHPUnit_Framework_TestCase
{
    public function testSetUndefinedProperty()
    {
        $this->setExpectedException('\Exception');
        $object = new \DataTypes\BasicObject();
        /** @noinspection PhpUndefinedFieldInspection */
        $object->property = 'value';

    }

    public function testGetUndefinedProperty()
    {
        $this->setExpectedException('\Exception');
        $object = new \DataTypes\BasicObject();
        /** @noinspection PhpUndefinedFieldInspection */
        /** @noinspection PhpUnusedLocalVariableInspection */
        $value = $object->property;
    }

   
}
