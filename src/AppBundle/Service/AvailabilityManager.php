<?php

namespace AppBundle\Service;

use GuzzleHttp\Client;

use AppBundle\Entity\RecurrentAvailability;
use AppBundle\Entity\OneTimeUnavailability;

class AvailabilityManager {

  private $em;
  private $teachers;
  private $availabilities;
  private $unavailabilities;
  private $dateHelper;

  public function __construct($em, $dateHelper) {
    $this->em = $em;
    $this->teachers = $em->getRepository('AppBundle:Teacher');;
    $this->availabilities = $em->getRepository('AppBundle:RecurrentAvailability');
    $this->unavailabilities = $em->getRepository('AppBundle:OneTimeUnavailability');
    $this->dateHelper = $dateHelper;
  }

  public function addAvailability($teacherId, $availability) {
    $teacher = $this->teachers->find($teacherId);
    $availability->setTeacher($teacher);
    $this->em->persist($availability);
    $this->em->flush();
  }

  public function addUnavailability($teacherId, $unavailability) {
    $teacher = $this->teachers->find($teacherId);
    $unavailability->setTeacher($teacher);
    $this->em->persist($unavailability);
    $this->em->flush();
  }

  public function findAvailableTeachers($job) {
    // convenience
    $jobShifts = $job->shifts;
    $jobCategory = $job->category;
    // initialise empty
    $availableTeachers = [];
    // find all the teachers with the same category
    $possibleTeachers = $this->teachers->findByCategory($jobCategory);

    foreach ($possibleTeachers as $teacher) {
      // printf("checking teacher: %s\n", $teacher->getName());
      foreach($jobShifts as $shift) {
        $shiftStart = \DateTime::createFromFormat('Y-m-d H:i:s', $shift->start);
        $shiftEnd = \DateTime::createFromFormat('Y-m-d H:i:s', $shift->end);
        // printf("\tchecking shift: [%s - %s] (weekDay: %d)\n", $shiftStart->format('Y-m-d H:i:s'), $shiftEnd->format('Y-m-d H:i:s'), $this->dateHelper->getWeekDay($shiftStart));

        // check unavailabilities first
        $checkedUnavailabilities = $this->checkUnavailabilities($shiftStart, $shiftEnd, $teacher->getOneTimeUnavailabilities());
        // check avaialabilities second
        $checkedAvailabilities = $this->checkAvailabilities($shiftStart, $shiftEnd, $teacher->getRecurrentAvailabilities());

        // if teacher is not available, skip to the next teacher
        // if teacher is available, continue with the next shift to check
        if (!$checkedUnavailabilities || !$checkedAvailabilities) {
          continue(2);
        }
      }
      // if teacher is available for all the shifts, add him to the list
      // printf("teacher is available for all the shifts\n");
      $availableTeachers[] = $teacher->getName();
    }

    return $availableTeachers;
  }

  // return true if teacher is available for the shift, based on his unavailabilities
  private function checkUnavailabilities($shiftStart, $shiftEnd, $unavailabilities) {
    foreach ($unavailabilities as $unavailability) {
      $unavailabilityStart = $unavailability->getStart();
      $unavailabilityEnd = $unavailability->getEnd();
      // printf("\t\tchecking unavailability: [%s - %s]\n", $unavailabilityStart->format('Y-m-d H:i:s'), $unavailabilityEnd->format('Y-m-d H:i:s'));

      if ($this->dateHelper->checkDateOverlap($shiftStart,$shiftEnd, $unavailabilityStart, $unavailabilityEnd)) {
        // printf("\t\t\tfound an unavailability for this teacher, skipping teacher");
        return false;
      }
    }
    // printf("\t\tall unavailabilities were good for this shift");
    return true;
  }

  // return true if teacher is available for the shift, based on his availabilities
  private function checkAvailabilities($shiftStart, $shiftEnd, $availabilities) {
    $shiftWeekDay = $this->dateHelper->getWeekDay($shiftStart);

    foreach ($availabilities as $availability) {
      $availabilityStartTime = $availability->getStart();
      $availabilityEndTime = $availability->getEnd();
      $availabilityWeekDay = $availability->getWeekDay();
      // printf("\t\tchecking availability: [%s - %s] (weekDay = %d)\n", $availabilityStartTime->format('H:i:s'), $availabilityEndTime->format('H:i:s'), $availabilityWeekDay);

      if ($availabilityWeekDay != $shiftWeekDay) {
        // printf("\t\t\tskipping availability: not the same weekDay\n");
        continue(1);
      }

      if ($this->dateHelper->checkAvailabilityForShift($shiftStart, $shiftEnd, $availabilityStartTime, $availabilityEndTime)) {
        // printf("\t\t\tfound an availability for this shift");
        return true;
      }
    }
    // printf("\t\t\tdidn't find any availability for this shift");
    return false;
  }

}
