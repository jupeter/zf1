<?php
/**
 * @package    Zend_Measure
 * @subpackage UnitTests
 */


/**
 * Zend_Measure_Flow_Mass
 */
require_once 'Zend/Measure/Flow/Mass.php';

/**
 * PHPUnit2 test case
 */
require_once 'PHPUnit2/Framework/TestCase.php';


/**
 * @package    Zend_Measure
 * @subpackage UnitTests
 */
class Zend_Measure_Flow_MassTest extends PHPUnit2_Framework_TestCase
{

    public function setUp()
    {
    }


    /**
     * test for Mass initialisation
     * expected instance
     */
    public function testMassInit()
    {
        $value = new Zend_Measure_Flow_Mass('100',Zend_Measure_Flow_Mass::STANDARD,'de');
        $this->assertTrue($value instanceof Zend_Measure_Flow_Mass,'Zend_Measure_Flow_Mass Object not returned');
    }


    /**
     * test for exception unknown type
     * expected exception
     */
    public function testFlow_MassUnknownType()
    {
        try {
            $value = new Zend_Measure_Flow_Mass('100','Flow_Mass::UNKNOWN','de');
            $this->assertTrue(false,'Exception expected because of unknown type');
        } catch (Exception $e) {
            return true; // Test OK
        }
    }


    /**
     * test for exception unknown value
     * expected exception
     */
    public function testFlow_MassUnknownValue()
    {
        try {
            $value = new Zend_Measure_Flow_Mass('novalue',Zend_Measure_Flow_Mass::STANDARD,'de');
            $this->assertTrue(false,'Exception expected because of empty value');
        } catch (Exception $e) {
            return true; // Test OK
        }
    }


    /**
     * test for exception unknown locale
     * expected root value
     */
    public function testFlow_MassUnknownLocale()
    {
        try {
            $value = new Zend_Measure_Flow_Mass('100',Zend_Measure_Flow_Mass::STANDARD,'nolocale');
            $this->assertTrue(false,'Exception expected because of unknown locale');
        } catch (Exception $e) {
            return true; // Test OK
        }
    }


    /**
     * test for positive value
     * expected integer
     */
    public function testFlow_MassValuePositive()
    {
        $value = new Zend_Measure_Flow_Mass('100',Zend_Measure_Flow_Mass::STANDARD,'de');
        $this->assertEquals(100, $value->getValue(), 'Zend_Measure_Flow_Mass value expected to be a positive integer');
    }


    /**
     * test for negative value
     * expected integer
     */
    public function testFlow_MassValueNegative()
    {
        $value = new Zend_Measure_Flow_Mass('-100',Zend_Measure_Flow_Mass::STANDARD,'de');
        $this->assertEquals(-100, $value->getValue(), 'Zend_Measure_Flow_Mass value expected to be a negative integer');
    }


    /**
     * test for decimal value
     * expected float
     */
    public function testFlow_MassValueDecimal()
    {
        $value = new Zend_Measure_Flow_Mass('-100,200',Zend_Measure_Flow_Mass::STANDARD,'de');
        $this->assertEquals(-100.200, $value->getValue(), 'Zend_Measure_Flow_Mass value expected to be a decimal value');
    }


    /**
     * test for decimal seperated value
     * expected float
     */
    public function testFlow_MassValueDecimalSeperated()
    {
        $value = new Zend_Measure_Flow_Mass('-100.100,200',Zend_Measure_Flow_Mass::STANDARD,'de');
        $this->assertEquals(-100100.200, $value->getValue(),'Zend_Measure_Flow_Mass Object not returned');
    }


    /**
     * test for string with integrated value
     * expected float
     */
    public function testFlow_MassValueString()
    {
        $value = new Zend_Measure_Flow_Mass('string -100.100,200',Zend_Measure_Flow_Mass::STANDARD,'de');
        $this->assertEquals(-100100.200, $value->getValue(),'Zend_Measure_Flow_Mass Object not returned');
    }


    /**
     * test for equality
     * expected true
     */
    public function testFlow_MassEquality()
    {
        $value = new Zend_Measure_Flow_Mass('string -100.100,200',Zend_Measure_Flow_Mass::STANDARD,'de');
        $newvalue = new Zend_Measure_Flow_Mass('otherstring -100.100,200',Zend_Measure_Flow_Mass::STANDARD,'de');
        $this->assertTrue($value->equals($newvalue),'Zend_Measure_Flow_Mass Object should be equal');
    }


    /**
     * test for no equality
     * expected false
     */
    public function testFlow_MassNoEquality()
    {
        $value = new Zend_Measure_Flow_Mass('string -100.100,200',Zend_Measure_Flow_Mass::STANDARD,'de');
        $newvalue = new Zend_Measure_Flow_Mass('otherstring -100,200',Zend_Measure_Flow_Mass::STANDARD,'de');
        $this->assertFalse($value->equals($newvalue),'Zend_Measure_Flow_Mass Object should be not equal');
    }


    /**
     * test for serialization
     * expected string
     */
    public function testFlow_MassSerialize()
    {
        $value = new Zend_Measure_Flow_Mass('string -100.100,200',Zend_Measure_Flow_Mass::STANDARD,'de');
        $serial = $value->serialize();
        $this->assertTrue(!empty($serial),'Zend_Measure_Flow_Mass not serialized');
    }


    /**
     * test for unserialization
     * expected object
     */
    public function testFlow_MassUnSerialize()
    {
        $value = new Zend_Measure_Flow_Mass('string -100.100,200',Zend_Measure_Flow_Mass::STANDARD,'de');
        $serial = $value->serialize();
        $newvalue = unserialize($serial);
        $this->assertTrue($value->equals($newvalue),'Zend_Measure_Flow_Mass not unserialized');
    }


    /**
     * test for set positive value
     * expected integer
     */
    public function testFlow_MassSetPositive()
    {
        $value = new Zend_Measure_Flow_Mass('100',Zend_Measure_Flow_Mass::STANDARD,'de');
        $value->setValue('200',Zend_Measure_Flow_Mass::STANDARD,'de');
        $this->assertEquals(200, $value->getValue(), 'Zend_Measure_Flow_Mass value expected to be a positive integer');
    }


    /**
     * test for set negative value
     * expected integer
     */
    public function testFlow_MassSetNegative()
    {
        $value = new Zend_Measure_Flow_Mass('-100',Zend_Measure_Flow_Mass::STANDARD,'de');
        $value->setValue('-200',Zend_Measure_Flow_Mass::STANDARD,'de');
        $this->assertEquals(-200, $value->getValue(), 'Zend_Measure_Flow_Mass value expected to be a negative integer');
    }


    /**
     * test for set decimal value
     * expected float
     */
    public function testFlow_MassSetDecimal()
    {
        $value = new Zend_Measure_Flow_Mass('-100,200',Zend_Measure_Flow_Mass::STANDARD,'de');
        $value->setValue('-200,200',Zend_Measure_Flow_Mass::STANDARD,'de');
        $this->assertEquals(-200.200, $value->getValue(), 'Zend_Measure_Flow_Mass value expected to be a decimal value');
    }


    /**
     * test for set decimal seperated value
     * expected float
     */
    public function testFlow_MassSetDecimalSeperated()
    {
        $value = new Zend_Measure_Flow_Mass('-100.100,200',Zend_Measure_Flow_Mass::STANDARD,'de');
        $value->setValue('-200.200,200',Zend_Measure_Flow_Mass::STANDARD,'de');
        $this->assertEquals(-200200.200, $value->getValue(),'Zend_Measure_Flow_Mass Object not returned');
    }


    /**
     * test for set string with integrated value
     * expected float
     */
    public function testFlow_MassSetString()
    {
        $value = new Zend_Measure_Flow_Mass('string -100.100,200',Zend_Measure_Flow_Mass::STANDARD,'de');
        $value->setValue('otherstring -200.200,200',Zend_Measure_Flow_Mass::STANDARD,'de');
        $this->assertEquals(-200200.200, $value->getValue(),'Zend_Measure_Flow_Mass Object not returned');
    }


    /**
     * test for exception unknown type
     * expected exception
     */
    public function testFlow_MassSetUnknownType()
    {
        try {
            $value = new Zend_Measure_Flow_Mass('100',Zend_Measure_Flow_Mass::STANDARD,'de');
            $value->setValue('otherstring -200.200,200','Flow_Mass::UNKNOWN','de');
            $this->assertTrue(false,'Exception expected because of unknown type');
        } catch (Exception $e) {
            return true; // Test OK
        }
    }


    /**
     * test for exception unknown value
     * expected exception
     */
    public function testFlow_MassSetUnknownValue()
    {
        try {
            $value = new Zend_Measure_Flow_Mass('100',Zend_Measure_Flow_Mass::STANDARD,'de');
            $value->setValue('novalue',Zend_Measure_Flow_Mass::STANDARD,'de');
            $this->assertTrue(false,'Exception expected because of empty value');
        } catch (Exception $e) {
            return; // Test OK
        }
    }


    /**
     * test for exception unknown locale
     * expected exception
     */
    public function testFlow_MassSetUnknownLocale()
    {
        try {
            $value = new Zend_Measure_Flow_Mass('100',Zend_Measure_Flow_Mass::STANDARD,'de');
            $value->setValue('200',Zend_Measure_Flow_Mass::STANDARD,'nolocale');
            $this->assertTrue(false,'Exception expected because of unknown locale');
        } catch (Exception $e) {
            return true; // Test OK
        }
    }


    /**
     * test setting type
     * expected new type
     */
    public function testFlow_MassSetType()
    {
        $value = new Zend_Measure_Flow_Mass('-100',Zend_Measure_Flow_Mass::STANDARD,'de');
        $value->setType(Zend_Measure_Flow_Mass::GRAM_PER_DAY);
        $this->assertEquals($value->getType(), Zend_Measure_Flow_Mass::GRAM_PER_DAY, 'Zend_Measure_Flow_Mass type expected');
    }


    /**
     * test setting computed type
     * expected new type
     */
    public function testFlow_MassSetComputedType1()
    {
        $value = new Zend_Measure_Flow_Mass('-100',Zend_Measure_Flow_Mass::STANDARD,'de');
        $value->setType(Zend_Measure_Flow_Mass::GRAM_PER_DAY);
        $this->assertEquals($value->getType(), Zend_Measure_Flow_Mass::GRAM_PER_DAY, 'Zend_Measure_Flow_Mass type expected');
    }


    /**
     * test setting computed type
     * expected new type
     */
    public function testFlow_MassSetComputedType2()
    {
        $value = new Zend_Measure_Flow_Mass('-100',Zend_Measure_Flow_Mass::GRAM_PER_DAY,'de');
        $value->setType(Zend_Measure_Flow_Mass::STANDARD);
        $this->assertEquals($value->getType(), Zend_Measure_Flow_Mass::STANDARD, 'Zend_Measure_Flow_Mass type expected');
    }


    /**
     * test setting unknown type
     * expected new type
     */
    public function testFlow_MassSetTypeFailed()
    {
        try {
            $value = new Zend_Measure_Flow_Mass('-100',Zend_Measure_Flow_Mass::STANDARD,'de');
            $value->setType('Flow_Mass::UNKNOWN');
            $this->assertTrue(false,'Exception expected because of unknown type');
        } catch (Exception $e) {
            return true; // OK
        }
    }


    /**
     * test toString
     * expected string
     */
    public function testFlow_MassToString()
    {
        $value = new Zend_Measure_Flow_Mass('-100',Zend_Measure_Flow_Mass::STANDARD,'de');
        $this->assertEquals($value->toString(), '-100 kg/sec', 'Value -100 kg/sec expected');
    }


    /**
     * test __toString
     * expected string
     */
    public function testFlow_Mass_ToString()
    {
        $value = new Zend_Measure_Flow_Mass('-100',Zend_Measure_Flow_Mass::STANDARD,'de');
        $this->assertEquals($value->__toString(), '-100 kg/sec', 'Value -100 kg/sec expected');
    }
}
