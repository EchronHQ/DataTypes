<?php
declare(strict_types = 1);

class IdHelperTest extends PHPUnit_Framework_TestCase
{
    public function testFormatKey_space()
    {
        $formattedKey = \DataTypes\Helper\IdHelper::formatKey('a b');
        $this->assertEquals('a_b', $formattedKey);

        $formattedKey = \DataTypes\Helper\IdHelper::formatKey('a  b');
        $this->assertEquals('a_b', $formattedKey);

        $formattedKey = \DataTypes\Helper\IdHelper::formatKey('a  b       c');
        $this->assertEquals('a_b_c', $formattedKey);
    }

    public function testFormatKey_NoTrailingUnderscore()
    {
        $formattedKey = \DataTypes\Helper\IdHelper::formatKey('It is what it is ');
        $this->assertEquals('it_is_what_it_is', $formattedKey);

        $formattedKey = \DataTypes\Helper\IdHelper::formatKey(' It is what it is ');
        $this->assertEquals('it_is_what_it_is', $formattedKey);

        $formattedKey = \DataTypes\Helper\IdHelper::formatKey('It is what it is_');
        $this->assertEquals('it_is_what_it_is', $formattedKey);

        $formattedKey = \DataTypes\Helper\IdHelper::formatKey('_It is what it is');
        $this->assertEquals('it_is_what_it_is', $formattedKey);

    }

    public function testFormatKey_slash()
    {
        $formattedKey = \DataTypes\Helper\IdHelper::formatKey('a/b');
        $this->assertEquals('a_b', $formattedKey);

        $formattedKey = \DataTypes\Helper\IdHelper::formatKey('a//b');
        $this->assertEquals('a_b', $formattedKey);

        $formattedKey = \DataTypes\Helper\IdHelper::formatKey('a//b///c');
        $this->assertEquals('a_b_c', $formattedKey);
    }

    public function testFormatKey_slashAllowed()
    {
        $formattedKey = \DataTypes\Helper\IdHelper::formatKey('a/b', true);
        $this->assertEquals('a/b', $formattedKey);

        $formattedKey = \DataTypes\Helper\IdHelper::formatKey('a//b', true);
        $this->assertEquals('a_b', $formattedKey);

        $formattedKey = \DataTypes\Helper\IdHelper::formatKey('a//b///c', true);
        $this->assertEquals('a_b_c', $formattedKey);
    }

    public function testFormatKey_backslash()
    {
        $formattedKey = \DataTypes\Helper\IdHelper::formatKey('a\b');
        $this->assertEquals('a_b', $formattedKey);

        $formattedKey = \DataTypes\Helper\IdHelper::formatKey('a\\\\b');
        $this->assertEquals('a_b', $formattedKey);

        $formattedKey = \DataTypes\Helper\IdHelper::formatKey('a\\b\\\c');
        $this->assertEquals('a_b_c', $formattedKey);
    }

    public function testFormatKey_math()
    {
        $formattedKey = \DataTypes\Helper\IdHelper::formatKey('a+b');
        $this->assertEquals('a_b', $formattedKey);

        $formattedKey = \DataTypes\Helper\IdHelper::formatKey('a++b--c');
        $this->assertEquals('a_b_c', $formattedKey);

        $formattedKey = \DataTypes\Helper\IdHelper::formatKey('a*-=b\'c');
        $this->assertEquals('a_b_c', $formattedKey);
    }

    public function testFormatKey_specials()
    {
        $formattedKey = \DataTypes\Helper\IdHelper::formatKey('a&b');
        $this->assertEquals('a_b', $formattedKey);

        $formattedKey = \DataTypes\Helper\IdHelper::formatKey('a$b^c');
        $this->assertEquals('a_b_c', $formattedKey);

        $formattedKey = \DataTypes\Helper\IdHelper::formatKey('a@b12c');
        $this->assertEquals('a_b12c', $formattedKey);
    }

    public function testFormatKey_specialsChars()
    {
        $formattedKey = \DataTypes\Helper\IdHelper::formatKey('aëb');
        $this->assertEquals('aeb', $formattedKey);

        $formattedKey = \DataTypes\Helper\IdHelper::formatKey('a$b^c');
        $this->assertEquals('a_b_c', $formattedKey);

        $formattedKey = \DataTypes\Helper\IdHelper::formatKey('a@b12c');
        $this->assertEquals('a_b12c', $formattedKey);

        $formattedKey = \DataTypes\Helper\IdHelper::formatKey('aébècç');
        $this->assertEquals('aebecc', $formattedKey);

        $formattedKey = \DataTypes\Helper\IdHelper::formatKey('a Τάχιστη b αλώπηξ c βαφής d ψημένη e γη, f δρασκελίζει g υπέρ h νωθρού i κυνός');
        $this->assertEquals('a_b_c_d_e_f_g_h_i', $formattedKey);

    }

    public function testFormatKey_numbers()
    {
        $formattedKey = \DataTypes\Helper\IdHelper::formatKey('123');
        $this->assertEquals('123', $formattedKey);

        $formattedKey = \DataTypes\Helper\IdHelper::formatKey('0123');
        $this->assertEquals('123', $formattedKey);

        $formattedKey = \DataTypes\Helper\IdHelper::formatKey('3210');
        $this->assertEquals('3210', $formattedKey);
    }

    public function testFormatKey_unwanted()
    {

        $formattedKey = \DataTypes\Helper\IdHelper::formatKey('test�test');
        $this->assertEquals('test_test', $formattedKey);

    }

    public function testFormatKey_MaxLength()
    {

        $formattedKey = \DataTypes\Helper\IdHelper::formatKey('abcdefghijklmnopqrstuvwxyz', false, 10);
        $this->assertEquals($formattedKey, 'abcdefghij');
        $this->assertEquals(10, strlen($formattedKey));

        $formattedKey = \DataTypes\Helper\IdHelper::formatKey('This is a long long long id', false, 10);
        $this->assertEquals($formattedKey, 'this_is_a');
        $this->assertLessThan(10, strlen($formattedKey));

        $formattedKey = \DataTypes\Helper\IdHelper::formatKey('Shortid', false, 100);
        $this->assertEquals($formattedKey, 'shortid');
        $this->assertEquals(7, strlen($formattedKey));

    }
}
