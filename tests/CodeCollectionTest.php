<?php
declare(strict_types=1);

namespace Echron\DataTypes;

use PHPUnit\Framework\TestCase;

class CodeCollectionTest extends TestCase
{

    public function testNestedIteration()
    {
        $collection = new CodeCollection();
        $collection->add('A', 'A Value');
        $collection->add('B', 'B Value');
        $collection->add('C', 'C Value');

        //        $collection2 = new CodeCollection();
        //        $collection2->add('A', 'A Value');
        //        $collection2->add('B', 'B Value');
        //        $collection2->add('C', 'C Value');

        $expectedOutput = [
            'A Value-A Value',
            'A Value-B Value',
            'A Value-C Value',
            'B Value-A Value',
            'B Value-B Value',
            'B Value-C Value',
            'C Value-A Value',
            'C Value-B Value',
            'C Value-C Value',
        ];

        $output = [];
        foreach ($collection as $item) {
            foreach ($collection as $item2) {
                $output[] = $item . '-' . $item2;
            }
        }

        $this->assertEquals($expectedOutput, $output);
    }

}
