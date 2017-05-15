<?php

namespace AppBundle\Service;

use GuzzleHttp\Client;

use AppBundle\Entity\Teacher;

class TeacherManager {

  private $em;
  private $teachers;
  private $serializer;

  public function __construct($em) {
    $this->em = $em;
    $this->teachers = $em->getRepository('AppBundle:Teacher');
  }

  public function fetchTeacher($id) {
    $teacher = $this->teachers->find($id);
    return $teacher;
  }

  public function saveTeacher($teacher) {
    $this->em->persist($teacher);
    $this->em->flush();
  }

}
