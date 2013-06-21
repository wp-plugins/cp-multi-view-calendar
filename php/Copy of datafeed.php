<?php

$method = $_GET["method"];
$calid = $_GET["calid"];

switch ($method) {
    case "add":
        $ret = addCalendar($calid, $_POST["CalendarStartTime"], $_POST["CalendarEndTime"], $_POST["CalendarTitle"], $_POST["IsAllDayEvent"], $_POST["location"]);
        break;
    case "list":
    
        //$ret = listCalendar($_POST["showdate"], $_POST["viewtype"]);
        $d1 = js2PhpTime($_POST["startdate"]);
        $d2 = js2PhpTime($_POST["enddate"]);
        
        $d1 = mktime(0, 0, 0,  date("m", $d1), date("d", $d1), date("Y", $d1));
        $d2 = mktime(0, 0, 0, date("m", $d2), date("d", $d2), date("Y", $d2))+24*60*60-1;
        

        $ret = listCalendarByRange($calid, ($d1),($d2));
        break;
    case "update":
        $ret = updateCalendar($_POST["calendarId"], $_POST["CalendarStartTime"], $_POST["CalendarEndTime"]);
        break; 
    case "remove":
        $ret = removeCalendar( $_POST["calendarId"]);
        break;
    case "adddetails":
        $st = $_POST["stpartdate"] . " " . $_POST["stparttime"];
        $et = $_POST["etpartdate"] . " " . $_POST["etparttime"];
        if(isset($_GET["id"])){
            $ret = updateDetailedCalendar($_GET["id"], $st, $et, 
                $_POST["Subject"], isset($_POST["IsAllDayEvent"])?1:0, $_POST["Description"], 
                $_POST["Location"], $_POST["colorvalue"], $_POST["timezone"]);
        }else{
            $ret = addDetailedCalendar($calid, $st, $et,                    
                $_POST["Subject"], isset($_POST["IsAllDayEvent"])?1:0, $_POST["Description"], 
                $_POST["Location"], $_POST["colorvalue"], $_POST["timezone"]);
        }        
        break; 


}
echo json_encode($ret);

function rquote2 ($str)  
{  	 
    if (get_magic_quotes_gpc () == 1 && (strpos($str, "'") === false || !(strpos($str, "\'") === false)))
        return $str;
    else
        return addslashes($str);
}

function addCalendar($calid, $st, $et, $sub, $ade, $loc){
  global $wpdb;
  $ret = array();
  try{
    $sql = "insert into `".DC_MV_CAL."` (`".DC_MV_CAL_IDCAL."`,`".DC_MV_CAL_TITLE."`, `".DC_MV_CAL_FROM."`, `".DC_MV_CAL_TO."`, `".DC_MV_CAL_ISALLDAY."`, `".DC_MV_CAL_LOCATION."`) values ('".$calid."','"
      .rquote2($sub)."', '"
      .php2MySqlTime(js2PhpTime($st))."', '"
      .php2MySqlTime(js2PhpTime($et))."', '"
      .rquote2($ade)."', '"
      .rquote2($loc)."' )";    
	if($wpdb->query($sql)==false){
      $ret['IsSuccess'] = false;
      $ret['Msg'] = $wpdb->last_error;
    }else{
      $ret['IsSuccess'] = true;
      $ret['Msg'] = 'add success';
      $ret['Data'] = $wpdb->insert_id;
    }
	}catch(Exception $e){
     $ret['IsSuccess'] = false;
     $ret['Msg'] = $e->getMessage();
  }
  return $ret;
}


function addDetailedCalendar($calid, $st, $et, $sub, $ade, $dscr, $loc, $color, $tz){
  global $wpdb;
  $ret = array();
  try{
    $sql = "insert into `".DC_MV_CAL."` (`".DC_MV_CAL_IDCAL."`,`".DC_MV_CAL_TITLE."`, `".DC_MV_CAL_FROM."`, `".DC_MV_CAL_TO."`, `".DC_MV_CAL_ISALLDAY."`, `".DC_MV_CAL_DESCRIPTION."`, `".DC_MV_CAL_LOCATION."`, `".DC_MV_CAL_COLOR."`) values ('".$calid."','"
      .rquote2($sub)."', '"
      .php2MySqlTime(js2PhpTime($st))."', '"
      .php2MySqlTime(js2PhpTime($et))."', '"
      .rquote2($ade)."', '"
      .rquote2($dscr)."', '"
      .rquote2($loc)."', '"
      .rquote2($color)."' )";    
	if($wpdb->query($sql)==false){
      $ret['IsSuccess'] = false;
      $ret['Msg'] = $wpdb->last_error;
    }else{
      $ret['IsSuccess'] = true;
      $ret['Msg'] = 'add success';
      $ret['Data'] = $wpdb->insert_id;
    }
	}catch(Exception $e){
     $ret['IsSuccess'] = false;
     $ret['Msg'] = $e->getMessage();
  }
  return $ret;
}

function listCalendarByRange($calid,$sd, $ed){
  global $wpdb;  
  $ret = array();
  $ret['events'] = array();
  $ret["issort"] =true;
  $ret["start"] = php2JsTime($sd);
  $ret["end"] = php2JsTime($ed);
  $ret['error'] = null;
  try{
    $sql = "select * from `".DC_MV_CAL."` where ".DC_MV_CAL_IDCAL."='".$calid."' and ( (`".DC_MV_CAL_FROM."` between '"
      .php2MySqlTime($sd)."' and '". php2MySqlTime($ed)."') or (`".DC_MV_CAL_TO."` between '"
      .php2MySqlTime($sd)."' and '". php2MySqlTime($ed)."') or (`".DC_MV_CAL_FROM."` <= '"
      .php2MySqlTime($sd)."' and `".DC_MV_CAL_TO."` >= '". php2MySqlTime($ed)."') ) order by  ".DC_MV_CAL_FROM."  ";
      
    $handle = $wpdb->get_results($sql, ARRAY_A);
    foreach ($handle as $row) {
      $ret['events'][] = array(
        $row[DC_MV_CAL_ID],
        $row[DC_MV_CAL_TITLE],
        php2JsTime(mySql2PhpTime($row[DC_MV_CAL_FROM])),
        php2JsTime(mySql2PhpTime($row[DC_MV_CAL_TO])),
        $row[DC_MV_CAL_ISALLDAY],
        0, //more than one day event
        //$row->InstanceType,
        0,//Recurring event,
        $row[DC_MV_CAL_COLOR],
        1,//editable
        $row[DC_MV_CAL_LOCATION], 
        '',//$attends
        $row[DC_MV_CAL_DESCRIPTION]
      );
    }
	}catch(Exception $e){
     $ret['error'] = $e->getMessage();
  }
  return $ret;
}
function listCalendar($day, $type){
  global $wpdb;
  $phpTime = js2PhpTime($day);
  
  switch($type){
    case "month":
      $st = mktime(0, 0, 0, date("m", $phpTime), 1, date("Y", $phpTime));
      $et = mktime(0, 0, -1, date("m", $phpTime)+1, 1, date("Y", $phpTime));
      break;
    case "week":
      //suppose first day of a week is monday 
      $monday  =  date("d", $phpTime) - date('N', $phpTime) + 1;      
      $st = mktime(0,0,0,date("m", $phpTime), $monday, date("Y", $phpTime));
      $et = mktime(0,0,-1,date("m", $phpTime), $monday+7, date("Y", $phpTime));
      break;
    case "day":
      $st = mktime(0, 0, 0, date("m", $phpTime), date("d", $phpTime), date("Y", $phpTime));
      $et = mktime(0, 0, -1, date("m", $phpTime), date("d", $phpTime)+1, date("Y", $phpTime));
      break;
  }
  
  return listCalendarByRange($st, $et);
}

function updateCalendar($id, $st, $et){
  global $wpdb;  
  $ret = array();
  try{
    $sql = "update `".DC_MV_CAL."` set"
      . " `".DC_MV_CAL_FROM."`='" . php2MySqlTime(js2PhpTime($st)) . "', "
      . " `".DC_MV_CAL_TO."`='" . php2MySqlTime(js2PhpTime($et)) . "' "
      . "where `id`=" . $id;
    
	if($wpdb->query($sql)==false){
      $ret['IsSuccess'] = false;
      $ret['Msg'] = $wpdb->last_error;
    }else{
      $ret['IsSuccess'] = true;
      $ret['Msg'] = 'Succefully';
    }
	}catch(Exception $e){
     $ret['IsSuccess'] = false;
     $ret['Msg'] = $e->getMessage();
  }
  return $ret;
}

function updateDetailedCalendar($id, $st, $et, $sub, $ade, $dscr, $loc, $color, $tz){
  global $wpdb;
  $ret = array();
  try{    
    $sql = "update `".DC_MV_CAL."` set"
      . " `".DC_MV_CAL_FROM."`='" . php2MySqlTime(js2PhpTime($st)) . "', "
      . " `".DC_MV_CAL_TO."`='" . php2MySqlTime(js2PhpTime($et)) . "', "
      . " `".DC_MV_CAL_TITLE."`='" . rquote2($sub) . "', "
      . " `".DC_MV_CAL_ISALLDAY."`='" . rquote2($ade) . "', "
      . " `".DC_MV_CAL_DESCRIPTION."`='" . rquote2($dscr) . "', "
      . " `".DC_MV_CAL_LOCATION."`='" . rquote2($loc) . "', "
      . " `".DC_MV_CAL_COLOR."`='" . rquote2($color) . "' "
      . "where `id`=" . $id;
    
	if($wpdb->query($sql)==false){
      $ret['IsSuccess'] = false;
      $ret['Msg'] = $wpdb->last_error;
    }else{
      $ret['IsSuccess'] = true;
      $ret['Msg'] = 'Succefully';
    }
	}catch(Exception $e){
     $ret['IsSuccess'] = false;
     $ret['Msg'] = $e->getMessage();
  }
  return $ret;
}

function removeCalendar($id){
  global $wpdb;  
  $ret = array();
  try{
    $sql = "delete from `".DC_MV_CAL."` where `id`=" . $id;
	if($wpdb->query($sql)==false){
      $ret['IsSuccess'] = false;
      $ret['Msg'] = $wpdb->last_error;
    }else{
      $ret['IsSuccess'] = true;
      $ret['Msg'] = 'Succefully';
    }
	}catch(Exception $e){
     $ret['IsSuccess'] = false;
     $ret['Msg'] = $e->getMessage();
  }
  return $ret;
}
 



?>