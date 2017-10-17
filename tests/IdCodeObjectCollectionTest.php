<?php
declare(strict_types=1);

class IdCodeObjectCollectionTest extends \PHPUnit\Framework\TestCase
{
    public function testCreate()
    {
        $collection = new \DataTypes\IdCodeObjectCollection();
        $this->assertCount(0, $collection);
    }

    public function testIdCodeObjectCollection_RemoveById()
    {

        $object1 = new \DataTypes\IdCodeObject(20, 'object_code');

        $collection = new \DataTypes\IdCodeObjectCollection();
        $collection->add($object1);

        $this->assertEquals([20], $collection->getIds());
        $this->assertEquals(['object_code'], $collection->getCodes());
        $this->assertInstanceOf(\DataTypes\IdCodeObject::class, $collection->getById(20));
        $this->assertInstanceOf(\DataTypes\IdCodeObject::class, $collection->getByCode('object_code'));
        $this->assertCount(1, $collection);

        $removed = $collection->removeById(20);

        $this->assertEquals([], $collection->getIds());
        $this->assertEquals([], $collection->getCodes());
        $this->assertFalse($collection->hasId(20));
        $this->assertFalse($collection->hasCode('object_code'));
        $this->assertCount(0, $collection);

        /**
         * Add with same code again
         */
        $object2 = new \DataTypes\IdCodeObject(20, 'object_code');

        $collection = new \DataTypes\IdCodeObjectCollection();
        $collection->add($object2);

    }

    public function testIdCodeObjectCollection_RemoveByCode()
    {

        $object1 = new \DataTypes\IdCodeObject(20, 'object_code');

        $collection = new \DataTypes\IdCodeObjectCollection();
        $collection->add($object1);

        $this->assertEquals([20], $collection->getIds());
        $this->assertEquals(['object_code'], $collection->getCodes());
        $this->assertInstanceOf(\DataTypes\IdCodeObject::class, $collection->getById(20));
        $this->assertInstanceOf(\DataTypes\IdCodeObject::class, $collection->getByCode('object_code'));
        $this->assertCount(1, $collection);

        $collection->removeByCode('object_code');

        $this->assertEquals([], $collection->getIds());
        $this->assertEquals([], $collection->getCodes());
        $this->assertFalse($collection->hasId(20));
        $this->assertFalse($collection->hasCode('object_code'));
        $this->assertCount(0, $collection);

    }

    public function disabled_testIdCodeObjectCollection_ChangeIdAndCode()
    {

        $object = new \DataTypes\IdCodeObject(20, 'object_code');

        $collection = new \DataTypes\IdCodeObjectCollection();
        $collection->add($object);

        $this->assertEquals([20], $collection->getIds());
        $this->assertEquals(['object_code'], $collection->getCodes());

        $this->assertInstanceOf(\DataTypes\IdCodeObject::class, $collection->getById(20));
        $this->assertInstanceOf(\DataTypes\IdCodeObject::class, $collection->getByCode('object_code'));

        $object->setId(10);
        $object->setCode('object_code2');

        $this->assertFalse($collection->hasId(20));
        $this->assertFalse($collection->hasCode('object_code'));

        $this->assertInstanceOf(\DataTypes\IdCodeObject::class, $collection->getById(10));
        $this->assertInstanceOf(\DataTypes\IdCodeObject::class, $collection->getByCode('object_code2'));

        $this->assertEquals([10], $collection->getIds());
        $this->assertEquals(['object_code2'], $collection->getCodes());

    }
}
