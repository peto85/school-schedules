<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class JobController extends Controller {

  /**
  * @Route("/job")
  * @Method({"GET"})
  */
  public function indexAction(Request $request) {

    // retrieve the job manager service
    $jobManager = $this->container->get('app.job_manager');

    if ($request->query->has('uuid')) {
      // extract uuid
      $uuid = $request->query->get('uuid');
      $job = $jobManager->getJob($uuid);
    } else {
      $job = $jobManager->getRandomJob();
    }

    return JsonResponse::fromJsonString($job);
  }
}
