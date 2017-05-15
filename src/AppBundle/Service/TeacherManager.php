<?php

namespace AppBundle\Service;

use GuzzleHttp\Client;

use AppBundle\Entity\Teacher;

class TeacherManager {

  private $em;

  public function __construct($em) {
    $this->em = $em;
  }

  public function saveTeacher($name, $category) {
    $teacher = new Teacher();
    $teacher->setName($name);
    $teacher->setCategory($category);

    // tells Doctrine you want to (eventually) save the Product (no queries yet)
    $this->em->persist($teacher);

    // actually executes the queries (i.e. the INSERT query)
    $this->em->flush();
  }
}
