<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;

class JobController extends Controller {

  public function setContainer(ContainerInterface $container = null) {
    parent::setContainer($container);
    // Retrieve some service we will use often
    $this->jobManager = $this->container->get('app.job_manager');
  }

  /**
  * @Route("/job")
  * @Method({"GET"})
  */
  public function indexAction(Request $request) {
    // retrieve uuid from query
    $uuid = $request->query->get('uuid');
    // retrieve the job
    $job = $this->jobManager->getJob($uuid);

    return JsonResponse::fromJsonString($job);
  }
}
