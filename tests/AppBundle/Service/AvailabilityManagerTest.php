<?php

namespace Tests\AppBundle\Util;

use PHPUnit\Framework\TestCase;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Collections\ArrayCollection;

use AppBundle\Service\AvailabilityManager;
use AppBundle\Entity\Teacher;
use AppBundle\Entity\OneTimeUnavailability;
use AppBundle\Entity\RecurrentAvailability;
use AppBundle\Util\DateHelper;

class AvailabilityManagerTest extends TestCase {

  private $emMock;

  public function setUp() {
    $teachers = new ArrayCollection([
      // Mock teacher
      $this->createTeacherMock('Teacher 1',
        // Mock unavailabilities
        new ArrayCollection([

        ]),
        // Mock availabilities
        new ArrayCollection([
          $this->createAvailabilityMock(0, '10:00:00', '20:00:00'),
          $this->createAvailabilityMock(1, '10:00:00', '20:00:00')
        ])
      ),
      // Mock teacher 2
      $this->createTeacherMock('Teacher 2',
        // Mock unavailabilities
        new ArrayCollection([

        ]),
        // Mock availabilities
        new ArrayCollection([
          $this->createAvailabilityMock(0, '10:00:00', '20:00:00')
        ])
      ),
      // Mock teacher 3
      $this->createTeacherMock('Teacher 3',
        // Mock unavailabilities
        new ArrayCollection([
          $this->createUnavailabilityMock('2017-01-02 10:00:00', '2017-01-02 14:00:00'),
        ]),
        // Mock availabilities
        new ArrayCollection([
          $this->createAvailabilityMock(0, '10:00:00', '20:00:00'),
          $this->createAvailabilityMock(1, '10:00:00', '20:00:00')
        ])
      )
    ]);

    // Mock teacher repo
    $teacherRepository = $this
      ->getMockBuilder(EntityRepository::class)
      ->disableOriginalConstructor()
      ->getMock();
    $teacherRepository->expects($this->any())
      ->method('__call')
      ->with('findByCategory', $this->anything())
      ->will($this->returnValue($teachers));

    // mock the entity manager
    $entityManager = $this
      ->getMockBuilder(EntityManager::class)
      ->disableOriginalConstructor()
      ->getMock();
    $entityManager->expects($this->exactly(3))
      ->method('getRepository')
      ->withConsecutive(['AppBundle:Teacher'], ['AppBundle:RecurrentAvailability'], ['AppBundle:OneTimeUnavailability'])
      ->willReturnOnConsecutiveCalls($teacherRepository, null, null);

    $this->emMock = $entityManager;
  }


  public function testFindAvailableTeachers() {

    $dateHelper = new DateHelper();

    // construct the service with the mocked entity manager
    $availabilityManager = new AvailabilityManager($this->emMock, $dateHelper);

    $job1 = json_decode('
      {
        "uuid" : "test",
        "name": "test",
        "shifts" : [
          {
            "start" : "2017-01-01 15:00:00",
            "end" : "2017-01-01 18:00:00"
          },
          {
            "start" : "2017-01-02 10:00:00",
            "end" : "2017-01-02 12:00:00"
          },
          {
            "start" : "2017-01-02 15:00:00",
            "end" : "2017-01-02 18:00:00"
          }
        ],
        "category" : "test"
      }
    ');

    $teacherList = $availabilityManager->findAvailableTeachers($job1);
    $expectedTeacherList = ['Teacher 1'];
    sort($teacherList);
    sort($expectedTeacherList);

    $this->assertEquals($teacherList, $expectedTeacherList);
  }

  // Helper methods
  private function createUnavailabilityMock($startDateString, $endDateString) {
    $startDate = \DateTime::createFromFormat('Y-m-d H:i:s', $startDateString);
    $endDate = \DateTime::createFromFormat('Y-m-d H:i:s', $endDateString);

    $unavailability = $this->createMock(OneTimeUnavailability::class);
    $unavailability->expects($this->any())
      ->method('getStart')
      ->will($this->returnValue($startDate));
    $unavailability->expects($this->any())
      ->method('getEnd')
      ->will($this->returnValue($endDate));

    return $unavailability;
  }

  private function createAvailabilityMock($weekDay, $startTimeString, $endTimeString) {
    $startTime = \DateTime::createFromFormat('H:i:s', $startTimeString);
    $endTime = \DateTime::createFromFormat('H:i:s', $endTimeString);

    $availability = $this->createMock(RecurrentAvailability::class);
    $availability->expects($this->any())
      ->method('getWeekDay')
      ->will($this->returnValue($weekDay));
    $availability->expects($this->any())
      ->method('getStart')
      ->will($this->returnValue($startTime));
    $availability->expects($this->any())
      ->method('getEnd')
      ->will($this->returnValue($endTime));

    return $availability;
  }

  private function createTeacherMock($name, $unavailabilities, $availabilities) {
    $teacher = $this->createMock(Teacher::class);
    $teacher->expects($this->any())
      ->method('getName')
      ->will($this->returnValue($name));
    $teacher->expects($this->any())
      ->method('getOneTimeUnavailabilities')
      ->will($this->returnValue($unavailabilities));
    $teacher->expects($this->any())
      ->method('getRecurrentAvailabilities')
      ->will($this->returnValue($availabilities));

    return $teacher;
  }


}
