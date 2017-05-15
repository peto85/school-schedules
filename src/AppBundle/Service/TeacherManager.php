<?php

namespace AppBundle\Service;

use GuzzleHttp\Client;

use AppBundle\Entity\Teacher;

class TeacherManager {

  private $em;
  private $repository;
  private $serializer;

  public function __construct($em) {
    $this->em = $em;
    $this->repository = $em->getRepository('AppBundle:Teacher');
  }

  public function fetchTeacher($id) {
    $teacher = $this->repository->find($id);
    return $teacher;
  }

  public function saveTeacher($teacher) {
    $this->em->persist($teacher);
    $this->em->flush();
  }

}
