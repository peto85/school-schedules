<?php

namespace Tests\AppBundle\Util;

use PHPUnit\Framework\TestCase;

use AppBundle\Util\DateHelper;

class DateHelperTest extends TestCase {

  public function testCheckDateOverlap() {
    $dateHelper = new DateHelper();

    // overlaping dates (left side)
    $d1Start = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-01 10:00:00');
    $d1End = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-01 16:00:00');
    $d2Start = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-01 08:00:00');;
    $d2End = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-01 12:00:00');
    $this->assertTrue($dateHelper->checkDateOverlap($d1Start, $d1End, $d2Start, $d2End));

    // overlaping dates (right side)
    $d1Start = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-01 10:00:00');
    $d1End = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-01 16:00:00');
    $d2Start = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-01 12:00:00');;
    $d2End = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-01 18:00:00');
    $this->assertTrue($dateHelper->checkDateOverlap($d1Start, $d1End, $d2Start, $d2End));

    // overlaping dates (d1 contained in d2)
    $d1Start = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-01 10:00:00');
    $d1End = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-01 16:00:00');
    $d2Start = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-01 08:00:00');;
    $d2End = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-01 18:00:00');
    $this->assertTrue($dateHelper->checkDateOverlap($d1Start, $d1End, $d2Start, $d2End));

    // overlaping dates (d2 contained in d1)
    $d1Start = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-01 10:00:00');
    $d1End = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-01 16:00:00');
    $d2Start = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-01 12:00:00');;
    $d2End = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-01 14:00:00');
    $this->assertTrue($dateHelper->checkDateOverlap($d1Start, $d1End, $d2Start, $d2End));

    // not overlaping dates
    $d1Start = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-01 10:00:00');
    $d1End = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-01 16:00:00');
    $d2Start = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-01 18:00:00');;
    $d2End = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-01 20:00:00');
    $this->assertFalse($dateHelper->checkDateOverlap($d1Start, $d1End, $d2Start, $d2End));

    // not overlaping dates (but continuous slots)
    $d1Start = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-01 10:00:00');
    $d1End = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-01 16:00:00');
    $d2Start = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-01 16:00:00');;
    $d2End = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-01 20:00:00');
    $this->assertFalse($dateHelper->checkDateOverlap($d1Start, $d1End, $d2Start, $d2End));
  }

  public function testCheckAvailabilityForShift() {
    $dateHelper = new DateHelper();

    // availability covers shift
    $shiftStart = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-01 10:00:00');
    $shiftEnd = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-01 16:00:00');
    $availabilityStart = \DateTime::createFromFormat('H:i:s', '08:00:00');
    $availabilityEnd = \DateTime::createFromFormat('H:i:s', '20:00:00');
    $this->assertTrue($dateHelper->checkAvailabilityForShift($shiftStart, $shiftEnd, $availabilityStart, $availabilityEnd));

    // availability only covers shift partially (left side)
    $shiftStart = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-01 10:00:00');
    $shiftEnd = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-01 16:00:00');
    $availabilityStart = \DateTime::createFromFormat('H:i:s', '08:00:00');
    $availabilityEnd = \DateTime::createFromFormat('H:i:s', '14:00:00');
    $this->assertFalse($dateHelper->checkAvailabilityForShift($shiftStart, $shiftEnd, $availabilityStart, $availabilityEnd));

    // availability only covers shift partially (right side)
    $shiftStart = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-01 10:00:00');
    $shiftEnd = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-01 16:00:00');
    $availabilityStart = \DateTime::createFromFormat('H:i:s', '12:00:00');
    $availabilityEnd = \DateTime::createFromFormat('H:i:s', '20:00:00');
    $this->assertFalse($dateHelper->checkAvailabilityForShift($shiftStart, $shiftEnd, $availabilityStart, $availabilityEnd));

    // availability only covers shift partially (contained)
    $shiftStart = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-01 10:00:00');
    $shiftEnd = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-01 16:00:00');
    $availabilityStart = \DateTime::createFromFormat('H:i:s', '12:00:00');
    $availabilityEnd = \DateTime::createFromFormat('H:i:s', '14:00:00');
    $this->assertFalse($dateHelper->checkAvailabilityForShift($shiftStart, $shiftEnd, $availabilityStart, $availabilityEnd));

    // availability does not cover shift
    $shiftStart = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-01 10:00:00');
    $shiftEnd = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-01 16:00:00');
    $availabilityStart = \DateTime::createFromFormat('H:i:s', '06:00:00');
    $availabilityEnd = \DateTime::createFromFormat('H:i:s', '08:00:00');
    $this->assertFalse($dateHelper->checkAvailabilityForShift($shiftStart, $shiftEnd, $availabilityStart, $availabilityEnd));
  }
}
