<?php

class CP_MultiViewCalendar extends CP_BaseClass {

    private $calendar = 1;
    private $menu_parameter = 'cp_multiview';
    private $prefix = 'cp_multiview';
    private $plugin_name = 'CP Multi View Calendar';
    private $plugin_URL = 'http://wordpress.dwbooster.com/calendars/cp-multi-view-calendar';
    private $print_counter = 0;

    public $shorttag = 'CPMV_CALENDAR';

    function _install() {
        global $wpdb;
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        $sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."dc_mv_calendars (
          id int(11) unsigned NOT NULL AUTO_INCREMENT,
          title text,
          permissions text,
          owner int(11) default '0',
          ordering int(11) NOT NULL default '0',
          published tinyint(1) NOT NULL default '0',
          checked_out int(11) NOT NULL default '0',
          checked_out_time datetime NOT NULL default '0000-00-00 00:00:00',
          PRIMARY KEY  (id)
        );
        ";
        $wpdb->query($sql);

        $sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."dc_mv_events (
          id int(10) unsigned NOT NULL AUTO_INCREMENT,
          calid int(10) unsigned DEFAULT NULL,
          starttime datetime DEFAULT NULL,
          endtime datetime DEFAULT NULL,
          title varchar(250) DEFAULT NULL,
          location varchar(250) DEFAULT NULL,
          rrule varchar(255) DEFAULT NULL,
          exdate text,
          uid int(11),
          description text,
          isalldayevent tinyint(3) unsigned DEFAULT NULL,
          color varchar(10) DEFAULT NULL,
          owner int(11),
          published tinyint(1),
          PRIMARY KEY  (id)
        );
        ";
        $wpdb->query($sql);

        $sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."dc_mv_configuration (
          id int(10) unsigned NOT NULL AUTO_INCREMENT,
          palettes text,
          administration text,
          PRIMARY KEY  (id)
        );
        ";
        $wpdb->query($sql);

        // insert initial data
        $count = $wpdb->get_var( "SELECT COUNT(id) FROM ".$wpdb->prefix."dc_mv_calendars" );
        if (!$count)
            $wpdb->query("INSERT INTO ".$wpdb->prefix."dc_mv_calendars (id,title,published) VALUES (1,'Calendar 1',1);");
        $count = $wpdb->get_var( "SELECT COUNT(id) FROM ".$wpdb->prefix."dc_mv_configuration" );
        if (!$count)
            $wpdb->query("INSERT INTO ".$wpdb->prefix."dc_mv_configuration (id,palettes,administration) VALUES (1,'a:2:{i:0;a:3:{s:4:\"name\";s:7:\"Default\";s:6:\"colors\";a:70:{i:0;s:3:\"FFF\";i:1;s:3:\"FCC\";i:2;s:3:\"FC9\";i:3;s:3:\"FF9\";i:4;s:3:\"FFC\";i:5;s:3:\"9F9\";i:6;s:3:\"9FF\";i:7;s:3:\"CFF\";i:8;s:3:\"CCF\";i:9;s:3:\"FCF\";i:10;s:3:\"CCC\";i:11;s:3:\"F66\";i:12;s:3:\"F96\";i:13;s:3:\"FF6\";i:14;s:3:\"FF3\";i:15;s:3:\"6F9\";i:16;s:3:\"3FF\";i:17;s:3:\"6FF\";i:18;s:3:\"99F\";i:19;s:3:\"F9F\";i:20;s:3:\"BBB\";i:21;s:3:\"F00\";i:22;s:3:\"F90\";i:23;s:3:\"FC6\";i:24;s:3:\"FF0\";i:25;s:3:\"3F3\";i:26;s:3:\"6CC\";i:27;s:3:\"3CF\";i:28;s:3:\"66C\";i:29;s:3:\"C6C\";i:30;s:3:\"999\";i:31;s:3:\"C00\";i:32;s:3:\"F60\";i:33;s:3:\"FC3\";i:34;s:3:\"FC0\";i:35;s:3:\"3C0\";i:36;s:3:\"0CC\";i:37;s:3:\"36F\";i:38;s:3:\"63F\";i:39;s:3:\"C3C\";i:40;s:3:\"666\";i:41;s:3:\"900\";i:42;s:3:\"C60\";i:43;s:3:\"C93\";i:44;s:3:\"990\";i:45;s:3:\"090\";i:46;s:3:\"399\";i:47;s:3:\"33F\";i:48;s:3:\"60C\";i:49;s:3:\"939\";i:50;s:3:\"333\";i:51;s:3:\"600\";i:52;s:3:\"930\";i:53;s:3:\"963\";i:54;s:3:\"660\";i:55;s:3:\"060\";i:56;s:3:\"366\";i:57;s:3:\"009\";i:58;s:3:\"339\";i:59;s:3:\"636\";i:60;s:3:\"000\";i:61;s:3:\"300\";i:62;s:3:\"630\";i:63;s:3:\"633\";i:64;s:3:\"330\";i:65;s:3:\"030\";i:66;s:3:\"033\";i:67;s:3:\"006\";i:68;s:3:\"309\";i:69;s:3:\"303\";}s:7:\"default\";s:3:\"F00\";}i:1;a:3:{s:4:\"name\";s:9:\"Semaphore\";s:6:\"colors\";a:3:{i:0;s:3:\"F00\";i:1;s:3:\"FF3\";i:2;s:3:\"3C0\";}s:7:\"default\";s:3:\"3C0\";}}','a:15:{s:5:\"views\";a:4:{i:0;s:7:\"viewDay\";i:1;s:8:\"viewWeek\";i:2;s:9:\"viewMonth\";i:3;s:10:\"viewNMonth\";}s:11:\"viewdefault\";s:5:\"month\";s:8:\"language\";s:5:\"en-GB\";s:13:\"start_weekday\";s:1:\"0\";s:8:\"cssStyle\";s:9:\"cupertino\";s:12:\"paletteColor\";s:1:\"0\";s:6:\"btoday\";s:1:\"1\";s:11:\"bnavigation\";s:1:\"1\";s:8:\"brefresh\";s:1:\"1\";s:14:\"numberOfMonths\";s:2:\"12\";s:7:\"sample0\";N;s:7:\"sample1\";s:5:\"click\";s:7:\"sample2\";N;s:7:\"sample3\";s:0:\"\";s:7:\"sample4\";s:10:\"new_window\";}');");
    }


    /* Filter for placing the maps into the contents */
    public function filter_content($atts) {
        global $wpdb;
        extract( shortcode_atts( array(
    		                           'calendar' => '',
    	                        ), $atts ) );
        if ($calendar != '')
            $this->calendar = 1;
        ob_start();
        $this->insert_public_item($atts);
        $buffered_contents = ob_get_contents();
        ob_end_clean();
        return $buffered_contents;
    }


    function insert_public_item($atts) {        
        
        wp_register_script('cpmvc-common', plugins_url('/DC_MultiViewCal/src/Plugins/Common.js', __FILE__));
        wp_register_script('cpmvc-underscore', plugins_url('/DC_MultiViewCal/src/Plugins/underscore.js', __FILE__));
        wp_register_script('cpmvc-rrule', plugins_url('/DC_MultiViewCal/src/Plugins/rrule.js', __FILE__));
        
                
        if (file_exists(dirname( __FILE__ ).'/DC_MultiViewCal/language/multiview_lang_'.WPLANG.'.js'))
            wp_register_script('cpmvc-lang', plugins_url('/DC_MultiViewCal/language/multiview_lang_'.WPLANG.'.js', __FILE__));
        else
            wp_register_script('cpmvc-lang', plugins_url('/DC_MultiViewCal/language/multiview_lang_en_GB.js', __FILE__));
        
        wp_register_script('cpmvc-jqcalendar', plugins_url('/DC_MultiViewCal/src/Plugins/jquery.calendar.js', __FILE__));
        wp_register_script('cpmvc-jqalert', plugins_url('/DC_MultiViewCal/src/Plugins/jquery.alert.js', __FILE__));        
        wp_register_script('cpmvc-multiview', plugins_url('/DC_MultiViewCal/src/Plugins/multiview.js', __FILE__));        
        
        wp_enqueue_script( 'cpmvc-publicjs', plugins_url('/DC_MultiViewCal/src/Plugins/multiview.public.js', __FILE__),
                           array("jquery","jquery-ui-core", "jquery-ui-dialog", "jquery-ui-datepicker",'cpmvc-common','cpmvc-underscore','cpmvc-rrule','cpmvc-lang','cpmvc-jqcalendar','cpmvc-jqalert','cpmvc-multiview'), 
                           false, true);

        $convert_arr = array(
             'viewday'        =>  'viewDay',
             'viewweek'       =>  'viewWeek',
             'viewmonth'      =>  'viewMonth',
             'viewnmonth'     =>  'viewNMonth',
             'numberofmonths' =>  'numberOfMonths',
             'cssstyle'       =>  'cssStyle',
             'militarytime'   =>  'militaryTime',
             'useradd'        =>  'userAdd',
             'useredit'       =>  'userEdit',
             'userdel'        =>  'userDel',
             'usereditowner'  =>  'userEditOwner',
             'userdelowner'   =>  'userDelOwner',
             'userowner'      =>  'userOwner',
             'palettedefault' =>  'paletteDefault'
         );  

         
        $params = "";                   
        foreach ($atts as $item => $value)
        {
            if (isset($convert_arr[$item]))
                $item = $convert_arr[$item];
            $item = str_replace(array('"', "'"),array('\\"', "\\'"),$item);
            if (is_numeric($value) || $value == 'true' || $value == 'false')
                $params .= ',"'.$item.'":'.$value;
            else
                $params .= ',"'.$item.'":"'.str_replace(array('"', "'"),array('\\"', "\\'"),$value).'"';
        }        
        $params = '{'.substr($params,1).'}';
        
        wp_localize_script('cpmvc-publicjs', 'cpmvc_configmultiview'.($this->print_counter++), array('obj'  	=>
              '{"params":'.$params.',
               "ajax_url":"'.str_replace(array('"', "'"),array('\\"', "\\'"),$this->get_site_url()).'/?cpmvc_id='.$atts["id"].'&cpmvc_do_action=mvparse",
               "calendar":"'.str_replace(array('"', "'"),array('\\"', "\\'"),$atts["id"]).'"
    	         }'
           ));
        
        @include dirname( __FILE__ ) . '/cp-public-int.inc.php';
    }


    /* Code for the admin area */

    public function plugin_page_links($links) {
        $customAdjustments_link = '<a href="http://wordpress.dwbooster.com/contact-us">'.__('Request custom changes').'</a>';
    	array_unshift($links, $customAdjustments_link);
        $settings_link = '<a href="options-general.php?page='.$this->menu_parameter.'">'.__('Settings').'</a>';
    	array_unshift($links, $settings_link);
    	$help_link = '<a href="'.$this->plugin_URL.'">'.__('Help').'</a>';
    	array_unshift($links, $help_link);
    	return $links;
    }

    public function admin_menu() {
        add_options_page($this->plugin_name.' Options', $this->plugin_name, 'manage_options', $this->menu_parameter, array($this, 'settings_page') );
        add_menu_page( $this->plugin_name.' Options', $this->plugin_name, 'edit_pages', $this->menu_parameter, array($this, 'settings_page') );

        add_meta_box($this->prefix.'box', $this->plugin_name, array($this, 'insertMetaBox'), 'post', 'normal');
        add_meta_box($this->prefix.'box', $this->plugin_name, array($this, 'insertMetaBox'), 'page', 'normal');
    }

    public function insertMetaBox() {
        global $wpdb;
        @include_once dirname( __FILE__ ) . '/cp-metabox.inc.php';
    }


    public function settings_page() {
        global $wpdb;
        if ($this->get_param("cpmvc_id"))
        {
            $this->calendar = 1;
            @include_once dirname( __FILE__ ) . '/cp-admin-int.inc.php';
        }
        else
            @include_once dirname( __FILE__ ) . '/cp-admin-int-list.inc.php';
    }

    function insert_adminScripts($hook) {
        if ($this->get_param("page") == $this->menu_parameter)
        {
            wp_enqueue_script( "jquery" );
            wp_enqueue_script( "jquery-ui-core" );
            wp_enqueue_script( "jquery-ui-dialog" );
            wp_enqueue_script( "jquery-ui-datepicker" );
            //wp_enqueue_script( "jquery-ui-sortable" );
            //wp_enqueue_script( "jquery-ui-tabs" );
            //wp_enqueue_script( "jquery-ui-droppable" );
            //wp_enqueue_script( "jquery-ui-button" );
        }
    }

    /* hook for checking posted data for the admin area */

    function data_management() {
        global $wpdb;
        $action = $this->get_param('cpmvc_do_action');
    	if (!$action) return; // go out if the call isn't for this one

        if ($this->get_param('cpmvc_id')) $this->calendar = 1;

        if ($action == "mvparse")
        {
            $feed = $this->get_param('f');
            if ($feed == 'datafeed')
            {
                @include_once dirname( __FILE__ ) . '/php/functions.php';
                @include_once dirname( __FILE__ ) . '/php/datafeed.php';
                exit();
            }
            else if ($feed == 'edit')
            {
                 @include_once dirname( __FILE__ ) . '/php/functions.php';
                 @include_once dirname( __FILE__ ) . '/php/edit.php';
                 exit();
            }
        }
        //header("Cache-Control: no-store, no-cache, must-revalidate");
        //header("Pragma: no-cache");

        // ...
        echo 'Some unexpected error happened. If you see this error contact the support service at http://wordpress.dwbooster.com/contact-us';

        exit();
    }

} // end class

?>