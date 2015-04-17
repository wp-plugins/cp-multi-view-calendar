<?php

//require_once( JPATH_COMPONENT.'/DC_MultiViewCal/php/functions.php' );
//require_once( JPATH_BASE.'/components/com_multicalendar/DC_MultiViewCal/php/list.inc.php' );

define("JC_NO_OVERLAPPING_TIME",false);
define("JC_NO_OVERLAPPING_SUBJECT",false);
define("JC_NO_OVERLAPPING_LOCATION",false);

$_POST = stripslashes_deep( $_POST );

$method = $_GET["method"];
$calid = intval($_GET["calid"]);
$_GET["id"] = intval(@$_GET["id"]);
switch ($method) {
    case "add":
        $ret = addCalendar($calid, $this->get_param("CalendarStartTime"), $this->get_param("CalendarEndTime"), $this->get_param("CalendarTitle"), $this->get_param("IsAllDayEvent"), $this->get_param("location"));
        break;
    case "list":
        if ($_POST["viewtype"]=='list')
            $ret = listCalendarByPage($calid, $_POST["list_start"], $_POST["list_end"], $_POST["list_order"], $_POST["list_eventsPerPage"], $_POST["lastdate"]);
        else
        {
            $d1 = js2PhpTime($this->get_param("startdate"));
            $d2 = js2PhpTime($this->get_param("enddate"));
            
            $d1 = mktime(0, 0, 0,  date("m", $d1), date("d", $d1), date("Y", $d1));
            $d2 = mktime(0, 0, 0, date("m", $d2), date("d", $d2), date("Y", $d2))+24*60*60-1;
            $ret = listCalendarByRange($calid, ($d1),($d2));
        }
        break;
    case "update":
        $ret = updateCalendar($this->get_param("calendarId"), $this->get_param("CalendarStartTime"), $this->get_param("CalendarEndTime"));
        break;
    case "remove":
        $ret = removeCalendar( $this->get_param("calendarId"),$this->get_param("rruleType"));
        break;
    case "adddetails":

        $st = $this->get_param("stpartdatelast") . " " . $this->get_param("stparttimelast");
        $et = $this->get_param("etpartdatelast") . " " . $this->get_param("etparttimelast");
        if($this->get_param("id")!=""){

            $ret = updateDetailedCalendar($this->get_param("id"), $st, $et,
                $this->get_param("Subject"), ($this->get_param("IsAllDayEvent")==1)?1:0, $this->get_param('Description') ,
                $this->get_param("Location"), $this->get_param("colorvalue"), $this->get_param("rrule"),$this->get_param("rruleType"), $this->get_param("timezone"));
        }else{

            $ret = addDetailedCalendar($calid, $st, $et,$this->get_param("Subject"), ($this->get_param("IsAllDayEvent")==1)?1:0, $this->get_param('Description') ,
                $this->get_param("Location"), $this->get_param("colorvalue"), $this->get_param("rrule"),0, $this->get_param("timezone"));
        }
        break;


}
echo json_encode($ret);
function checkIfOverlappingThisEvent($id, $st, $et)
{
    global $wpdb;
    $sql = "select * from `".DC_MV_CAL."` where id=".intval(esc_sql($id));

    $handle = $wpdb->get_results($sql);
    if ( $handle )
        return checkIfOverlapping($handle[0]->calid, $st, $et, $handle[0]->title, $handle[0]->location,$id);
    else
        return true;
}
function checkIfOverlapping($calid, $st, $et, $sub, $loc,$id)
{
    global $wpdb;    
    $sd = date("Y-m-d H:i:s",js2PhpTime($st));
    $ed = date("Y-m-d H:i:s",js2PhpTime($et));
    $condition = "";  
    if (JC_NO_OVERLAPPING_TIME)
        $condition .= " and ( (`".DC_MV_CAL_FROM."` > '"
      .($sd)."' and `".DC_MV_CAL_FROM."` < '". ($ed)."') or (`".DC_MV_CAL_TO."` > '"
      .($sd)."' and `".DC_MV_CAL_TO."` < '". ($ed)."') or (`".DC_MV_CAL_FROM."` <= '"
      .($sd)."' and `".DC_MV_CAL_TO."` >= '". ($ed)."') )   ";
    if (JC_NO_OVERLAPPING_SUBJECT)
        $condition .= " and ( `".DC_MV_CAL_TITLE."` = '". $sub."' )   ";
    if (JC_NO_OVERLAPPING_LOCATION)
        $condition .= " and ( `".DC_MV_CAL_LOCATION."` = '". $loc."' )   ";
    if ($condition=="")
        $condition = " and 1=0";
    $sql = "select * from `".DC_MV_CAL."` where ".DC_MV_CAL_IDCAL."=".$calid.$condition;

    $handle = $wpdb->get_results($sql);
    if (!$handle || (count($handle)==1 && $handle[0]->id==$id))
        return true;
    else
        return false;

}
function getMessageOverlapping()
{
    $ret = array();
    $ret['IsSuccess'] = false;
    $ret['Msg'] = "OVERLAPPING";
    return $ret;
}
function addCalendar($calid, $st, $et, $sub, $ade, $loc){
  global $wpdb;  
  $ret = array(); 
  $user = wp_get_current_user();
  try{
    if (checkIfOverlapping($calid, $st, $et,$sub, $loc,0))
    {
    $sql = "insert into `".DC_MV_CAL."` (`".DC_MV_CAL_IDCAL."`,`".DC_MV_CAL_TITLE."`, `".DC_MV_CAL_FROM."`, `".DC_MV_CAL_TO."`, `".DC_MV_CAL_ISALLDAY."`, `".DC_MV_CAL_LOCATION."`, `owner`, `published`) values ('".$calid."','"
      .esc_sql($sub)."', '"
      .php2MySqlTime(js2PhpTime($st))."', '"
      .php2MySqlTime(js2PhpTime($et))."', '"
      .esc_sql($ade)."', '"
      .esc_sql($loc)."', ".$user->ID.",1)";
    
    if ($wpdb->query($sql)=== FALSE){
      $ret['IsSuccess'] = false;
      $ret['Msg'] = $wpdb->last_error;
    }else{
      $ret['IsSuccess'] = true;
      $ret['Msg'] = 'add success';
      $ret['Data'] = $wpdb->insert_id;
    }
    }
    else
     $ret = getMessageOverlapping();

	}catch(Exception $e){
     $ret['IsSuccess'] = false;
     $ret['Msg'] = $e->getMessage();
  }

  return $ret;
}


function addDetailedCalendar($calid, $st, $et, $sub, $ade, $dscr, $loc, $color, $rrule,$uid,$tz){
  global $wpdb;
  $ret = array();

  $user = wp_get_current_user();
  try{
    if (checkIfOverlapping($calid, $st, $et,$sub, $loc,0))
    {
    $sql = "insert into `".DC_MV_CAL."` (`".DC_MV_CAL_IDCAL."`,`".DC_MV_CAL_TITLE."`, `".DC_MV_CAL_FROM."`, `".DC_MV_CAL_TO."`, `".DC_MV_CAL_ISALLDAY."`, `".DC_MV_CAL_DESCRIPTION."`, `".DC_MV_CAL_LOCATION."`, `".DC_MV_CAL_COLOR."`,`rrule`,`uid`,`owner`, `published`) values ('".$calid."','"
      .esc_sql($sub)."', '"
      .php2MySqlTime(js2PhpTime($st))."', '"
      .php2MySqlTime(js2PhpTime($et))."', '"
      .esc_sql($ade)."', '"
      .esc_sql($dscr)."', '"
      .esc_sql($loc)."', '"
      .esc_sql($color)."', '".esc_sql($rrule)."', ".esc_sql($uid).", ".$user->ID.",1 )";
    
    if ($wpdb->query($sql)=== FALSE){
      $ret['IsSuccess'] = false;
      $ret['Msg'] = $wpdb->last_error;
    }else{
      $ret['IsSuccess'] = true;
      $ret['Msg'] = 'add success';
      $ret['Data'] = $wpdb->insert_id;
    }
    }
    else
     $ret = getMessageOverlapping();
	}catch(Exception $e){
     $ret['IsSuccess'] = false;
     $ret['Msg'] = $e->getMessage();
  }
  return $ret;
}
function listCalendarByPage($calid, $list_start, $list_end, $list_order, $list_eventsPerPage, $lastdate){
  global $wpdb;
  $ret = array();
  $ret['events'] = array();
  $ret["issort"] =true;
  $ret['error'] = null;
  $ret["start"] = "";
  $ret["end"] = "";  
  try{
  $cond = DC_MV_CAL_IDCAL."=".intval(esc_sql($calid))." and (rrule='' or rrule is null)";
  if ($list_start!="")
  {
      if ($list_order=="asc")
      {
          $cond .= " and (`".DC_MV_CAL_FROM."`>='".date("Y-m-d H:i:s",strtotime($list_start))."')"; 
          $ret["start"] = strtotime($list_start);
      }
      else
      {
          $cond .= " and (`".DC_MV_CAL_FROM."`<='".date("Y-m-d H:i:s",strtotime($list_start))."')"; 
          $ret["end"] = strtotime($list_start);
      }
  }    
  if ($list_end!="")
  {
      if ($list_order=="asc")
      {
          $cond .= " and (`".DC_MV_CAL_TO."`<='".date("Y-m-d H:i:s",strtotime($list_end))."')";    
          $ret["end"] = strtotime($list_end);
      }
      else
      {
          $cond .= " and (`".DC_MV_CAL_TO."`>='".date("Y-m-d H:i:s",strtotime($list_end))."')"; 
          $ret["start"] = strtotime($list_end);
      }
      
  }    
  if ($lastdate!="")
  {
      if ($list_order=="asc")
      {
          $cond .= " and (`".DC_MV_CAL_FROM."`>='".date("Y-m-d H:i:s",strtotime($lastdate))."')";
          $ret["start"] = strtotime($lastdate);
      }    
      else
      {
          $cond .= " and (`".DC_MV_CAL_FROM."`<='".date("Y-m-d H:i:s",strtotime($lastdate))."')";      
          $ret["end"] = strtotime($lastdate);
      }   
  }    
  $sql = "select * from `".DC_MV_CAL."` where ".$cond." order by  ".DC_MV_CAL_FROM." ".(strtolower($list_order)=='asc'?'asc':'desc')." limit 0,".($list_eventsPerPage+1);
  $rows2 = $wpdb->get_results($sql);
  $sql = "select * from `".DC_MV_CAL."` where ".DC_MV_CAL_IDCAL."=".$calid." and rrule<>''";
  //echo $sql;
  $rows1 = $wpdb->get_results($sql);
  $rows = array_merge($rows1,$rows2);
    if (!$rows){
          $ret['IsSuccess'] = false;
          $ret['Msg'] = $wpdb->last_error;
    }


    $str = "";
    for ($i=0;$i<count($rows);$i++)
    {
        $row = $rows[$i];
        //
        if ($list_order=="desc")
        {
            if ($row->rrule=="" && ($ret["start"]=="" || $ret["start"]!="" && strtotime($row->starttime)<$ret["start"]))
                $ret["start"] = strtotime($row->starttime);
            if ($row->rrule=="" && ($ret["end"]=="" || $ret["end"]!="" && strtotime($row->endtime)>$ret["end"]))
                $ret["end"] = strtotime($row->endtime);
        }    
        $row = $rows[$i];
        if (strlen($row->exdate)>0)
            $row->rrule .= ";exdate=".$row->exdate;
        $ev = array(
            $row->id,
            $row->title,
            php2JsTime(mySql2PhpTime($row->starttime)),
            php2JsTime(mySql2PhpTime($row->endtime)),
            $row->isalldayevent,
            0, //more than one day event
            //$row->InstanceType,
            ((is_numeric($row->uid) && $row->uid>0)?$row->uid:$row->rrule),//Recurring event rule,
            $row->color,
            1,//editable
            $row->location,
            '',//$attends
            $row->description,
            $row->owner,
            $row->published
        );
        $ret['events'][] = $ev;
    }
	}catch(Exception $e){
     $ret['error'] = $e->getMessage();
  }
  if ($ret["start"]!="") $ret["start"] = date("m/d/Y H:i",$ret["start"]);
  if ($ret["end"]!="") $ret["end"] = date("m/d/Y H:i",$ret["end"]);
  if ($list_order=="desc" && $ret["end"]=="") $ret["end"] = date("m/d/Y H:i");
  //if ($list_order=="desc" && $ret["start"]=="") $ret["start"] = date("m/d/Y H:i");
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
    $sql = "select * from `".DC_MV_CAL."` where ".DC_MV_CAL_IDCAL."=".$calid." and ( (`".DC_MV_CAL_FROM."` between '"
      .php2MySqlTime($sd)."' and '". php2MySqlTime($ed)."') or (`".DC_MV_CAL_TO."` between '"
      .php2MySqlTime($sd)."' and '". php2MySqlTime($ed)."') or (`".DC_MV_CAL_FROM."` <= '"
      .php2MySqlTime($sd)."' and `".DC_MV_CAL_TO."` >= '". php2MySqlTime($ed)."') or rrule<>'') order by uid desc,  ".DC_MV_CAL_FROM."  ";

    $rows = $wpdb->get_results($sql);
    if (!$rows){
          $ret['IsSuccess'] = false;
          $ret['Msg'] = $wpdb->last_error;
    }


    $str = "";
    for ($i=0;$i<count($rows);$i++)
    {
        $row = $rows[$i];
        if (strlen($row->exdate)>0)
            $row->rrule .= ";exdate=".$row->exdate;
        $ev = array(
            $row->id,
            $row->title,
            php2JsTime(mySql2PhpTime($row->starttime)),
            php2JsTime(mySql2PhpTime($row->endtime)),
            $row->isalldayevent,
            0, //more than one day event
            //$row->InstanceType,
            ((is_numeric($row->uid) && $row->uid>0)?$row->uid:$row->rrule),//Recurring event rule,
            $row->color,
            1,//editable
            $row->location,
            '',//$attends
            $row->description,
            $row->owner,
            $row->published
        );
        $ret['events'][] = $ev;
    }
	}catch(Exception $e){
     $ret['error'] = $e->getMessage();
  }
  return $ret;
}
function listCalendar($day, $type){
  $phpTime = js2PhpTime($day);
  //echo $phpTime . "+" . $type;
  switch($type){
    case "month":
      $st = mktime(0, 0, 0, date("m", $phpTime), 1, date("Y", $phpTime));
      $et = mktime(0, 0, -1, date("m", $phpTime)+1, 1, date("Y", $phpTime));
      break;
    case "week":
      //suppose first day of a week is monday
      $monday  =  date("d", $phpTime) - date('N', $phpTime) + 1;
      //echo date('N', $phpTime);
      $st = mktime(0,0,0,date("m", $phpTime), $monday, date("Y", $phpTime));
      $et = mktime(0,0,-1,date("m", $phpTime), $monday+7, date("Y", $phpTime));
      break;
    case "day":
      $st = mktime(0, 0, 0, date("m", $phpTime), date("d", $phpTime), date("Y", $phpTime));
      $et = mktime(0, 0, -1, date("m", $phpTime), date("d", $phpTime)+1, date("Y", $phpTime));
      break;
  }
  //echo $st . "--" . $et;
  return listCalendarByRange($st, $et);
}

function updateCalendar($id, $st, $et){
  global $wpdb;
  $ret = array();  
  try{  
    if (checkIfOverlappingThisEvent($id, $st, $et))
    {
        $sql = "update `".DC_MV_CAL."` set"
          . " `".DC_MV_CAL_FROM."`='" . php2MySqlTime(js2PhpTime($st)) . "', "
          . " `".DC_MV_CAL_TO."`='" . php2MySqlTime(js2PhpTime($et)) . "' "
          . "where `id`=" . intval(esc_sql($id));        
        if ($wpdb->query($sql)=== FALSE){
          $ret['IsSuccess'] = false;
          $ret['Msg'] = $wpdb->last_error;
        }else{
          $ret['IsSuccess'] = true;
          $ret['Msg'] = 'Succefully';
        }
    }
    else
         $ret = getMessageOverlapping();
	}catch(Exception $e){
     $ret['IsSuccess'] = false;
     $ret['Msg'] = $e->getMessage();
  }
  return $ret;
}

function updateDetailedCalendar($id, $st, $et, $sub, $ade, $dscr, $loc, $color, $rrule,$rruleType,$tz){
  global $wpdb;
  $ret = array();  
  $calid = $_GET['calid'];
  try{ 
    if (checkIfOverlapping($calid, $st, $et,$sub,$loc,$id))
    { 
        if ($rruleType=="only")
        { 
            return addDetailedCalendar($calid, $st, $et, $sub, $ade, $dscr, $loc, $color, "",$id,$tz);   
        }        
        else if ($rruleType=="all")
        {
            $sql = "update `".DC_MV_CAL."` set"
              //. " `".DC_MV_CAL_FROM."`='" . php2MySqlTime(js2PhpTime($st)) . "', "
              //. " `".DC_MV_CAL_TO."`='" . php2MySqlTime(js2PhpTime($et)) . "', "
              . " `".DC_MV_CAL_TITLE."`='" . esc_sql($sub) . "', "
              . " `".DC_MV_CAL_ISALLDAY."`='" . esc_sql($ade) . "', "
              . " `".DC_MV_CAL_DESCRIPTION."`='" . esc_sql($dscr) . "', "
              . " `".DC_MV_CAL_LOCATION."`='" . esc_sql($loc) . "', "
              . " `".DC_MV_CAL_COLOR."`='" . esc_sql($color) . "', "
              . " `rrule`='" . esc_sql($rrule) . "' "
              . "where `id`=" . $id;            
            if ($wpdb->query($sql)=== FALSE){
              $ret['IsSuccess'] = false;
              $ret['Msg'] = $wpdb->last_error;
            }else{
              $ret['IsSuccess'] = true;
              $ret['Msg'] = 'Succefully';
            }
        }        
        else if (substr($rruleType,0,5)=="UNTIL")
        {
            $sql = "select * from `".DC_MV_CAL."` where id=".intval(esc_sql($id));

            $rows = $wpdb->get_results($sql);
            $pre_rrule = $rows[0]->rrule;
            //remove until
            $tmp = explode(";UNTIL=",$pre_rrule);
            if (count($tmp)>1)
            {
                $pre_rrule = $tmp[0];
                $tmp2 = explode(";",$tmp[1]); 
                if (count($tmp2)>1)
                    $pre_rrule .= ";".$tmp2[1]; 
            }
            //add
            $pre_rrule .= ";".$rruleType;
            $sql = "update `".DC_MV_CAL."` set"
              . " `rrule`='" . esc_sql($pre_rrule) . "' "
              . "where `id`=" . $id;            
            $wpdb->query($sql);
            return addDetailedCalendar($calid, $st, $et, $sub, $ade, $dscr, $loc, $color, $rrule,0,$tz);
        }
        else 
        {
            $sql = "update `".DC_MV_CAL."` set"
              . " `".DC_MV_CAL_FROM."`='" . php2MySqlTime(js2PhpTime($st)) . "', "
              . " `".DC_MV_CAL_TO."`='" . php2MySqlTime(js2PhpTime($et)) . "', "
              . " `".DC_MV_CAL_TITLE."`='" . esc_sql($sub) . "', "
              . " `".DC_MV_CAL_ISALLDAY."`='" . esc_sql($ade) . "', "
              . " `".DC_MV_CAL_DESCRIPTION."`='" . esc_sql($dscr) . "', "
              . " `".DC_MV_CAL_LOCATION."`='" . esc_sql($loc) . "', "
              . " `".DC_MV_CAL_COLOR."`='" . esc_sql($color) . "', "
              . " `rrule`='" . esc_sql($rrule) . "' "
              . "where `id`=" . $id;            
            if ($wpdb->query($sql)=== FALSE){
              $ret['IsSuccess'] = false;
              $ret['Msg'] = $wpdb->last_error;
            }else{
              $ret['IsSuccess'] = true;
              $ret['Msg'] = 'Succefully';
            }
        }
    }
    else
        $ret = getMessageOverlapping();
	}catch(Exception $e){	    
     $ret['IsSuccess'] = false;
     $ret['Msg'] = $e->getMessage();
  }
  return $ret;
}

function removeCalendar($id,$rruleType){
  global $wpdb;
  $ret = array();  
  try{
        if (substr($rruleType,0,8)=="del_only")
        {
            $sql = "select * from `".DC_MV_CAL."` where id=".intval(esc_sql($id));

            $rows = $wpdb->get_results($sql);
            $exdate = $rows[0]->exdate.substr($rruleType,8);
            
            $sql = "update `".DC_MV_CAL."` set"
              . " `exdate`='" . esc_sql($exdate) . "' "
              . "where `id`=" . $id;
            
            if ($wpdb->query($sql)=== FALSE){
              $ret['IsSuccess'] = false;
              $ret['Msg'] = $wpdb->last_error;
            }else{
              $ret['IsSuccess'] = true;
              $ret['Msg'] = 'Succefully';
            }
        }  
        else if (substr($rruleType,0,9)=="del_UNTIL")
        {
            $sql = "select * from `".DC_MV_CAL."` where id=".intval(esc_sql($id));

            $rows = $wpdb->get_results($sql);
            $pre_rrule = $rows[0]->rrule;
            //remove until
            $tmp = explode(";UNTIL=",$pre_rrule);
            if (count($tmp)>1)
            {
                $pre_rrule = $tmp[0];
                $tmp2 = explode(";",$tmp[1]); 
                if (count($tmp2)>1)
                    $pre_rrule .= ";".$tmp2[1]; 
            }
            //add
            $pre_rrule .= ";".substr($rruleType,4);
            $sql = "update `".DC_MV_CAL."` set"
              . " `rrule`='" . esc_sql($pre_rrule) . "' "
              . "where `id`=" . $id;  
            if ($wpdb->query($sql)=== FALSE){
              $ret['IsSuccess'] = false;
              $ret['Msg'] = $wpdb->last_error;
            }else{
              $ret['IsSuccess'] = true;
              $ret['Msg'] = 'Succefully';
            }
            
        }
        else  // $rruleType = "del_all" or ""
        {
            $sql = "delete from `".DC_MV_CAL."` where `id`=" . intval(esc_sql($id));	        
            if ($wpdb->query($sql)=== FALSE){
              $ret['IsSuccess'] = false;
              $ret['Msg'] = $wpdb->last_error;
            }else{
              $ret['IsSuccess'] = true;
              $ret['Msg'] = 'Succefully';
            }
        }
	}catch(Exception $e){
     $ret['IsSuccess'] = false;
     $ret['Msg'] = $e->getMessage();
  }
  return $ret;
}


exit();
?>