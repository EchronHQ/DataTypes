<?php
declare(strict_types = 1);

require 'impl/IdObjectImplementation.php';
require 'impl/IdObjectCollectionImplementation.php';

class IdObjectCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $collection = new \IdObjectCollectionImplementation();
        $this->assertEquals(0, $collection->length());
    }

    public function testAdd()
    {

        $collection = new \IdObjectCollectionImplementation();

        $object = new \IdObjectImplementation(1, '');
        $collection->add($object);

        $this->assertEquals(1, $collection->length());
        $this->assertTrue($collection->hasId(1));
        $this->assertEquals([1], $collection->getIds());

        $object = $collection->getById(1);
        $this->assertInstanceOf(\IdObjectImplementation::class, $object);
        $this->assertEquals(1, $object->getId());
    }

    public function testRemove()
    {
        $collection = new \IdObjectCollectionImplementation();

        $object = new \IdObjectImplementation(1, '');
        $collection->add($object);

        $this->assertTrue($collection->hasId(1));

        $collection->delete(1);

        $this->assertFalse($collection->hasId(1));
        $this->assertEquals([], $collection->getIds());
        $this->assertFalse($collection->hasId(1));
        $this->assertEquals(0, $collection->length());
    }

    public function testLoopOver()
    {
        $collection = new \IdObjectCollectionImplementation();

        $ids = [
            100,
            200,
            300,
        ];

        foreach ($ids as $id) {
            $collection->add(new \IdObjectImplementation($id, ''));
        }

        $i = 0;
        foreach ($collection as $item) {
            $this->assertInstanceOf(\IdObjectImplementation::class, $item);
            $this->assertEquals($ids[$i], $item->getId());
            $i++;
        }

        for ($i = 0; $i < $collection->length(); $i++) {
            $id = $ids[$i];
            $object = $collection->getById($id);
            $this->assertInstanceOf(\IdObjectImplementation::class, $object);
            $this->assertEquals($id, $object->getId());
        }
    }

    public function testLoopOver_AfterRemove()
    {
        $collection = new \IdObjectCollectionImplementation();

        $ids = [
            100,
            200,
            300,
        ];

        foreach ($ids as $id) {
            $collection->add(new \IdObjectImplementation($id, ''));
        }

        $collection->delete(200);
        $this->assertEquals(2, $collection->length());

        $ids = [
            100,
            300,
        ];
        $i = 0;
        foreach ($collection as $item) {
            $this->assertInstanceOf(\IdObjectImplementation::class, $item);
            $this->assertEquals($ids[$i], $item->getId());
            $i++;
        }

        for ($i = 0; $i < $collection->length(); $i++) {
            $id = $ids[$i];
            $object = $collection->getById($id);
            $this->assertInstanceOf(\IdObjectImplementation::class, $object);
            $this->assertEquals($id, $object->getId());
        }
    }

    public function testIdObjectCollection_ChangeId()
    {

        $object = new \IdObjectImplementation(20, '');

        $collection = new \IdObjectCollectionImplementation();
        $collection->add($object);

        $this->assertInstanceOf(\IdObjectImplementation::class, $collection->getById(20));

        $object->setId(30);

        $this->assertFalse($collection->hasId(20));
        $this->assertInstanceOf(\IdObjectImplementation::class, $collection->getById(30));

    }

//    public function testIdCodeObjectCollection_ChangeIdAndCode()
//    {
//
//        $object = new MagentoEntityType(20, 'catalog_product');
//
//        $collection = new MagentoEntityTypeCollection();
//        $collection->addEntityType($object);
//
//        $this->assertEquals([20], $collection->getIds());
//        $this->assertEquals(['catalog_product'], $collection->getCodes());
//
//        $this->assertInstanceOf(MagentoEntityType::class, $collection->getEntityType(20));
//        $this->assertInstanceOf(MagentoEntityType::class, $collection->getEntityTypeByCode('catalog_product'));
//
//        $object->setId(10);
//        $object->setCode('catalog_category');
//
//        $this->assertFalse($collection->hasEntityType(20));
//        $this->assertFalse($collection->hasEntityTypeCode('catalog_product'));
//
//        $this->assertInstanceOf(MagentoEntityType::class, $collection->getEntityType(10));
//        $this->assertInstanceOf(MagentoEntityType::class, $collection->getEntityTypeByCode('catalog_category'));
//
//        $this->assertEquals([10], $collection->getIds());
//        $this->assertEquals(['catalog_category'], $collection->getCodes());
//
//    }
}
