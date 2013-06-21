<?php

$hoursStart = (is_numeric($_GET["hoursStart"]))?$_GET["hoursStart"]:0;
$hoursEnd = (is_numeric($_GET["hoursEnd"]))?$_GET["hoursEnd"]:23;

$handle = $wpdb->get_results( "select palettes from ".$wpdb->prefix."dc_mv_configuration where id=1" , ARRAY_A);
$row = $handle[0];
$palettes = unserialize($row["palettes"]);
if (count($palettes) > $_GET["palette"])
    $palette = $palettes[$_GET["palette"]];
else
    $palette = $palettes[0];
  
function rquote_field($str)
{
    return $str;
}   
function getCalendarByRange($id){
  global $wpdb;  
  try{ 
    $sql = "select * from `".$wpdb->prefix."dc_mv_events` where `id` = " . $id;    
    $handle = $wpdb->get_results($sql, ARRAY_A);
    $row = $handle[0];
  }catch(Exception $e){
  } 
  return $row;
}
function fomartTimeAMPM($h,$m) {
    if ($_GET["mt"]!="false")
        $tmp = (($h < 10)  ? "0" : "") . $h . ":" . (($m < 10)?"0":"") . $m  ;
    else
    {
            $tmp = (($h%12) < 10) && $h!=12 ? "0" . ($h%12)  : ($h==12?"12":($h%12))  ;
            $tmp .= ":" . (($m < 10)?"0":"") . $m . (($h>=12)?"pm":"am");
    }
    return $tmp ;
}
if($_GET["id"]){
  $event = getCalendarByRange($_GET["id"]);  
}
$path = plugins_url('/', __FILE__)."../DC_MultiViewCal/";
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Calendar Details</title>
<?php 
if (file_exists(dirname( __FILE__ )."/../DC_MultiViewCal/css/".$_GET["css"]."/calendar.css"))
{ 
?> 
    <link type="text/css" href="<?php echo $path; ?>css/<?php echo $_GET["css"]?>/calendar.css" rel="stylesheet" />
<?php } else { ?>
    <link type="text/css" href="<?php echo $path; ?>css/cupertino/calendar.css" rel="stylesheet" />
<?php } ?>
    <script type='text/javascript' src='<?php echo $path.'../../../../wp-includes/js/jquery/jquery.js'; ?>'></script>
    <script type='text/javascript' src='<?php echo $path.'../../../../wp-includes/js/jquery/ui/jquery.ui.core.min.js'; ?>'></script>
    <script type='text/javascript' src='<?php echo $path.'../../../../wp-includes/js/jquery/ui/jquery.ui.widget.min.js'; ?>'></script>
    <script type='text/javascript' src='<?php echo $path.'../../../../wp-includes/js/jquery/ui/jquery.ui.button.min.js'; ?>'></script>
    <script type='text/javascript' src='<?php echo $path.'../../../../wp-includes/js/jquery/ui/jquery.ui.datepicker.min.js'; ?>'></script>
    <script src="<?php echo $path; ?>src/Plugins/Common.js" type="text/javascript"></script>
    <script src="<?php echo $path; ?>src/Plugins/Common.js" type="text/javascript"></script>
    <script src="<?php echo $path; ?>src/Plugins/Common.js" type="text/javascript"></script>
    <script src="<?php echo $path; ?>src/Plugins/Common.js" type="text/javascript"></script>
    <script src="<?php echo $path; ?>src/Plugins/jquery.form.js" type="text/javascript"></script>
        
    
    <script src="<?php
         if (file_exists(dirname( __FILE__ ).'/../DC_MultiViewCal/language/multiview_lang_'.WPLANG.'.js'))
            echo plugins_url('/DC_MultiViewCal/language/multiview_lang_'.WPLANG.'.js', dirname(__FILE__) );
        else
            echo plugins_url('/DC_MultiViewCal/language/multiview_lang_en_GB.js', dirname(__FILE__) );
    ?>" type="text/javascript"></script>    
    <script src="<?php echo $path; ?>src/Plugins/jquery.calendar.js" type="text/javascript"></script>
	<script src="<?php echo $path; ?>src/Plugins/jquery.validate.js" type="text/javascript"></script>
	<script src="<?php echo $path; ?>src/Plugins/jquery.colorselect.js" type="text/javascript"></script>
	<script src="<?php echo $path; ?>src/Plugins/jquery.dropdown.js" type="text/javascript"></script> 

    <link href="<?php echo $path; ?>css/main.css" rel="stylesheet" />
    <link href="<?php echo $path; ?>css/dropdown.css" rel="stylesheet" />
    <link href="<?php echo $path; ?>css/colorselect.css" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="<?php echo $path; ?>src/Plugins/jquery.cleditor.css" />
    <script type="text/javascript" src="<?php echo $path; ?>src/Plugins/jquery.cleditor.js"></script>
    <script type="text/javascript" src="<?php echo $path; ?>src/Plugins/repeat.js"></script>
    <script type="text/javascript">
        $ = jQuery.noConflict();
        var __WDAY = new Array(i18n.dcmvcal.dateformat.sun, i18n.dcmvcal.dateformat.mon, i18n.dcmvcal.dateformat.tue, i18n.dcmvcal.dateformat.wed, i18n.dcmvcal.dateformat.thu, i18n.dcmvcal.dateformat.fri, i18n.dcmvcal.dateformat.sat);
        var __WDAY2 = new Array(i18n.dcmvcal.dateformat.sun2, i18n.dcmvcal.dateformat.mon2, i18n.dcmvcal.dateformat.tue2, i18n.dcmvcal.dateformat.wed2, i18n.dcmvcal.dateformat.thu2, i18n.dcmvcal.dateformat.fri2, i18n.dcmvcal.dateformat.sat2);
        var __MonthName = new Array(i18n.dcmvcal.dateformat.jan, i18n.dcmvcal.dateformat.feb, i18n.dcmvcal.dateformat.mar, i18n.dcmvcal.dateformat.apr, i18n.dcmvcal.dateformat.may, i18n.dcmvcal.dateformat.jun, i18n.dcmvcal.dateformat.jul, i18n.dcmvcal.dateformat.aug, i18n.dcmvcal.dateformat.sep, i18n.dcmvcal.dateformat.oct, i18n.dcmvcal.dateformat.nov, i18n.dcmvcal.dateformat.dec);
        var __MonthNameLarge = new Array(i18n.dcmvcal.dateformat.l_jan, i18n.dcmvcal.dateformat.l_feb, i18n.dcmvcal.dateformat.l_mar, i18n.dcmvcal.dateformat.l_apr, i18n.dcmvcal.dateformat.l_may, i18n.dcmvcal.dateformat.l_jun, i18n.dcmvcal.dateformat.l_jul, i18n.dcmvcal.dateformat.l_aug, i18n.dcmvcal.dateformat.l_sep, i18n.dcmvcal.dateformat.l_oct, i18n.dcmvcal.dateformat.l_nov, i18n.dcmvcal.dateformat.l_dec);
        var __MilitaryTime = <?php echo  ($_GET["mt"]!="false")?"true":"false";?>

        if (!DateAdd || typeof (DateDiff) != "function") {
            var DateAdd = function(interval, number, idate) {
                number = parseInt(number);
                var date;
                if (typeof (idate) == "string") {
                    date = idate.split(/\D/);
                    eval("var date = new Date(" + date.join(",") + ")");
                }
                if (typeof (idate) == "object") {
                    date = new Date(idate.toString());
                }
                switch (interval) {
                    case "y": date.setFullYear(date.getFullYear() + number); break;
                    case "m": date.setMonth(date.getMonth() + number); break;
                    case "d": date.setDate(date.getDate() + number); break;
                    case "w": date.setDate(date.getDate() + 7 * number); break;
                    case "h": date.setHours(date.getHours() + number); break;
                    case "n": date.setMinutes(date.getMinutes() + number); break;
                    case "s": date.setSeconds(date.getSeconds() + number); break;
                    case "l": date.setMilliseconds(date.getMilliseconds() + number); break;
                }
                return date;
            }
        }
        function formatDateFromTo(value,y1_index,m1_index,d1_index,separator1,y2_index,m2_index,d2_index,separator2)
        {
            var arrs = value.split(separator1);
            var year = arrs[y1_index];
            var month = arrs[m1_index];
            var day = arrs[d1_index];

            var newArray = new Array();
            newArray[y2_index] = year;
            newArray[m2_index] = month;
            newArray[d2_index] = day;
            value = newArray.join(separator2);
            return value;
        }
        function getHM(date)
        {
             var hour =date.getHours();
             var minute= date.getMinutes();
             var ret= (hour>9?hour:"0"+hour)+":"+(minute>9?minute:"0"+minute) ;
             return ret;
        }
        $(document).ready(function() {
            //debugger;
            $("#Description").cleditor({width:450, height:150, useCSS:true})[0].focus();
            var DATA_FEED_URL = "<?php echo $this->get_site_url(); ?>/?cpmvc_id=<?php echo $this->calendar; ?>&cpmvc_do_action=mvparse&f=datafeed&calid=<?php echo $_GET["calid"]?>";
            var arrT = [];
            var tt = "{0}:{1}";
            for (var i = <?php echo $hoursStart?>; i <= <?php echo $hoursEnd?>; i++) {
                //arrT.push({ text: StrFormat(tt, [i >= 10 ? i : "0" + i, "00"]) }, { text: StrFormat(tt, [i >= 10 ? i : "0" + i, "30"]) });
                arrT.push({ text: fomartTimeAMPM(i,0,__MilitaryTime) }, {  text: fomartTimeAMPM(i,30,__MilitaryTime) });
            }

            $("#timezone").val(new Date().getTimezoneOffset()/60 * -1);
            $("#stparttime").dropdown({
                dropheight: 200,
                dropwidth:56,
                selectedchange: function() { },
                items: arrT
            });
            $("#etparttime").dropdown({
                dropheight: 200,
                dropwidth:56,
                selectedchange: function() { },
                items: arrT
            });
            var check = $("#IsAllDayEvent").click(function(e) {
                if (this.checked) {
                    $("#stparttime").val(fomartTimeAMPM(0,0,__MilitaryTime)).hide();
                    $("#etparttime").val(fomartTimeAMPM(0,0,__MilitaryTime)).hide();
                }
                else {
                    var d = new Date();
                    var p = 60 - d.getMinutes();
                    if (p > 30) p = p - 30;
                    d = DateAdd("n", p, d);
                    $("#stparttime").val(fomartTimeAMPM(d.getHours(),d.getMinutes(),__MilitaryTime)).show();
                    d = DateAdd("h", 1, d);
                    $("#etparttime").val(fomartTimeAMPM(d.getHours(),d.getMinutes(),__MilitaryTime)).show();
                }
            });
            if (check[0].checked) {
                $("#stparttime").val(fomartTimeAMPM(0,0,__MilitaryTime)).hide();
                $("#etparttime").val(fomartTimeAMPM(0,0,__MilitaryTime)).hide();
            }
            $( "#s_subject" ).html(i18n.dcmvcal.subject);
            $( "#s_time" ).html(i18n.dcmvcal.time);
            $( "#s_to" ).html(i18n.dcmvcal.to);
            $( "#s_all_day_event" ).html(i18n.dcmvcal.all_day_event);
            $( "#s_location" ).html(i18n.dcmvcal.location);
            $( "#s_remark" ).html(i18n.dcmvcal.remark);
            $("#savebtn,#closebtn,#deletebtn" ).button();
            $( "#savebtn" ).button( "option", "label", i18n.dcmvcal.i_save );
            $( "#closebtn" ).button( "option", "label", i18n.dcmvcal.i_close );
            $( "#deletebtn" ).button( "option", "label", i18n.dcmvcal.i_delete );
            $("#savebtn").click(function() { $("#fmEdit").submit(); });
            $("#closebtn").click(function() { window.parent.$jc('#editEvent').dialog('close'); });
            $("#deletebtn").click(function() {
                 if (confirm(i18n.dcmvcal.are_you_sure_delete)) {
                    var param = [{ "name": "calendarId", value: <?php echo isset($event)?$event["id"]:0; ?>}];
                    $.ajaxSetup({
                       jsonp: null,
                       jsonpCallback: null
                    });
                    $.post(DATA_FEED_URL + "&method=remove",
                        param,
                        function(data){
                              if (data.IsSuccess) {
                                    window.parent.$jc('#editEvent').dialog('close');
                                }
                                else
                                    alert(i18n.dcmvcal.error_occurs+ ".\r\n" + ((data.Msg=='OVERLAPPING')?i18n.dcmvcal.error_overlapping:data.Msg));
                        }
                    ,"json");
                }
            });

           //$("#stpartdate,#etpartdate").datepicker({ picker: "<button class='calpick'></button>",});
              var arrs = new Array
              arrs[i18n.dcmvcal.dateformat.year_index] = "yy";
              arrs[i18n.dcmvcal.dateformat.month_index] = "mm";
              arrs[i18n.dcmvcal.dateformat.day_index] = "dd";
              var dateFormat = arrs.join(i18n.dcmvcal.dateformat.separator);
              var dates = $( "#stpartdate, #etpartdate" ).datepicker({numberOfMonths: 1,
              dateFormat: dateFormat,
              monthNamesShort:__MonthName,
              monthNames:__MonthNameLarge,
              dayNamesShort:__WDAY,
              dayNamesMin:__WDAY2,
              firstDay: <?php echo (isset($_GET["weekstartday"]))?$_GET["weekstartday"]:1;?>,
			  changeMonth: true,
			  showOn: "button",
			  	 		//buttonImage: "<?php echo $path; ?>css/images/cal.gif",
			  onSelect: function( selectedDate ) {
			  	 var option = this.id == "stpartdate" ? "minDate" : "maxDate",
			  	 	instance = $( this ).data( "datepicker" ),
			  	 	date = $.datepicker.parseDate(
			  	 		instance.settings.dateFormat ||
			  	 		$.datepicker._defaults.dateFormat,
			  	 		selectedDate, instance.settings );
			  	 dates.not( this ).datepicker( "option", option, date );
			  }
		      });
            var cv =$("#colorvalue").val() ;
            if(cv=="")
            {
                cv="-1";
            }
            $("#calendarcolor").colorselect({ title: i18n.dcmvcal.color, index: cv, hiddenid: "colorvalue",colors:<?php echo json_encode($palette);?>,paletteDefault:"<?php echo $_GET["paletteDefault"];?>" });
            //to define parameters of ajaxform
            var options = {
                beforeSubmit: function() {
                    return true;
                },
                jsonp: null,
                jsonpCallback: null,

                dataType: "json",
                success: function(data) {
                    //alert(data.Msg);
                    if (data.IsSuccess) {
                        window.parent.$jc('#editEvent').dialog('close');
                    }
                    else
                        alert(i18n.dcmvcal.error_occurs+ ".\r\n" + ((data.Msg=='OVERLAPPING')?i18n.dcmvcal.error_overlapping:data.Msg));
                }
            };
            //alert(i18n)
            $.validator.addMethod("date", function(value, element) {
                var arrs = value.split(i18n.dcmvcal.dateformat.separator);
                var year = arrs[i18n.dcmvcal.dateformat.year_index];
                var month = arrs[i18n.dcmvcal.dateformat.month_index];
                var day = arrs[i18n.dcmvcal.dateformat.day_index];
                var standvalue = [year,month,day].join("-");

                var r = this.optional(element) || /^(?:(?:1[6-9]|[2-9]\d)?\d{2}[\/\-\.](?:0?[1,3-9]|1[0-2])[\/\-\.](?:29|30))(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?: \d{1,3})?)?$|^(?:(?:1[6-9]|[2-9]\d)?\d{2}[\/\-\.](?:0?[1,3,5,7,8]|1[02])[\/\-\.]31)(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?: \d{1,3})?)?$|^(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])[\/\-\.]0?2[\/\-\.]29)(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?: \d{1,3})?)?$|^(?:(?:16|[2468][048]|[3579][26])00[\/\-\.]0?2[\/\-\.]29)(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?: \d{1,3})?)?$|^(?:(?:1[6-9]|[2-9]\d)?\d{2}[\/\-\.](?:0?[1-9]|1[0-2])[\/\-\.](?:0?[1-9]|1\d|2[0-8]))(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?:\d{1,3})?)?$/.test(standvalue);
                if (r)
                {
                    $("#"+element.id+"last").val([month,day,year].join("/"));
                }
                return r;
            }, i18n.dcmvcal.invalid_date_format);
            $.validator.addMethod("time", function(value, element) {
                if (__MilitaryTime)
                    var r =  this.optional(element) || /^([0-1]?[0-9]|2[0-3]):([0-5][0-9])$/.test(value);
                else
                    var r =  this.optional(element) || /^(0[0-9]|1[0-2]):([0-5][0-9](am|pm))$/.test(value);
                if (r)
                {
                    if (__MilitaryTime)
                        $("#"+element.id+"last").val($("#"+element.id).val());
                    else
                    {
                        
                        var v = $("#"+element.id).val();
                        if (v.indexOf("am")!=-1)
                            v = v.replace("am","");
                        else
                        {
                            v = v.replace("pm","");
                            var d = v.split(":");
                            v = ((parseInt(d[0]*1)==12)?12:(parseInt(d[0]*1)+12))+":"+d[1];
                        }    
                        $("#"+element.id+"last").val(v);
                    }    
                }
                return r;    
            }, i18n.dcmvcal.invalid_time_format);
            $.validator.addMethod("safe", function(value, element) {
                return this.optional(element) || /^[^$\<\>]+$/.test(value);
            }, i18n.dcmvcal._simbol_not_allowed);
            $("#fmEdit").validate({
                submitHandler: function(form) {

                $("#fmEdit").ajaxSubmit(options);
                },
                errorElement: "div",
                errorClass: "cusErrorPanel",
                errorPlacement: function(error, element) {
                    showerror(error, element);
                }
            });
            function showerror(error, target) {
                var pos = target.position();
                var height = target.height();
                var newpos = { left: pos.left, top: pos.top + height + 2 }
                var form = $("#fmEdit");
                error.appendTo(form).css(newpos);
            }


        });
    </script>
    <style type="text/css">
    .ui-datepicker-trigger     {
        width:23px;
        height:23px;
        border:none;
        cursor:pointer;
        background:url("<?php echo $path; ?>css/images/cal.gif") no-repeat center center;
        margin-left:5px;
    }

    </style>
  </head>
  <body class="multicalendar calendaredition">
    <div class="infocontainer ui-widget-content" >
        <form action="<?php echo $this->get_site_url(); ?>/?cpmvc_id=<?php echo $this->calendar; ?>&cpmvc_do_action=mvparse&f=datafeed&calid=<?php echo $_GET["calid"];?>&month_index=<?php echo $_GET["month_index"];?>&method=adddetails<?php echo isset($event)?"&id=".$event["id"]:""; ?>" class="fform" id="fmEdit" method="post">
          <label>
            <span id="s_subject">*Subject:</span>
            <div id="calendarcolor">
            </div>
            <?php
            if (isset($dc_subjects) && is_array($dc_subjects))
            {
                echo '<select id="Subject" name="Subject" class="required safe inputtext" >';
                for ($i=0;$i<count($dc_subjects);$i++)
                {
                    echo '<option value="'.rquote_field($dc_subjects[$i]).'" '.((isset($event) && ($event["title"]==$dc_subjects[$i]))?"selected":"").'>'.$dc_subjects[$i].'</option>';
                }
                echo '</select>';
            }
            else
                echo '<input MaxLength="200" class="required safe inputtext" id="Subject" name="Subject" type="text" value="'.(isset($event)?rquote_field($event["title"]):"").'" />';
               
            ?>
            <input id="colorvalue" name="colorvalue" type="hidden" value="<?php echo isset($event)?$event["color"]:"" ?>" />
          </label>
          <label>
            <span id="s_time">*Time:</span>
            <div>
              <?php if(isset($event)){
                  $sarr = explode(" ", php2JsTime(mySql2PhpTime($event["starttime"])));
                  $earr = explode(" ", php2JsTime(mySql2PhpTime($event["endtime"])));
                  $shm = explode(":", $sarr[1]);
                  $ehm = explode(":", $earr[1]);
                  $stpartdate = $sarr[0];
                  $stparttime = fomartTimeAMPM(intval($shm[0]),intval($shm[1]));
                  $etpartdate = $earr[0];
                  $etparttime = fomartTimeAMPM(intval($ehm[0]),intval($ehm[1]));
              }
              else if ($_GET["start"]!="" && $_GET["end"]!="")
              {
                  $sarr = explode(" ", $_GET["start"]);
                  $earr = explode(" ", $_GET["end"]);
                  $shm = explode(":", $sarr[1]);
                  $ehm = explode(":", $earr[1]);
                  $stpartdate = $sarr[0];
                  $stparttime = fomartTimeAMPM(intval($shm[0]),intval($shm[1]));
                  $etpartdate = $earr[0];
                  $etparttime = fomartTimeAMPM(intval($ehm[0]),intval($ehm[1]));
              }
              else
              {
                   $stpartdate = "";
                   $stparttime = "";
                   $etpartdate = "";
                   $etparttime = "";
              }
              if ($_GET["month_index"]=="1" && $stpartdate!="" && $etpartdate!="")
              {
                  $sarr = explode("/", $stpartdate);
                  $stpartdate = $sarr[1]."/".$sarr[0]."/".$sarr[2];
                  $earr = explode("/", $etpartdate);
                  $etpartdate = $earr[1]."/".$earr[0]."/".$earr[2];
              }
              ?>
              <input MaxLength="10" class="required date" id="stpartdate" name="stpartdate" type="text" value="<?php echo $stpartdate; ?>" />
              <input MaxLength="7" class="required time" id="stparttime" name="stparttime" style="width:52px;" type="text" value="<?php echo $stparttime; ?>" /><span id="s_to" class="inl">To</span>
              <input MaxLength="10" class="required date" id="etpartdate" name="etpartdate" type="text" value="<?php echo $etpartdate; ?>" />
              <input MaxLength="7" class="required time" id="etparttime" name="etparttime" style="width:52px;" type="text" value="<?php echo $etparttime; ?>" />
              <input MaxLength="10" id="stpartdatelast" name="stpartdatelast" type="hidden" value="" />
              <input MaxLength="10" id="etpartdatelast" name="etpartdatelast" type="hidden" value="" />
              <input MaxLength="10" id="stparttimelast" name="stparttimelast" type="hidden" value="" />
              <input MaxLength="10" id="etparttimelast" name="etparttimelast" type="hidden" value="" />
              <label class="checkp">
                <input id="IsAllDayEvent" name="IsAllDayEvent" type="checkbox" value="1" <?php if(isset($event)&&$event["isalldayevent"]!=0 || $_GET["isallday"]=="1") {echo "checked";} ?>/><span id="s_all_day_event" class="inl">All Day Event</span>
              </label>
            </div>
          </label>
          <label>
            <span id="s_location">Location:</span>
            <?php
            if (isset($dc_locations) && is_array($dc_locations))
            {
                echo '<select id="Location" name="Location" class="required safe inputtext" >';
                for ($i=0;$i<count($dc_locations);$i++)
                {
                    echo '<option value="'.($dc_locations[$i]).'" '.((isset($event) && ($event["location"] ==$dc_locations[$i]))?"selected":"").'>'.$dc_locations[$i].'</option>';
                }
                echo '</select>';
            }
            else
                echo '<input MaxLength="200" id="Location" name="Location" class="inputtext"  type="text" value="'.((isset($event))?$event["location"]:"").'" />';
            ?>

          </label>
          <label>
            <span id="s_remark">Remark:</span>
<textarea cols="20" id="Description" name="Description" rows="2" >
<?php echo isset($event)?$event["description"]:""; ?>
</textarea>
          </label>
          <input id="timezone" name="timezone" type="hidden" value="" />
          <br />
          <a href="#" id="savebtn">Save</a>
          <?php if(isset($event) && ($_GET["delete"]=="1")){ ?>
        <a href="#" id="deletebtn">Delete</a>
        <?php } ?>
          <a href="#" id="closebtn">Close</a>
           <br />
        </form>
    </div>
  </body>
</html>
<?php
exit();
?> 