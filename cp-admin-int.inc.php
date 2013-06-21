<?php

if ( !is_admin() ) 
{
    echo 'Direct access not allowed.';
    exit;
}

$mycalendarrows = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'dc_mv_calendars WHERE id='.$this->calendar); 

?>
<div class="wrap">
<h2><?php echo $this->plugin_name; ?> - Manage Data and Settings</h2>

<input type="button" name="backbtn" value="Back to items list..." onclick="document.location='options-general.php?page=<?php echo $this->menu_parameter; ?>';">

<form method="post" action="" name="cpformconf"> 
<input name="cpmvc_do_action" type="hidden" id="save_settings" />
<input name="cpmvc_id" type="hidden" value="<?php echo $this->calendar; ?>" />


   
<div id="normal-sortables" class="meta-box-sortables">

 <hr />
 <h3>These settings apply only to: <?php echo $mycalendarrows[0]->title; ?></h3>

 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>Calendar Configuration / Administration</span></h3>
  <div class="inside">
  
  <link rel="stylesheet" href="<?php echo plugins_url('DC_MultiViewCal/css/cupertino/calendar.css', __FILE__); ?>" type="text/css" />
  <link rel="stylesheet" href="<?php echo plugins_url('DC_MultiViewCal/css/main.css', __FILE__); ?>" type="text/css" /> 
  
  <script type="text/javascript" src="<?php echo plugins_url('DC_MultiViewCal/src/Plugins/underscore.js', __FILE__); ?>"></script>
  <script type="text/javascript" src="<?php echo plugins_url('DC_MultiViewCal/src/Plugins/rrule.js', __FILE__); ?>"></script>
  <script type="text/javascript" src="<?php echo plugins_url('DC_MultiViewCal/src/Plugins/Common.js', __FILE__); ?>"></script>
  <script type="text/javascript" src="<?php echo plugins_url('DC_MultiViewCal/language/multiview_lang_en_GB.js', __FILE__); ?>"></script>
  <script type="text/javascript" src="<?php echo plugins_url('DC_MultiViewCal/src/Plugins/jquery.calendar.js', __FILE__); ?>"></script>
  <script type="text/javascript" src="<?php echo plugins_url('DC_MultiViewCal/src/Plugins/jquery.alert.js', __FILE__); ?>"></script>
  <script type="text/javascript" src="<?php echo plugins_url('DC_MultiViewCal/src/Plugins/multiview.js', __FILE__); ?>"></script>
  <script type="text/javascript">
   var pathCalendar = "<?php echo $this->get_site_url(); ?>/?cpmvc_id=<?php echo $this->calendar; ?>&cpmvc_do_action=mvparse";
   dc_subjects = "";dc_locations = "";
   initMultiViewCal("cal<?php echo $this->calendar; ?>", <?php echo $this->calendar; ?>,
            {viewDay:true,
            viewWeek:true,
            viewMonth:true,
            viewNMonth:true,
            viewdefault:"nMonth",
            numberOfMonths:12,
            showtooltip:false,
            tooltipon:1,
            shownavigate:false,
            url:"",
            target:0,
            start_weekday:0,
            language:"en-GB",
            cssStyle:"cupertino",
            edition:true,
            btoday:true,
            bnavigation:true,
            brefresh:true,
            bnew:true,
            path:pathCalendar,
            userAdd:true,
            userEdit:true,
            userDel:true,
            userEditOwner:true,
            userDelOwner:true,
            userOwner:-1 , palette:0, paletteDefault:"F00"});
  </script>

  <div id="cal<?php echo $this->calendar; ?>" class="multicalendar"></div>
  
   <div style="clear:both;height:20px" ></div>      
   
  </div>    
 </div> 
 



<!--<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="Save Changes"  /></p>-->


[<a href="http://wordpress.dwbooster.com/contact-us" target="_blank">Request Custom Modifications</a>] | [<a href="<?php echo $this->plugin_URL; ?>" target="_blank">Help</a>]
</form>
</div>














