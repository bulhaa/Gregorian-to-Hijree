  /**
   * This function will convert Meelaadhee date to Hijree date
   * @param string $data date
   * @param string $adjustText optional text used to adjust date, eg:- "+1 day" to add a day, will be passed to strtotime function along with date
   */
  public static function convertMeelaadheeToHijree($date, $adjustText = "") {
    $dateDMY = DateTime::createFromFormat('d/m/Y', $date);
    if($dateDMY != false){
      $date = strtotime($dateDMY->format('Y-m-d') . ' ' . $adjustText); // if DMY format (default format used in Maldives)
    }else
      $date = strtotime($date . ' ' . $adjustText);

    $criteria=new CDbCriteria;
    $criteria->condition='year_start<=:date AND :date<=year_end';
    $criteria->params=array(':date'=>date("Y-m-d", $date));
    $row=HijreeYears::model()->find($criteria); // $params is not needed

    if($row != null){
      $year_start = strtotime($row->year_start);
      $year = $row->year;

      $days = timeStampDifference($date, $year_start) + 1;

      for($month = 1; $month <= 12; $month++){
        $days_in_month = $row->{'days_in_month_'.$month};
        if($days <= $days_in_month){
          break;
        }else{
          $days = $days - $days_in_month;

          if($month == 12)
            $days = null;
        }
      }
    }

    $dateArr = [
        'success' => false,
        'day' => '???',
        'month' => '???',
        'year' => '???',
    ];

    if(!empty($days)){
      $dateArr = array(
        'success' => true,
        'day' => ($days<10 ? '0'.$days : $days),
        'month' => ($month<10 ? '0'.$month : $month),
        'year' => $year,
        );
    }
    return $dateArr;
  }
        
        
  function timeStampDifference($date_1 , $date_2 , $differenceFormat = '%a' )
  {
      $datetime1 = date("Y-m-d", $date_1);
      $datetime2 = date("Y-m-d", $date_2);

      return dateDifference($datetime1, $datetime2, $differenceFormat);
  }

  //////////////////////////////////////////////////////////////////////
  //PARA: Date Should In YYYY-MM-DD Format
  //RESULT FORMAT:
  // '%y Year %m Month %d Day %h Hours %i Minute %s Seconds'        =>  1 Year 3 Month 14 Day 11 Hours 49 Minute 36 Seconds
  // '%y Year %m Month %d Day'                                    =>  1 Year 3 Month 14 Days
  // '%m Month %d Day'                                            =>  3 Month 14 Day
  // '%d Day %h Hours'                                            =>  14 Day 11 Hours
  // '%d Day'                                                        =>  14 Days
  // '%h Hours %i Minute %s Seconds'                                =>  11 Hours 49 Minute 36 Seconds
  // '%i Minute %s Seconds'                                        =>  49 Minute 36 Seconds
  // '%h Hours                                                    =>  11 Hours
  // '%a Days                                                        =>  468 Days
  //////////////////////////////////////////////////////////////////////
  function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' )
  {
      $datetime1 = date_create($date_1);
      $datetime2 = date_create($date_2);
      
      $interval = date_diff($datetime1, $datetime2);
      
      return $interval->format($differenceFormat);
      
  }
