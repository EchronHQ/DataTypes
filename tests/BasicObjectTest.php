<?php

class BasicObjectTest extends PHPUnit_Framework_TestCase
{
    public function testGetMethod()
    {
        $this->setExpectedException(Exception::class);
        $basicObject = new \DataTypes\BasicObject();
        $data = $basicObject->useGetMethod;;
    }

    public function testSetMethod()
    {
        $this->setExpectedException(Exception::class);
        $basicObject = new \DataTypes\BasicObject();
        $basicObject->useSetMethod = 12;
    }
}
