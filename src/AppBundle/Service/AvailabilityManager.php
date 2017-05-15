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
      foreach($jobShifts as $shift) {
        $shiftStart = \DateTime::createFromFormat('Y-m-d H:i:s', $shift->start);
        $shiftEnd = \DateTime::createFromFormat('Y-m-d H:i:s', $shift->end);

        // check unavailabilities first
        foreach ($teacher->getOneTimeUnavailabilities() as $unavailability) {
          $unavailabilityStart = $unavailability->getStart();
          $unavailabilityEnd = $unavailability->getEnd();

          if ($this->dateHelper->checkDateOverlap($shiftStart,$shiftEnd, $unavailabilityStart, $unavailabilityEnd)) {
            continue(3); // skip to the next teacher
          }
        }


      }
      // teacher was available in all shift, adding to the the result list
      $availableTeachers[] = $teacher->getName();
    }
    return $availableTeachers;
  }

}
