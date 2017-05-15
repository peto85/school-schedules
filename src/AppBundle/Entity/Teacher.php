<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use AppBundle\Entity\RecurrentAvailability;
use AppBundle\Entity\OneTimeUnavailability;

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
     * One teachers has many recurrent availabilities
     * @ORM\OneToMany(targetEntity="RecurrentAvailability", mappedBy="teacher"))
  **/
  private $recurrentAvailabilities;

  /**
     * One teachers has many one-time unavailabilities
     * @ORM\OneToMany(targetEntity="OneTimeUnavailability", mappedBy="teacher"))
  **/
  private $oneTimeUnavailabilities;

  /**
   * Constructor
   */
  public function __construct()
  {
      $this->recurrentAvailabilities = new ArrayCollection();
      $this->oneTimeUnavailabilities = new ArrayCollection();
  }

  /**
   * Get id
   *
   * @return integer
   */
  public function getId()
  {
      return $this->id;
  }

  /**
   * Set name
   *
   * @param string $name
   *
   * @return Teacher
   */
  public function setName($name)
  {
      $this->name = $name;

      return $this;
  }

  /**
   * Get name
   *
   * @return string
   */
  public function getName()
  {
      return $this->name;
  }

  /**
   * Set category
   *
   * @param string $category
   *
   * @return Teacher
   */
  public function setCategory($category)
  {
      $this->category = $category;

      return $this;
  }

  /**
   * Get category
   *
   * @return string
   */
  public function getCategory()
  {
      return $this->category;
  }

  /**
   * Add recurrentAvailability
   *
   * @param RecurrentAvailability $recurrentAvailability
   *
   * @return Teacher
   */
  public function addRecurrentAvailability(RecurrentAvailability $recurrentAvailability)
  {
      $this->recurrentAvailabilities[] = $recurrentAvailability;

      return $this;
  }

  /**
   * Remove recurrentAvailability
   *
   * @param RecurrentAvailability $recurrentAvailability
   */
  public function removeRecurrentAvailability(RecurrentAvailability $recurrentAvailability)
  {
      $this->recurrentAvailabilities->removeElement($recurrentAvailability);
  }

  /**
   * Get recurrentAvailabilities
   *
   * @return Collection
   */
  public function getRecurrentAvailabilities()
  {
      return $this->recurrentAvailabilities;
  }

  /**
   * Add oneTimeUnavailability
   *
   * @param OneTimeUnavailability $oneTimeUnavailability
   *
   * @return Teacher
   */
  public function addOneTimeUnavailability(OneTimeUnavailability $oneTimeUnavailability)
  {
      $this->oneTimeUnavailabilities[] = $oneTimeUnavailability;

      return $this;
  }

  /**
   * Remove oneTimeUnavailability
   *
   * @param OneTimeUnavailability $oneTimeUnavailability
   */
  public function removeOneTimeUnavailability(OneTimeUnavailability $oneTimeUnavailability)
  {
      $this->oneTimeUnavailabilities->removeElement($oneTimeUnavailability);
  }

  /**
   * Get oneTimeUnavailabilities
   *
   * @return Collection
   */
  public function getOneTimeUnavailabilities()
  {
      return $this->oneTimeUnavailabilities;
  }
}
