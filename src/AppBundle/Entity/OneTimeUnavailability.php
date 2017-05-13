<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="one_time_unavailability")
 */
class OneTimeUnavailability {
  /**
   * @ORM\Column(type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @ORM\Column(type="datetime")
   */
  private $start;

  /**
   * @ORM\Column(type="datetime")
   */
  private $end;
}
