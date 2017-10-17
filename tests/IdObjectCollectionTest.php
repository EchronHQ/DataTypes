<?php
declare(strict_types=1);

class IdObjectCollectionTest extends \PHPUnit\Framework\TestCase
{
    public function testCreate()
    {
        $collection = new \DataTypes\IdObjectCollection();
        $this->assertCount(0, $collection);
    }

    public function testAdd()
    {

        $collection = new \DataTypes\IdObjectCollection();

        $object = new \DataTypes\IdObject(1);
        $collection->add($object);

        $this->assertCount(1, $collection);

        $this->assertTrue($collection->hasId(1));
        $this->assertEquals([$object->getId()], $collection->getIds());

        $object = $collection->getById(1);
        $this->assertInstanceOf(\DataTypes\IdObject::class, $object);
        $this->assertEquals(1, $object->getId());
    }

    public function testRemove()
    {
        $collection = new \DataTypes\IdObjectCollection();

        $object = new \DataTypes\IdObject(1);
        $collection->add($object);

        $this->assertTrue($collection->hasId(1));

        $collection->removeById(1);

        $this->assertFalse($collection->hasId(1));
        $this->assertEquals([], $collection->getIds());
        $this->assertFalse($collection->hasId(1));
        $this->assertCount(0, $collection);

    }

    public function testLoopOver()
    {
        $collection = new \DataTypes\IdObjectCollection();

        $ids = [
            100,
            200,
            300,
        ];

        foreach ($ids as $id) {
            $collection->add(new \DataTypes\IdObject($id));
        }

        $i = 0;
        foreach ($collection as $item) {
            $this->assertInstanceOf(\DataTypes\IdObject::class, $item);
            $this->assertEquals($ids[$i], $item->getId());
            $i++;
        }

        for ($i = 0; $i < count($collection); $i++) {
            $id = $ids[$i];
            $object = $collection->getById($id);
            $this->assertInstanceOf(\DataTypes\IdObject::class, $object);
            $this->assertEquals($id, $object->getId());
        }
    }

    public function testLoopOver_AfterRemove()
    {
        $collection = new \DataTypes\IdObjectCollection();

        $ids = [
            100,
            200,
            300,
        ];

        foreach ($ids as $id) {
            $collection->add(new \DataTypes\IdObject($id));
        }

        $collection->removeById(200);
        $this->assertEquals(2, count($collection));

        $ids = [
            100,
            300,
        ];
        $i = 0;
        foreach ($collection as $item) {
            $this->assertInstanceOf(\DataTypes\IdObject::class, $item);
            $this->assertEquals($ids[$i], $item->getId());
            $i++;
        }

        for ($i = 0; $i < count($collection); $i++) {
            $id = $ids[$i];
            $object = $collection->getById($id);
            $this->assertInstanceOf(\DataTypes\IdObject::class, $object);
            $this->assertEquals($id, $object->getId());
        }
    }

    public function disabled_testIdObjectCollection_ChangeId()
    {

        $object = new \DataTypes\IdObject(20);

        $collection = new \DataTypes\IdObjectCollection();
        $collection->add($object);

        $this->assertInstanceOf(\DataTypes\IdObject::class, $collection->getById(20));

        $object->setId(30);

        $this->assertFalse($collection->hasId(20));
        $this->assertInstanceOf(\DataTypes\IdObject::class, $collection->getById(30));

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
