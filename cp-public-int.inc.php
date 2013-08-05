<?php

if ( !$this ) 
{
    echo 'Direct access not allowed.';
    exit;
}

global $wpdb;

//print_r($atts);

//$myrows = $wpdb->get_results( "SELECT * FROM ".DEX_APPOINTMENTS_CONFIG_TABLE_NAME." WHERE published=1" );                                                                     

?>
<link href="<?php echo plugins_url('/DC_MultiViewCal/css/'.$atts["cssstyle"].'/calendar.css', __FILE__); ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo plugins_url('/DC_MultiViewCal/css/main.css', __FILE__); ?>" type="text/css" rel="stylesheet" />
<noscript>The CP Multi View Event Calendar requires JavaScript enabled</noscript>
 <div style="z-index:1000;">
    <div id="cal1" class="multicalendar"></div>
 </div>        
 <div style="clear:both;"></div> 

