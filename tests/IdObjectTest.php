<?php
declare(strict_types=1);

class IdObjectTest extends \PHPUnit\Framework\TestCase
{
    public function testWithId()
    {
        $obj = new \Echron\DataTypes\IdObject(12);
        $this->assertTrue($obj->hasId());
        $this->assertEquals(12, $obj->getId());
    }

    public function testWithoutId()
    {
        $obj = new \Echron\DataTypes\IdObject();
        $this->assertFalse($obj->hasId());
    }

    public function testObserver_NormalChange()
    {
        $this->assertTrue(true);
    }

    public function testObserver_Same()
    {
        $this->assertTrue(true);
    }
}
