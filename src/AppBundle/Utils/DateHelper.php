<?

namespace AppBundle\Utils;

use Carbon\Carbon;

class DateHelper {

  public function __construct() {

  }

  // Checks if date1 overlaps with date2
  public function checkDateOverlap($d1Start, $d1End, $d2Start, $d2End) {
    $d1S = Carbon::instance($d1Start);
    $d1E = Carbon::instance($d1End);
    $d2S = Carbon::instance($d2Start);
    $d2E = Carbon::instance($d2End);

    $case1 = $d1E->between($d2S, $d2E, false);
    $case2 = $d1S->between($d2S, $d2E, false);
    $case3 = $d1S->lt($d2S) && $d1E->gt($d2E);

    return ($case1 || $case2 || $case3);
  }

  // Checks if the shift is contained within the availability time slot
  public function checkAvailabilityForShift($shiftStart, $shiftEnd, $availabilityStart, $availabilityEnd) {
    $sS = Carbon::instance($shiftStart);
    $sE = Carbon::instance($shiftEnd);

    $aS = Carbon::instance($availabilityStart);
    $aE = Carbon::instance($availabilityEnd);

    $aS->year = $sS->year;
    $aS->month = $sS->month;
    $aS->day = $sS->day;

    $aE->year = $sE->year;
    $aE->month = $sE->month;
    $aE->day = $sE->day;

    // return if [sS, sE] is contained within [aS, aE]
    return ($sS->between($aS, $aE, true) && $sE->between($aS, $aE, true));
  }


  // Finds the day of the week for a date
  public function getWeekDay($d) {
    return Carbon::instance($d)->dayOfWeek;
  }

}
