<?php
declare(strict_types = 1);

require 'impl/IdObjectImplementation.php';

class IdObjectTest extends \PHPUnit_Framework_TestCase
{
    public function testWithId()
    {
        $obj = new \IdObjectImplementation(12);
        $this->assertTrue($obj->hasId());
        $this->assertEquals(12, $obj->getId());
    }

    public function testWithoutId()
    {
        $obj = new \IdObjectImplementation();
        $this->assertFalse($obj->hasId());

    }
}
