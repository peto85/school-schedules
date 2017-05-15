<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

use Doctrine\Common\Collections\ArrayCollection;

use AppBundle\Entity\Teacher;
use AppBundle\Entity\OneTimeUnavailability;
use AppBundle\Entity\RecurrentAvailability;

class TeacherController extends Controller {

  private $teacherManager;
  private $availabilityManager;
  private $serializer;

  public function setContainer(ContainerInterface $container = null) {
    parent::setContainer($container);
    // Retrieve some service we will use often
    $this->teacherManager = $this->container->get('app.teacher_manager');
    $this->availabilityManager = $this->container->get('app.availability_manager');

    // Add a serializer
    $encoder = new JsonEncoder();
    $normalizer = new ObjectNormalizer();
    $normalizer->setCircularReferenceHandler(function ($obj) {
      return $obj->getName();
    });

    $this->serializer = new Serializer([$normalizer], [$encoder]);
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

    $jsonData = json_decode($request->getContent());

    $teacherId = $jsonData->teacherId;
    $availability = json_encode($jsonData->availability);

    $recurrentAvailability = $this->serializer->deserialize($availability, RecurrentAvailability::class, 'json');

    $this->availabilityManager->addAvailability($teacherId, $recurrentAvailability);

    return JsonResponse::fromJsonString('{ "result" : "success" }');
  }

  /**
  * @Route("/teacher-unavailability")
  * @Method({"POST"})
  */
  public function unavailabilityAction(Request $request) {
    $jsonData = json_decode($request->getContent());

    $teacherId = $jsonData->teacherId;
    $unavailability = json_encode($jsonData->unavailability);

    $oneTimeUnavailability = $this->serializer->deserialize($unavailability, OneTimeUnavailability::class, 'json');

    $this->availabilityManager->addUnavailability($teacherId, $oneTimeUnavailability);

    return JsonResponse::fromJsonString('{ "result" : "success" }');
  }


  /**
  * @Route("/available-teachers")
  * @Method({"GET"})
  */
  public function matchesAction(Request $request) {
    $jobId = $request->query->get('job_uuid');

    // Retrieve some service we will use often
    $jobManager = $this->container->get('app.job_manager');

    $job = json_decode($jobManager->fetchJob($jobId));

    $availableTeachers = $this->availabilityManager->findAvailableTeachers($job);

    return $this->json($availableTeachers);
  }
}
