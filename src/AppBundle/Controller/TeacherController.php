<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Entity\Teacher;

class TeacherController extends Controller {

  /**
  * @Route("/teacher")
  * @Method({"POST"})
  */
  public function indexAction(Request $request) {
    $teacher = new Teacher();
    $teacher->setName($this->request->get('name'));
    $teacher->setCategory($this->request->get('category'));

    $em = $this->getDoctrine()->getManager();

    // tells Doctrine you want to (eventually) save the Product (no queries yet)
    $em->persist($teacher);

    // actually executes the queries (i.e. the INSERT query)
    $em->flush();

    return JsonResponse::fromJsonString('[ \'success\' ]');
  }
}
