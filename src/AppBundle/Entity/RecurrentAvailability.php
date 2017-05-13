<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="recurrent_availability")
 */
class RecurrentAvailability {
  /**
   * @ORM\Column(type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @ORM\Column(type="integer")
   */
  private $weekDay;

  /**
   * @ORM\Column(type="time")
   */
  private $start;

  /**
   * @ORM\Column(type="time")
   */
  private $end;
}
