<?php
declare(strict_types=1);

class IdObjectTest extends \PHPUnit\Framework\TestCase
{
    public function testWithId()
    {
        $obj = new \DataTypes\IdObject(12);
        $this->assertTrue($obj->hasId());
        $this->assertEquals(12, $obj->getId());
    }

    public function testWithoutId()
    {
        $obj = new \DataTypes\IdObject();
        $this->assertFalse($obj->hasId());

    }

    public function testObserver_NormalChange()
    {

    }

    public function testObserver_Same()
    {

    }
}
