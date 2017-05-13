<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="teacher")
 */
class Teacher {
  /**
   * @ORM\Column(type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @ORM\Column(type="string", length=100)
   */
  private $name;

  /**
   * @ORM\Column(type="string", length=100)
   */
  private $category;


  /**
     * Many teachers have many recurrent availabilities
     * @ORM\ManyToMany(targetEntity="RecurrentAvailability")
     * @ORM\JoinTable(name="teacher_is_available",
     *   joinColumns={@ORM\JoinColumn(name="teacher_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="recurrent_availability_id", referencedColumnName="id", unique=true)}
     * )
  **/
  private $recurrentAvailabilities;

  /**
     * Many teachers have many one time unavailabilities
     * @ORM\ManyToMany(targetEntity="OneTimeUnavailability")
     * @ORM\JoinTable(name="teacher_is_unavailable",
     *   joinColumns={@ORM\JoinColumn(name="teacher_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="one_time_unavailability_id", referencedColumnName="id", unique=true)}
     * )
  **/
  private $oneTimeUnavailabilities;
}
