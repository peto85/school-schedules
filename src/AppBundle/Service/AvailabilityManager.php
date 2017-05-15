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

  public function __construct($em) {
    $this->em = $em;
    $this->teachers = $em->getRepository('AppBundle:Teacher');;
    $this->availabilities = $em->getRepository('AppBundle:RecurrentAvailability');
    $this->unavailabilities = $em->getRepository('AppBundle:OneTimeUnavailability');
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

}
