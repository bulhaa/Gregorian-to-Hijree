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

      $days = commonHelper::timeStampDifference($date, $year_start) + 1;

      if($days <= $row->days_in_month_1){
        $month = 1;
      }else{
        $days = $days - $row->days_in_month_1;

        if($days <= $row->days_in_month_2){
          $month = 2;
        }else{
          $days = $days - $row->days_in_month_2;

          if($days <= $row->days_in_month_3){
            $month = 3;
          }else{
            $days = $days - $row->days_in_month_3;

            if($days <= $row->days_in_month_4){
              $month = 4;
            }else{
              $days = $days - $row->days_in_month_4;

              if($days <= $row->days_in_month_5){
                $month = 5;
              }else{
                $days = $days - $row->days_in_month_5;

                if($days <= $row->days_in_month_6){
                  $month = 6;
                }else{
                  $days = $days - $row->days_in_month_6;

                  if($days <= $row->days_in_month_7){
                    $month = 7;
                  }else{
                    $days = $days - $row->days_in_month_7;

                    if($days <= $row->days_in_month_8){
                      $month = 8;
                    }else{
                      $days = $days - $row->days_in_month_8;

                      if($days <= $row->days_in_month_9){
                        $month = 9;
                      }else{
                        $days = $days - $row->days_in_month_9;

                        if($days <= $row->days_in_month_10){
                          $month = 10;
                        }else{
                          $days = $days - $row->days_in_month_10;

                          if($days <= $row->days_in_month_11){
                            $month = 11;
                          }else{
                            $days = $days - $row->days_in_month_11;

                            if($days <= $row->days_in_month_12){
                              $month = 12;
                            }else{
                              $days = null;
                            }
                          }
                        }
                      }
                    }
                  }
                }
              }
            }
          }
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