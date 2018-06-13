<?php
declare(strict_types=1);

class KeyValueStoreTest extends \PHPUnit\Framework\TestCase
{
    public function testAdd()
    {
        $key = 'key';
        $value = 'value';

        $store = new \Echron\DataTypes\KeyValueStore();
        $store->add($key, $value);

        $this->assertTrue($store->hasKey($key));
        $this->assertEquals($value, $store->getValueByKey($key));
        $this->assertEquals($key, $store->getKeyByValue($value));
        $this->assertEquals([$key], $store->getKeys());

    }

    public function testRemoveByKey()
    {
        $key = 'key';
        $value = 'value';

        $store = new \Echron\DataTypes\KeyValueStore();
        $store->add($key, $value);

        $store->removeByKey($key);

        $this->assertFalse($store->hasKey($key));
        // $this->assertEquals($value, $store->getValueByKey($key));
        //   $this->assertEquals($key, $store->getKeyByValue($value));
        $this->assertEquals([], $store->getKeys());

    }

    public function testRemoveByValue()
    {
        $key = 'key';
        $value = 'value';

        $store = new \Echron\DataTypes\KeyValueStore();
        $store->add($key, $value);

        $store->removeByValue($value);

        $this->assertFalse($store->hasKey($key));
        // $this->assertEquals($value, $store->getValueByKey($key));
        //   $this->assertEquals($key, $store->getKeyByValue($value));
        $this->assertEquals([], $store->getKeys());

    }

    public function testAddNormalizedKey()
    {
        $key = 'Key';
        $value = 'value';

        $store = new \Echron\DataTypes\KeyValueStore(true);
        $store->add($key, $value);

        $this->assertTrue($store->hasKey('key'));
        $this->assertEquals($value, $store->getValueByKey($key));
        $this->assertEquals($key, $store->getKeyByValue($value));
        $this->assertEquals([$key], $store->getKeys());

    }

    public function testRemoveByKeyNormalizedKey()
    {
        $key = 'key';
        $value = 'value';

        $store = new \Echron\DataTypes\KeyValueStore(true);
        $store->add($key, $value);

        $store->removeByKey('Key');

        $this->assertFalse($store->hasKey($key));
        // $this->assertEquals($value, $store->getValueByKey($key));
        //   $this->assertEquals($key, $store->getKeyByValue($value));
        $this->assertEquals([], $store->getKeys());

    }

    public function testRemoveByValueNormalizedKey()
    {
        $key = 'key';
        $value = 'value';

        $store = new \Echron\DataTypes\KeyValueStore(true);
        $store->add($key, $value);

        $store->removeByValue($value);

        $this->assertFalse($store->hasKey('Key'));
        // $this->assertEquals($value, $store->getValueByKey($key));
        //   $this->assertEquals($key, $store->getKeyByValue($value));
        $this->assertEquals([], $store->getKeys());

    }

}
