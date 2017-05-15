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

    $case1 = $d1E->between($d2S, $d2E);
    $case2 = $d1S->between($d2S, $d2E);
    $case3 = $d1S->lt($d2S) && $d1E->gt($d2E);

    return ($case1 || $case2 || $case3);
  }

}
