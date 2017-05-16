SchoolSchedules
===============

Please read these instructions to run the exercise application. Also, there are some comments and thoughts that are important to understand some of the decisions made while working on this project.

Enjoy!

# Requirements

1. Docker
2. PHP 7.0+ (if want to run the tests locally)

# Installation

Once you have downloaded the repo, you can run the docker environment using [docker-compose](https://docs.docker.com/compose/):
```
$ docker-compose up -d
```

You can now install the project dependencies by running [composer](https://getcomposer.org/) (which is already downloaded in the php docker container). Accept the suggested parameters when creating the `parameters.yml` file.
```
$ docker-compose run php composer install
```

After dependencies are installed, the database schema needs to be created. Since entities are annotated with Doctrine annotations, we can leverage the symfony console for this:
```
$ docker-compose run php bin/console doctrine:schema:create
```

Finally, you need to add an entry for the chosen domain name for this application in your [hosts](https://www.howtogeek.com/howto/27350/beginner-geek-how-to-edit-your-hosts-file/) file:
```
127.0.0.1 schoolschedules.dev
```

*Note:* The IP address might need to be different depending on your docker installation. You might have to find the docker machine ip by using  `docker-machine ip <name of your machine>`.

# Usage

The following endpoints are available:

### GET /job
Get a random job (or a specific job if a `uuid` parameter is provided)
[GET] http://schoolschedules.dev:8080/app_dev.php/job?uuid=a2134581-0573-4e8a-bfa2-f31679dbde60

### GET /teacher
Get a teacher by its id (required)
[GET] http://schoolschedules.dev:8080/app_dev.php/teacher?id=1

### POST /teacher
Insert a teacher in the system. The POST content (raw) should be similar to this:
```
{
	"name": "Juan",
	"category": "GroupA"
}
```
[POST] http://schoolschedules.dev:8080/app_dev.php/teacher

### POST /teacher-availability
Insert a teacher's recurrent availability time slot in the system. The POST content (raw) should be similar to this:
```
{
	"teacherId": 1,
	"availability" : {
		"weekDay" : 0,
		"start": "01:00:00",
		"end": "04:00:00"
	}
}
```
[POST] http://schoolschedules.dev:8080/app_dev.php/teacher-availability

### POST /teacher-unavailability
Insert a teacher's one time unavailability time slot in the system. The POST content (raw) should be similar to this:
```
{
	"teacherId": 1,
	"unavailability" : {
      "start": "2017-06-05 02:00:00",
      "end": "2017-06-05 03:00:00"
	}
}
```
[POST] http://schoolschedules.dev:8080/app_dev.php/teacher-unavailability

### GET /available-teachers
Returns a list of available teacher names for a random job (or a specific job if a `job_uuid` parameter is provided). If no teachers are available for the job, an empty list is returned.

[GET] http://schoolschedules.dev:8080/app_dev.php/available-teachers?job_uuid=a2134581-0573-4e8a-bfa2-f31679dbde60

### Notes about endpoint usage
These endpoints aren't very robust, so errors caused by things like lack of validation or uncaught exceptions might happen. Please see the notes comments section below to read more about this.

# Tests
To run the unit tests, simply run:
```
php phpunit.phar
```

# Comments / Assumptions

A few notes about the decisions made while developing this application:

- There are many things that are not set up / implemented in this application, such as validation, error and exception handling, database constraints, etc. Symfony is a very rich framework and the objective was to create a simple but usable application based on the problem description, within the short-ish timeframe given.

- The data model for the availabilities/unavailabilities and the logic that handles them to find teacher's availability for the jobs is a very first approach. I thought it would be a better idea to get a simple but working version of the application (and possibly discuss enhancements in a future interview) than offering a sophisticated but non-finished, unusable version of the application.

Also, a few assumptions were made to limit the problem scope, specially around possible edge cases:

- Job shifts are assumed to not span through multiple days, eg. a job shift can't start on Monday 23:00 and finish on Tuesday 01:00.

- Even when teachers can have multiple recurrent availability time slots for one day, they are assumed to not be contiguous, eg. a teacher can't have these two slots for one day: `[10:00:00 - 13:00:00] and [13:00:00 - 15:00:00]`, but they can have these two: `[10:00:00 - 13:00:00] and [14:00:00 - 16:00:00]`.

- When setting recurrent availability time slots, the day of the week goes from `Sunday = 0` , `Monday = 1`, ... to ` Saturday = 6`.
