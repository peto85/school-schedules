SchoolSchedules
===============

- Assumption: Job shifts are always contained in the same day.
  eg: a job can't start on monday 23:00 and end on tuesday 01:00.

- Assumption: Job shift can have multiple time slots, but these can't be
  continuos. Eg. A job can't have a shift with these two slots for the same day
  [10:00:00 - 13:00:00] and [13:00:00].

- To enter RecurrentAvailability, the weekDay (Sunday = 0, Saturday = 7)
