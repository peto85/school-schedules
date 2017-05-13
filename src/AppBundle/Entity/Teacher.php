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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->recurrentAvailabilities = new \Doctrine\Common\Collections\ArrayCollection();
        $this->oneTimeUnavailabilities = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param \AppBundle\Entity\RecurrentAvailability $recurrentAvailability
     *
     * @return Teacher
     */
    public function addRecurrentAvailability(\AppBundle\Entity\RecurrentAvailability $recurrentAvailability)
    {
        $this->recurrentAvailabilities[] = $recurrentAvailability;

        return $this;
    }

    /**
     * Remove recurrentAvailability
     *
     * @param \AppBundle\Entity\RecurrentAvailability $recurrentAvailability
     */
    public function removeRecurrentAvailability(\AppBundle\Entity\RecurrentAvailability $recurrentAvailability)
    {
        $this->recurrentAvailabilities->removeElement($recurrentAvailability);
    }

    /**
     * Get recurrentAvailabilities
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecurrentAvailabilities()
    {
        return $this->recurrentAvailabilities;
    }

    /**
     * Add oneTimeUnavailability
     *
     * @param \AppBundle\Entity\OneTimeUnavailability $oneTimeUnavailability
     *
     * @return Teacher
     */
    public function addOneTimeUnavailability(\AppBundle\Entity\OneTimeUnavailability $oneTimeUnavailability)
    {
        $this->oneTimeUnavailabilities[] = $oneTimeUnavailability;

        return $this;
    }

    /**
     * Remove oneTimeUnavailability
     *
     * @param \AppBundle\Entity\OneTimeUnavailability $oneTimeUnavailability
     */
    public function removeOneTimeUnavailability(\AppBundle\Entity\OneTimeUnavailability $oneTimeUnavailability)
    {
        $this->oneTimeUnavailabilities->removeElement($oneTimeUnavailability);
    }

    /**
     * Get oneTimeUnavailabilities
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOneTimeUnavailabilities()
    {
        return $this->oneTimeUnavailabilities;
    }
}
