<?php
declare(strict_types=1);

namespace Echron\DataTypes;

use PHPUnit\Framework\TestCase;

class IdObjectCollectionTest extends TestCase
{

    public function testHasCode()
    {
        $collection = new IdCodeCollection();

        //Ad single item
        $collection->add(-1, '31542415-28DE-475A-881D-56A138DEC9EA', 'result code 1');
        $this->assertTrue($collection->hasCode('31542415-28DE-475A-881D-56A138DEC9EA'));

        //Add duplicate ids
        $collection->add(-2, '89B62C0F-6394-46A9-88DE-103D8D9C469A', 'result code 2');
        $this->assertTrue($collection->hasCode('31542415-28DE-475A-881D-56A138DEC9EA'));
        $collection->add(-3, '10B89B5D-0FF6-4B45-BCB1-7A751E4FF7EC', 'result code 3');
        $this->assertTrue($collection->hasCode('31542415-28DE-475A-881D-56A138DEC9EA'));

        //Add duplicate codes
        $collection->add(-4, '31542415-28DE-475A-881D-56A138DEC9EA', 'result code 1 copy', true);
        $this->assertTrue($collection->hasCode('31542415-28DE-475A-881D-56A138DEC9EA'));
    }

    public function testRemoveWithEmptyCode()
    {
        $collection = new IdCodeCollection();

        //Ad single item
        $collection->add(0, '31542415-28DE-475A-881D-56A138DEC9EA', 'result code 1');
        $this->assertTrue($collection->hasCode('31542415-28DE-475A-881D-56A138DEC9EA'));
        $this->assertTrue($collection->hasId(0));
//        //Add duplicate ids
//        $collection->add(-1, '89B62C0F-6394-46A9-88DE-103D8D9C469A', 'result code 2');
//        $this->assertTrue($collection->hasCode('31542415-28DE-475A-881D-56A138DEC9EA'));
//        $collection->add(-1, '10B89B5D-0FF6-4B45-BCB1-7A751E4FF7EC', 'result code 3');
//        $this->assertTrue($collection->hasCode('31542415-28DE-475A-881D-56A138DEC9EA'));
//
//        //Add duplicate codes
//        $collection->add(-1, '31542415-28DE-475A-881D-56A138DEC9EA', 'result code 1 copy');
//        $this->assertTrue($collection->hasCode('31542415-28DE-475A-881D-56A138DEC9EA'));
    }

}
