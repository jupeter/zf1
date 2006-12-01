<?php
/**
 * @package    Zend_Date
 * @subpackage UnitTests
 */


/**
 * Zend_Date
 */
require_once 'Zend/Date/DateObject.php';

/**
 * PHPUnit test case
 */
require_once 'PHPUnit/Framework/TestCase.php';


/**
 * @package    Zend_Date
 * @subpackage UnitTests
 */
class Zend_Date_DateObjectTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        date_default_timezone_set('Europe/Paris');
    }

    /**
	 * Test for date object creation empty value
	 */
    public function testCreation()
    {
    	$date = new Zend_Date_DateObject();
    	$this->assertTrue($date instanceof Zend_Date_DateObject, "expected date object");
    }

	/**
	 * Test for date object creation null value
	 */
    public function testCreationNull()
    {
    	$date = new Zend_Date_DateObject(0);
    	$this->assertTrue($date instanceof Zend_Date_DateObject, "expected date object");
    }

	/**
	 * Test for date object creation negative timestamp
	 */
    public function testCreationNegative()
    {
    	$date = new Zend_Date_DateObject(-1000);
    	$this->assertTrue($date instanceof Zend_Date_DateObject, "expected date object");
    }

	/**
	 * Test for date object creation text given
	 */
    public function testCreationFailed()
    {
        try {
        	$date = new Zend_Date_DateObject("notimestamp");
        	$this->assertFalse($date instanceof Zend_Date_DateObject, "exception expected");
        } catch (Exception $e) {
            return true;
        }
    }

	/**
	 * Test for setTimestamp
	 */
    public function testSetTimestamp()
    {
      	$date = new Zend_Date_DateObject();
       	$this->assertTrue($date->setTimestamp(0), "true expected");
       	$this->assertTrue($date->setTimestamp("12345678901234567890"), "true expected");
    }

	/**
	 * Test for setTimestampFailed
	 */
    public function testSetTimestampFailed()
    {
        try {
        	$date = new Zend_Date_DateObject();
        	$date->setTimestamp("notimestamp");
        	$this->assertFalse($date instanceof Zend_Date_DateObject, "exception expected");
        } catch (Exception $e) {
            return true;
        }
    }

	/**
	 * Test for getTimestamp
	 */
    public function testGetTimestamp()
    {
      	$date = new Zend_Date_DateObject();
      	$result = $date->getTimestamp();
       	$this->assertSame($result, time(), time()." expected");
    }

	/**
	 * Test for mktime
	 */
    public function testMkTimeforTimeValues()
    {
        $date = new Zend_Date_DateObject();
        
        $this->assertSame($date->mktime(  0,   0,   0), mktime(  0,   0,   0));
        $this->assertSame($date->mktime( 23,  59,  59), mktime( 23,  59,  59));
        $this->assertSame($date->mktime(100, 100, 100), mktime(100, 100, 100));

        $this->assertSame($date->mktime(  0,   0,   0, false, false, false, -1, true), gmmktime(  0,   0,   0));
        $this->assertSame($date->mktime( 23,  59,  59, false, false, false, -1, true), gmmktime( 23,  59,  59));
        $this->assertSame($date->mktime(100, 100, 100, false, false, false, -1, true), gmmktime(100, 100, 100));
    }

	/**
	 * Test for mktime
	 */
    public function testMkTimeforDateValuesInPHPRange()
    {
        $date = new Zend_Date_DateObject();
       	$this->assertSame($date->mktime(0, 0, 0, 12, 30, 2037, -1, false),   mktime(0, 0, 0, 12, 30, 2037, -1));
       	$this->assertSame($date->mktime(0, 0, 0, 12, 30, 2037, -1, true),  gmmktime(0, 0, 0, 12, 30, 2037, -1));

       	$this->assertSame($date->mktime(0, 0, 0,  1,  1, 2000, -1, false),   mktime(0, 0, 0,  1,  1, 2000, -1));
       	$this->assertSame($date->mktime(0, 0, 0,  1,  1, 2000, -1, true),  gmmktime(0, 0, 0,  1,  1, 2000, -1));

       	$this->assertSame($date->mktime(0, 0, 0,  1,  1, 1970, -1, false),   mktime(0, 0, 0,  1,  1, 1970, -1));
       	$this->assertSame($date->mktime(0, 0, 0,  1,  1, 1970, -1, true),  gmmktime(0, 0, 0,  1,  1, 1970, -1));

       	$this->assertSame($date->mktime(0, 0, 0, 12, 30, 1902, -1, false),   mktime(0, 0, 0, 12, 30, 1902, -1));
       	$this->assertSame($date->mktime(0, 0, 0, 12, 30, 1902, -1, true),  gmmktime(0, 0, 0, 12, 30, 1902, -1));
    }

	/**
	 * Test for mktime
	 */
    public function testMkTimeforDateValuesGreaterPHPRange()
    {
        $date = new Zend_Date_DateObject();
       	$this->assertSame($date->mktime(0, 0, 0,10, 1, 2040, -1, false), 2232658800);
       	$this->assertSame($date->mktime(0, 0, 0,10, 1, 2040, -1, true),  2232662400);
       	$this->assertSame($date->mktime(0, 0, 0, 1, 1, 2200, -1, false), 7258114800);
       	$this->assertSame($date->mktime(0, 0, 0, 1, 1, 2200, -1, true),  7258118400);
       	$this->assertSame($date->mktime(0, 0, 0,10,10, 2500, -1, false), 16749586800);
       	$this->assertSame($date->mktime(0, 0, 0,10,10, 2500, -1, true),  16749590400);
       	$this->assertSame($date->mktime(0, 0, 0, 1, 1, 3000, -1, false), 32503676400);
       	$this->assertSame($date->mktime(0, 0, 0, 1, 1, 3000, -1, true),  32503680000);
       	$this->assertSame($date->mktime(0, 0, 0, 1, 1, 5000, -1, false), 95617580400);
       	$this->assertSame($date->mktime(0, 0, 0, 1, 1, 5000, -1, true),  95617584000);
    }

	/**
	 * Test for mktime
	 */
    public function testMkTimeforDateValuesSmallerPHPRange()
    {
        $date = new Zend_Date_DateObject();
       	$this->assertSame($date->mktime(0, 0, 0, 1, 1, 1900, -1, false), -2208985200);
       	$this->assertSame($date->mktime(0, 0, 0, 1, 1, 1900, -1, true),  -2208988800);
       	$this->assertSame($date->mktime(0, 0, 0, 1, 1, 1700, -1, false), -8520332400);
       	$this->assertSame($date->mktime(0, 0, 0, 1, 1, 1700, -1, true),  -8520336000);
       	$this->assertSame($date->mktime(0, 0, 0, 1, 1, 1500, -1, false), -14830988400);
       	$this->assertSame($date->mktime(0, 0, 0, 1, 1, 1500, -1, true),  -14830992000);
       	$this->assertSame($date->mktime(0, 0, 0,10,10, 1582, -1, false), -12219321600);
       	$this->assertSame($date->mktime(0, 0, 0,10,10, 1582, -1, true),  -12219321600);
       	$this->assertSame($date->mktime(0, 0, 0, 1, 1, 1000, -1, false), -30609788400);
       	$this->assertSame($date->mktime(0, 0, 0, 1, 1, 1000, -1, true),  -30609792000);
       	$this->assertSame($date->mktime(0, 0, 0, 1, 1,    0, -1, false), -62167388400);
       	$this->assertSame($date->mktime(0, 0, 0, 1, 1,    0, -1, true),  -62167392000);
       	$this->assertSame($date->mktime(0, 0, 0, 1, 1,-2000, -1, false), -125282588400);
       	$this->assertSame($date->mktime(0, 0, 0, 1, 1,-2000, -1, true),  -125282592000);

       	$this->assertSame($date->mktime(0, 0, 0, 13, 1, 1899, -1, false), -2208985200);
       	$this->assertSame($date->mktime(0, 0, 0, 13, 1, 1899, -1, true),  -2208988800);
       	$this->assertSame($date->mktime(0, 0, 0,-11, 1, 1901, -1, false), -2208985200);
       	$this->assertSame($date->mktime(0, 0, 0,-11, 1, 1901, -1, true),  -2208988800);
    }

    public function testIsLeapYear()
    {
        $date = new Zend_Date_DateObject();
        $this->assertSame($date->isLeapYear(2000), true);
        $this->assertSame($date->isLeapYear(2002), false);
        $this->assertSame($date->isLeapYear(2004), true);
        $this->assertSame($date->isLeapYear(1899), false);
        $this->assertSame($date->isLeapYear(1500), true);
        $this->assertSame($date->isLeapYear(1455), false);
    }

    public function testWeekNumber()
    {
        $date = new Zend_Date_DateObject();
        $this->assertSame($date->weekNumber(2000, 1, 1), (int) date('W',mktime(0, 0, 0, 1, 1, 2000)));
        $this->assertSame($date->weekNumber(2020, 10, 1), (int) date('W',mktime(0, 0, 0, 10, 1, 2020)));
        $this->assertSame($date->weekNumber(2005, 5, 15), (int) date('W',mktime(0, 0, 0, 5, 15, 2005)));
        $this->assertSame($date->weekNumber(1994, 11, 22), (int) date('W',mktime(0, 0, 0, 11, 22, 1994)));
        $this->assertSame($date->weekNumber(2000, 12, 31), (int) date('W',mktime(0, 0, 0, 12, 31, 2000)));
        $this->assertSame($date->weekNumber(2050, 12, 31), 1);
        $this->assertSame($date->weekNumber(2050, 6, 6), 23);
        $this->assertSame($date->weekNumber(2056, 1, 1), 52);
    }

    public function testDayOfWeek()
    {
        $date = new Zend_Date_DateObject();
        $this->assertSame($date->dayOfWeek(2000, 1, 1), (int) date('w',mktime(0, 0, 0, 1, 1, 2000)));
        $this->assertSame($date->dayOfWeek(2000, 1, 2), (int) date('w',mktime(0, 0, 0, 1, 2, 2000)));
        $this->assertSame($date->dayOfWeek(2000, 1, 3), (int) date('w',mktime(0, 0, 0, 1, 3, 2000)));
        $this->assertSame($date->dayOfWeek(2000, 1, 4), (int) date('w',mktime(0, 0, 0, 1, 4, 2000)));
        $this->assertSame($date->dayOfWeek(2000, 1, 5), (int) date('w',mktime(0, 0, 0, 1, 5, 2000)));
        $this->assertSame($date->dayOfWeek(2000, 1, 6), (int) date('w',mktime(0, 0, 0, 1, 6, 2000)));
        $this->assertSame($date->dayOfWeek(2000, 1, 7), (int) date('w',mktime(0, 0, 0, 1, 7, 2000)));
        $this->assertSame($date->dayOfWeek(2000, 1, 8), (int) date('w',mktime(0, 0, 0, 1, 8, 2000)));
        $this->assertSame($date->dayOfWeek(2050, 1, 1), 6);
        $this->assertSame($date->dayOfWeek(2050, 1, 2), 0);
        $this->assertSame($date->dayOfWeek(2050, 1, 3), 1);
        $this->assertSame($date->dayOfWeek(2050, 1, 4), 2);
        $this->assertSame($date->dayOfWeek(2050, 1, 5), 3);
        $this->assertSame($date->dayOfWeek(2050, 1, 6), 4);
        $this->assertSame($date->dayOfWeek(2050, 1, 7), 5);
        $this->assertSame($date->dayOfWeek(2050, 1, 8), 6);
        $this->assertSame($date->dayOfWeek(1500, 1, 1), 4);
    }

    public function testCalcSunInternal()
    {
        $date = new Zend_Date_DateObject(10000000);
        $this->assertSame($date->calcSun(array('latitude' =>  38.4, 'longitude' => -29), -0.0145439, true),  9961681);
        $this->assertSame($date->calcSun(array('latitude' =>  38.4, 'longitude' => -29), -0.0145439, false), 10010367);
        $this->assertSame($date->calcSun(array('latitude' => -38.4, 'longitude' => -29), -0.0145439, true),  9967006);
        $this->assertSame($date->calcSun(array('latitude' => -38.4, 'longitude' => -29), -0.0145439, false), 10005042);
        $this->assertSame($date->calcSun(array('latitude' =>  38.4, 'longitude' =>  29), -0.0145439, true),  9947773);
        $this->assertSame($date->calcSun(array('latitude' =>  38.4, 'longitude' =>  29), -0.0145439, false), 9996438);
        $this->assertSame($date->calcSun(array('latitude' => -38.4, 'longitude' =>  29), -0.0145439, true),  9953077);
        $this->assertSame($date->calcSun(array('latitude' => -38.4, 'longitude' =>  29), -0.0145439, false), 9991134);
        $this->assertSame($date->calcSun(array('latitude' =>  38.4, 'longitude' => 129), -0.0145439, true),  9923795);
        $this->assertSame($date->calcSun(array('latitude' =>  38.4, 'longitude' => 129), -0.0145439, false), 9972422);
        $this->assertSame($date->calcSun(array('latitude' => -38.4, 'longitude' => 129), -0.0145439, true),  9929062);
        $this->assertSame($date->calcSun(array('latitude' => -38.4, 'longitude' => 129), -0.0145439, false), 9967155);
        $this->assertSame($date->calcSun(array('latitude' =>  38.4, 'longitude' =>-129), -0.0145439, true),  9985660);
        $this->assertSame($date->calcSun(array('latitude' =>  38.4, 'longitude' =>-129), -0.0145439, false), 10034383);
        $this->assertSame($date->calcSun(array('latitude' => -38.4, 'longitude' =>-129), -0.0145439, true),  9991022);
        $this->assertSame($date->calcSun(array('latitude' => -38.4, 'longitude' =>-129), -0.0145439, false), 10029021);
    }

    public function testCalcSunExternal()
    {
        $date = new Zend_Date_DateObject(-14830988400);
        $this->assertSame($date->calcSun(array('latitude' =>  38.4, 'longitude' => -29), -0.0145439, true),  -14830008411);
        $this->assertSame($date->calcSun(array('latitude' =>  38.4, 'longitude' => -29), -0.0145439, false), -14829974084);
        $this->assertSame($date->calcSun(array('latitude' => -38.4, 'longitude' => -29), -0.0145439, true),  -14830017896);
        $this->assertSame($date->calcSun(array('latitude' => -38.4, 'longitude' => -29), -0.0145439, false), -14829964616);
        $this->assertSame($date->calcSun(array('latitude' =>  38.4, 'longitude' =>  29), -0.0145439, true),  -14830022333);
        $this->assertSame($date->calcSun(array('latitude' =>  38.4, 'longitude' =>  29), -0.0145439, false), -14829988011);
        $this->assertSame($date->calcSun(array('latitude' => -38.4, 'longitude' =>  29), -0.0145439, true),  -14830031824);
        $this->assertSame($date->calcSun(array('latitude' => -38.4, 'longitude' =>  29), -0.0145439, false), -14829978538);
        $this->assertSame($date->calcSun(array('latitude' =>  38.4, 'longitude' => 129), -0.0145439, true),  -14829959936);
        $this->assertSame($date->calcSun(array('latitude' =>  38.4, 'longitude' => 129), -0.0145439, false), -14830012024);
        $this->assertSame($date->calcSun(array('latitude' => -38.4, 'longitude' => 129), -0.0145439, true),  -14829969437);
        $this->assertSame($date->calcSun(array('latitude' => -38.4, 'longitude' => 129), -0.0145439, false), -14830002541);
        $this->assertSame($date->calcSun(array('latitude' =>  38.4, 'longitude' =>-129), -0.0145439, true),  -14829984408);
        $this->assertSame($date->calcSun(array('latitude' =>  38.4, 'longitude' =>-129), -0.0145439, false), -14830036471);
        $this->assertSame($date->calcSun(array('latitude' => -38.4, 'longitude' =>-129), -0.0145439, true),  -14829993883);
        $this->assertSame($date->calcSun(array('latitude' => -38.4, 'longitude' =>-129), -0.0145439, false), -14830027014);
    }

    public function testGetDate()
    {
        $date = new Zend_Date_DateObject(0);
        $this->assertTrue(is_array($date->getDate()));
        $this->assertTrue(is_array($date->getDate(1000000)));

        $test = array(             'seconds' => 40,        'minutes' => 46,
            'hours'   => 14,       'mday'    => 12,        'wday'    => 1,
            'mon'     => 1,        'year'    => 1970,      'yday'    => 11,
            'weekday' => 'Monday', 'month'   => 'January', 0         => 1000000);
        $result = $date->getDate(1000000);

        $this->assertSame((int) $result['seconds'], (int) $test['seconds']);
        $this->assertSame((int) $result['minutes'], (int) $test['minutes']);
        $this->assertSame((int) $result['hours'],   (int) $test['hours']);
        $this->assertSame((int) $result['mday'],    (int) $test['mday']);
        $this->assertSame((int) $result['wday'],    (int) $test['wday']);
        $this->assertSame((int) $result['mon'],     (int) $test['mon']);
        $this->assertSame((int) $result['year'],    (int) $test['year']);
        $this->assertSame((int) $result['yday'],    (int) $test['yday']);
        $this->assertSame($result['weekday'],             $test['weekday']);
        $this->assertSame($result['month'],               $test['month']);
        $this->assertSame($result[0],                     $test[0]);
    }

    public function testGetDate2()
    {
        $date = new Zend_Date_DateObject(0);

        $test = array(               'seconds' => 20,        'minutes' => 33,
            'hours'   => 11,         'mday'    => 16,        'wday'    => 6,
            'mon'     => 3,          'year'    => 1748,      'yday'    => 65,
            'weekday' => 'Saturday', 'month'   => 'February', 0        => -7000000000);
        $result = $date->getDate(-7000000000);

        $this->assertSame((int) $result['seconds'], (int) $test['seconds']);
        $this->assertSame((int) $result['minutes'], (int) $test['minutes']);
        $this->assertSame((int) $result['hours'],   (int) $test['hours']);
        $this->assertSame((int) $result['mday'],    (int) $test['mday']);
        $this->assertSame((int) $result['wday'],    (int) $test['wday']);
        $this->assertSame((int) $result['mon'],     (int) $test['mon']);
        $this->assertSame((int) $result['year'],    (int) $test['year']);
        $this->assertSame((int) $result['yday'],    (int) $test['yday']);
        $this->assertSame($result['weekday'],             $test['weekday']);
        $this->assertSame($result['month'],               $test['month']);
        $this->assertSame($result[0],                     $test[0]);
    }

    public function testGetDate3()
    {
        $date = new Zend_Date_DateObject(0);

        $test = array(               'seconds' => 0,        'minutes' => 40,
            'hours'   => 2,          'mday'    => 20,       'wday'    => 3,
            'mon'     => 8,          'year'    => 2188,     'yday'    => 238,
            'weekday' => 'Wednesday', 'month'   => 'July', 0      => 6900000000);
        $result = $date->getDate(6900000000);

        $this->assertSame((int) $result['seconds'], (int) $test['seconds']);
        $this->assertSame((int) $result['minutes'], (int) $test['minutes']);
        $this->assertSame((int) $result['hours'],   (int) $test['hours']);
        $this->assertSame((int) $result['mday'],    (int) $test['mday']);
        $this->assertSame((int) $result['wday'],    (int) $test['wday']);
        $this->assertSame((int) $result['mon'],     (int) $test['mon']);
        $this->assertSame((int) $result['year'],    (int) $test['year']);
        $this->assertSame((int) $result['yday'],    (int) $test['yday']);
        $this->assertSame($result['weekday'],             $test['weekday']);
        $this->assertSame($result['month'],               $test['month']);
        $this->assertSame($result[0],                     $test[0]);
    }

    public function testGetDate4()
    {
        $date = new Zend_Date_DateObject(0);

        $test = array(               'seconds' => 0,        'minutes' => 40,
            'hours'   => 2,          'mday'    => 20,       'wday'    => 3,
            'mon'     => 8,          'year'    => 2188,     'yday'    => 238,
            'weekday' => 'Wednesday', 'month'   => 'July', 0      => 6900000000);
        $result = $date->getDate(6900000000, true);

        $this->assertSame((int) $result['seconds'], (int) $test['seconds']);
        $this->assertSame((int) $result['minutes'], (int) $test['minutes']);
        $this->assertSame((int) $result['hours'],   (int) $test['hours']);
        $this->assertSame((int) $result['mday'],    (int) $test['mday']);
        $this->assertSame((int) $result['mon'],     (int) $test['mon']);
        $this->assertSame((int) $result['year'],    (int) $test['year']);
        $this->assertSame((int) $result['yday'],    (int) $test['yday']);
    }
    
    public function testDate()
    {
        $date = new Zend_Date_DateObject(0);
        $this->assertTrue($date->date('U') > 0);
        $this->assertSame($date->date('U',0),'0');
        $this->assertSame($date->date('U',0,false),'0');
        $this->assertSame($date->date('U',0,true),'0');
        $this->assertSame($date->date('U',6900000000),'6900000000');
        $this->assertSame($date->date('U',-7000000000),'-7000000000');
        $this->assertSame($date->date('d',-7000000000),'16');
        $this->assertSame($date->date('D',-7000000000),'Sat');
        $this->assertSame($date->date('j',-7000000000),'16');
        $this->assertSame($date->date('l',-7000000000),'Saturday');
        $this->assertSame($date->date('N',-7000000000),'6');
        $this->assertSame($date->date('S',-7000000000),'th');
        $this->assertSame($date->date('w',-7000000000),'6');
        $this->assertSame($date->date('z',-7000000000),'65');
        $this->assertSame($date->date('W',-7000000000),'11');
        $this->assertSame($date->date('F',-7000000000),'March');
        $this->assertSame($date->date('m',-7000000000),'03');
        $this->assertSame($date->date('M',-7000000000),'Mar');
        $this->assertSame($date->date('n',-7000000000),'3');
        $this->assertSame($date->date('t',-7000000000),'31');
        $this->assertSame($date->date('T',-7000000000),'CET');
        $this->assertSame($date->date('L',-7000000000),'1');
        $this->assertSame($date->date('o',-7000000000),'1748');
        $this->assertSame($date->date('Y',-7000000000),'1748');
        $this->assertSame($date->date('y',-7000000000),'48');
        $this->assertSame($date->date('a',-7000000000),'am');
        $this->assertSame($date->date('A',-7000000000),'AM');
        $this->assertSame($date->date('B',-7000000000),'481');
        $this->assertSame($date->date('g',-7000000000),'11');
        $this->assertSame($date->date('G',-7000000000),'11');
        $this->assertSame($date->date('h',-7000000000),'11');
        $this->assertSame($date->date('H',-7000000000),'11');
        $this->assertSame($date->date('i',-7000000000),'33');
        $this->assertSame($date->date('s',-7000000000),'20');
        $this->assertSame($date->date('e',-7000000000),'Europe/Paris');
        $this->assertSame($date->date('I',-7000000000),'0');
        $this->assertSame($date->date('O',-7000000000),'+0100');
        $this->assertSame($date->date('P',-7000000000),'+01:00');
        $this->assertSame($date->date('T',-7000000000),'CET');
        $this->assertSame($date->date('Z',-7000000000),'3600');
        $this->assertSame($date->date('c',-7000000000),'1748-3-16T11:33:20+01:00');
        $this->assertSame($date->date('r',-7000000000),'Sat, 16 Mar 1748 11:33:20 +0100');
        $this->assertSame($date->date('U',-7000000000),'-7000000000');
        $this->assertSame($date->date('\\H',-7000000000),'H');
        $this->assertSame($date->date('.',-7000000000),'.');
        $this->assertSame($date->date('H:m:s',-7000000000),'11:03:20');
        $this->assertSame($date->date('d-M-Y',-7000000000),'16-Mar-1748');
        $this->assertSame($date->date('U',6900000000,true),'6899996400');
    }
}