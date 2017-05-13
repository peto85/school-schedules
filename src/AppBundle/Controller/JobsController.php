<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use GuzzleHttp\Client;

class JobsController extends Controller {
  /**
  * @Route("/jobs")
  */
  public function indexAction() {
    $client = new Client([
      // Base URI is used with relative requests
      'base_uri' => 'https://staging.tempbuddy.com/public/api/',
    ]);

    $jobs = $client->get('jobs');
    return JsonResponse::fromJsonString($jobs->getBody());
  }
}
