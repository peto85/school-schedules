<?php

namespace AppBundle\Service;

use GuzzleHttp\Client;

class JobManager {

  private $client;

  public function __construct($baseUri) {
    $this->client = new Client([
      // Base URI is used with relative requests
      'base_uri' => $baseUri
    ]);
  }

  public function getJob($uuid = null) {
    if ($uuid == null) {
      return $this->getRandomJob();
    } else {
      return $this->getJobWithId($uuid);
    }
  }

  public function getRandomJob() {
    $job = $this->client->get('jobs');
    return ($job->getBody());
  }

  public function getJobWithId($uuid) {
    $job = $this->client->get("jobs?uuid={$uuid}");
    return ($job->getBody());
  }
}
