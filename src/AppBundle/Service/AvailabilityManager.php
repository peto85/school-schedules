<?php

namespace AppBundle\Service;

use GuzzleHttp\Client;

use AppBundle\Entity\RecurrentAvailability;
use AppBundle\Entity\OneTimeUnavailability;

class AvailabilityManager {

  private $em;

  public function __construct($em) {
    $this->em = $em;
  }

}
