<?php
declare(strict_types = 1);

require 'impl/IdCodeObjectImplementation.php';
require 'impl/IdCodeObjectCollectionImplementation.php';

class IdCodeObjectCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $collection = new IdCodeObjectCollectionImplementation();
        $this->assertEquals(0, $collection->length());
    }

    public function testIdCodeObjectCollection_RemoveById()
    {

        $object1 = new IdCodeObjectImplementation(20, 'object_code');

        $collection = new IdCodeObjectCollectionImplementation();
        $collection->add($object1);

        $this->assertEquals([20], $collection->getIds());
        $this->assertEquals(['object_code'], $collection->getCodes());
        $this->assertInstanceOf(IdCodeObjectImplementation::class, $collection->getById(20));
        $this->assertInstanceOf(IdCodeObjectImplementation::class, $collection->getByCode('object_code'));
        $this->assertEquals(1, $collection->length());

        $collection->removeById(20);

        $this->assertEquals([], $collection->getIds());
        $this->assertEquals([], $collection->getCodes());
        $this->assertFalse($collection->hasId(20));
        $this->assertFalse($collection->hasCode('object_code'));
        $this->assertEquals(0, $collection->length());

    }

    public function testIdCodeObjectCollection_RemoveByCode()
    {

        $object1 = new IdCodeObjectImplementation(20, 'object_code');

        $collection = new IdCodeObjectCollectionImplementation();
        $collection->add($object1);

        $this->assertEquals([20], $collection->getIds());
        $this->assertEquals(['object_code'], $collection->getCodes());
        $this->assertInstanceOf(IdCodeObjectImplementation::class, $collection->getById(20));
        $this->assertInstanceOf(IdCodeObjectImplementation::class, $collection->getByCode('object_code'));
        $this->assertEquals(1, $collection->length());

        $collection->removeByCode('object_code');

        $this->assertEquals([], $collection->getIds());
        $this->assertEquals([], $collection->getCodes());
        $this->assertFalse($collection->hasId(20));
        $this->assertFalse($collection->hasCode('object_code'));
        $this->assertEquals(0, $collection->length());

    }

    public function testIdCodeObjectCollection_ChangeIdAndCode()
    {

        $object = new IdCodeObjectImplementation(20, 'object_code');

        $collection = new IdCodeObjectCollectionImplementation();
        $collection->add($object);

        $this->assertEquals([20], $collection->getIds());
        $this->assertEquals(['object_code'], $collection->getCodes());

        $this->assertInstanceOf(IdCodeObjectImplementation::class, $collection->getById(20));
        $this->assertInstanceOf(IdCodeObjectImplementation::class, $collection->getByCode('object_code'));

        $object->setId(10);
        $object->setCode('object_code2');

        $this->assertFalse($collection->hasId(20));
        $this->assertFalse($collection->hasCode('object_code'));

        $this->assertInstanceOf(IdCodeObjectImplementation::class, $collection->getById(10));
        $this->assertInstanceOf(IdCodeObjectImplementation::class, $collection->getByCode('object_code2'));

        $this->assertEquals([10], $collection->getIds());
        $this->assertEquals(['object_code2'], $collection->getCodes());

    }
}
