<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use AppBundle\Entity\Teacher;

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

  /**
   * @ORM\ManyToOne(targetEntity="Teacher", inversedBy="oneTimeUnavailabilities")
   * @ORM\JoinColumn(name="teacher_id", referencedColumnName="id")
   */
  private $teacher;



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
     * Set start
     *
     * @param \DateTime $start
     *
     * @return OneTimeUnavailability
     */
    public function setStart($start)
    {
      $dateTime = \DateTime::createFromFormat('Y-m-d H:i:s', $start);
      $this->start = $dateTime;
      return $this;
    }

    /**
     * Get start
     *
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set end
     *
     * @param \DateTime $end
     *
     * @return OneTimeUnavailability
     */
    public function setEnd($end)
    {
      $dateTime = \DateTime::createFromFormat('Y-m-d H:i:s', $end);
      $this->end = $dateTime;
      return $this;
    }

    /**
     * Get end
     *
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set teacher
     *
     * @param \AppBundle\Entity\Teacher $teacher
     *
     * @return OneTimeUnavailability
     */
    public function setTeacher(\AppBundle\Entity\Teacher $teacher = null)
    {
        $this->teacher = $teacher;

        return $this;
    }

    /**
     * Get teacher
     *
     * @return \AppBundle\Entity\Teacher
     */
    public function getTeacher()
    {
        return $this->teacher;
    }
}
