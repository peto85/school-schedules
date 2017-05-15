<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;

use AppBundle\Entity\Teacher;

class TeacherController extends Controller {

  private $teacherManager;
  private $serializer;

  public function setContainer(ContainerInterface $container = null) {
    parent::setContainer($container);
    // Retrieve some service we will use often
    $this->teacherManager = $this->container->get('app.teacher_manager');
    $this->serializer = $this->container->get('serializer');
  }

  /**
  * @Route("/teacher")
  * @Method({"GET"})
  */
  public function fetchAction(Request $request) {
    $id = $request->query->get('id');

    $teacher = $this->teacherManager->fetchTeacher($id);
    $response = $this->serializer->serialize($teacher, 'json');

    return JsonResponse::fromJsonString($response);
  }

  /**
  * @Route("/teacher")
  * @Method({"POST"})
  */
  public function saveAction(Request $request) {
    // get the raw body data
    $data = $request->getContent();

    // deserialize the json data into a teacher object
    $teacher = $this->serializer->deserialize($data, Teacher::class, 'json');
    // persist the teacher in DB
    $this->teacherManager->saveTeacher($teacher);

    return JsonResponse::fromJsonString('{ "result" : "success" }');
  }

  /**
  * @Route("/teacher-availability")
  * @Method({"POST"})
  */
  public function availabilityAction(Request $request) {
    return JsonResponse::fromJsonString('{ "result" : "success" }');
  }

  /**
  * @Route("/teacher-unavailability")
  * @Method({"POST"})
  */
  public function unavailabilityAction(Request $request) {
    return JsonResponse::fromJsonString('{ "result" : "success" }');
  }
}
