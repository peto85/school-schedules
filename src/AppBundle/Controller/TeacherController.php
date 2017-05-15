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
    $name = $request->request->get('name');
    $category = $request->request->get('category');

    // retrieve the teacher manager service
    $teacherManager = $this->container->get('app.teacher_manager');

    $teacherManager->saveTeacher($name, $category);

    return JsonResponse::fromJsonString('{ \'result: success\' }');
  }

  /**
  * @Route("/teacher-availability")
  * @Method({"POST"})
  */
  public function availabilityAction(Request $request) {
    return JsonResponse::fromJsonString('{ \'result: success\' }');
  }
}
