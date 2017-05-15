<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use AppBundle\Entity\Teacher;

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

  /**
   * @ORM\ManyToOne(targetEntity="Teacher", inversedBy="recurrentAvailabilities")
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
     * Set weekDay
     *
     * @param integer $weekDay
     *
     * @return RecurrentAvailability
     */
    public function setWeekDay($weekDay)
    {
        $this->weekDay = $weekDay;

        return $this;
    }

    /**
     * Get weekDay
     *
     * @return integer
     */
    public function getWeekDay()
    {
        return $this->weekDay;
    }

    /**
     * Set start
     *
     * @param \DateTime $start
     *
     * @return RecurrentAvailability
     */
    public function setStart($start)
    {
        $dateTime = \DateTime::createFromFormat("H:i:s", $start);
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
     * @return RecurrentAvailability
     */
    public function setEnd($end)
    {
      $dateTime = \DateTime::createFromFormat("H:i:s", $end);
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
     * @param Teacher $teacher
     *
     * @return RecurrentAvailability
     */
    public function setTeacher(Teacher $teacher = null)
    {
        $this->teacher = $teacher;

        return $this;
    }

    /**
     * Get teacher
     *
     * @return Teacher
     */
    public function getTeacher()
    {
        return $this->teacher;
    }
}
