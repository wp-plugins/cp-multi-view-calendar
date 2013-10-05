<?php if ( !is_admin() ) {echo 'Direct access not allowed.';exit;} ?>

<input type="hidden" name="r<?php echo $this->prefix; ?>isediting" id="r<?php echo $this->prefix; ?>isediting" value="0" />
<table class="form-table" id="<?php echo $this->prefix; ?>createbox" style="display:none">
    <tr valign="top">
        <th scope="row"><label>MultiCalendar</label></th>
        <td><select id="<?php echo $this->prefix; ?>_id" name="<?php echo $this->prefix; ?>[calid]" class="required">            	
            	<?php                  
                  $myrows = $wpdb->get_results( "SELECT * FROM ". $wpdb->prefix."dc_mv_calendars");                                                                       
                  foreach ($myrows as $item)   
                      echo '<option value="'.$item->id.'">'.$item->title.'</option>';
            	?>
            </select>
        </td>
    </tr>    
    <tr valign="top">
        <th scope="row"><label>Calendar Views</label></th>					
        <td>
          <input type="checkbox" id="<?php echo $this->prefix; ?>_viewDay" name="<?php echo $this->prefix; ?>[viewDay]" value="true" checked="checked"/><label>Day</label>
          <input type="checkbox" id="<?php echo $this->prefix; ?>_viewWeek" name="<?php echo $this->prefix; ?>[viewWeek]" value="true" checked="checked"/><label>Week</label>
          <input type="checkbox" id="<?php echo $this->prefix; ?>_viewMonth" name="<?php echo $this->prefix; ?>[viewMonth]" value="true" checked="checked"/><label>Month</label>
          <input type="checkbox" id="<?php echo $this->prefix; ?>_viewNMonth" name="<?php echo $this->prefix; ?>[viewNMonth]" value="true" checked="checked"/><label>nMonth</label>
        </td>
    </tr>    
    <tr valign="top">
        <th scope="row"><label>Default View</label></th>
        <td><select id="<?php echo $this->prefix; ?>_viewdefault" name="<?php echo $this->prefix; ?>[viewdefault]">
            	<option value="day">Day</option>
            	<option value="week">Week</option>
            	<option value="month" selected="selected">Month</option>
            	<option value="nMonth">nMonth</option>
            </select>
        </td>    
    </tr>    
    <tr valign="top">
        <th scope="row"><label>Start day of the week</label></th>
        <td><select id="<?php echo $this->prefix; ?>_start_weekday" name="<?php echo $this->prefix; ?>[start_weekday]">
            	<option value="0" selected="selected">Sunday</option>
            	<option value="1">Monday</option>
            	<option value="2">Tuesday</option>
            	<option value="3">Wednesday</option>
            	<option value="4">Thursday</option>
            	<option value="5">Friday</option>
            	<option value="6">Saturday</option>
            </select>
        </td>
    </tr>    
    <tr valign="top">
        <th scope="row"><label>Css Style</label></th>
        <td><select id="<?php echo $this->prefix; ?>_cssStyle" name="<?php echo $this->prefix; ?>[cssStyle]">
            	<option value="cupertino" selected="selected">Cupertino</option>
            </select>
            <br />
            * Pro version has other additional 22 styles. <a href="http://wordpress.dwbooster.com/calendars/cp-multi-view-calendar">Click here to see all available styles</a>.
        </td>
    </tr>    
    <tr valign="top">
        <th scope="row"><label>Palette Color</label></th>
        <td><select id="<?php echo $this->prefix; ?>_palette" name="<?php echo $this->prefix; ?>[palette]" class="required">
            	<option value="0">Default</option>
            	<option value="1">Semaphore</option>
            </select>
        </td>
    </tr>    
    <tr valign="top">
        <th scope="row"><label>Allow edition</label></th>
        <td><input type="checkbox" id="<?php echo $this->prefix; ?>_edition"  name="<?php echo $this->prefix; ?>[edition]" value="true"/>
        </td>
    </tr>    
    <tr valign="top">
        <th scope="row"><label>Other buttons</label></th>
        <td> 
          <input type="checkbox" id="<?php echo $this->prefix; ?>_btoday" name="<?php echo $this->prefix; ?>[btoday]" value="true"/><label>Show Today Button</label>
          <input type="checkbox" id="<?php echo $this->prefix; ?>_bnavigation" name="<?php echo $this->prefix; ?>[bnavigation]" value="true" checked="checked"/><label>Show Navigation Buttons</label>
          <input type="checkbox" id="<?php echo $this->prefix; ?>_brefresh" name="<?php echo $this->prefix; ?>[brefresh]" value="true"/><label>Show Refresh Button</label>
        </td>  
    </tr>    
    <tr valign="top">
        <th scope="row"><label>Number of Months for nMonths View</label></th>
        <td><select id="<?php echo $this->prefix; ?>_numberOfMonths" name="<?php echo $this->prefix; ?>[numberOfMonths]">
            	<option value="1">1</option>
            	<option value="2">2</option>
            	<option value="3">3</option>
            	<option value="4">4</option>
            	<option value="5">5</option>
            	<option value="6" selected="selected">6</option>
            	<option value="7">7</option>
            	<option value="8">8</option>
            	<option value="9">9</option>
            	<option value="10">10</option>
            	<option value="11">11</option>
            	<option value="12">12</option>
            	<option value="13">13</option>
            	<option value="14">14</option>
            	<option value="15">15</option>
            	<option value="16">16</option>
            	<option value="17">17</option>
            	<option value="18">18</option>
            	<option value="19">19</option>
            	<option value="20">20</option>
            	<option value="21">21</option>
            	<option value="22">22</option>
            	<option value="23">23</option>
            	<option value="24">24</option>
            </select>
        </td>    
    </tr>    
    <tr valign="top">
        <th scope="row"><label>Other parameters for nMonths View</label></th>
        <td>
          <script>function showhide(id){var obj1 = document.getElementById("<?php echo $this->prefix; ?>_showtooltip");var obj2 = document.getElementById("<?php echo $this->prefix; ?>_tooltipon");var obj3 = document.getElementById(id+"div");if ((obj1.checked) && (obj2.selectedIndex==1))    obj3.style.display = "none";else        obj3.style.display = "";}</script>
          <div>
            <input type="checkbox" id="<?php echo $this->prefix; ?>_showtooltip" name="<?php echo $this->prefix; ?>[showtooltip]" value="true"  onclick="javascript:showhide('mvparams')"/><span>Show tooltip on</span>
            <select id="<?php echo $this->prefix; ?>_tooltipon" name="<?php echo $this->prefix; ?>[tooltipon]" onchange="javascript:showhide('mvparams')"><option value="0"  >mouse over</option><option value="1" >click</option></select>
          </div>
          <label id="mvparams-lbl" class="hasTip">&nbsp;</label>
          <div id="mvparamsdiv">
            <input type="checkbox" id="<?php echo $this->prefix; ?>_shownavigate" name="<?php echo $this->prefix; ?>[shownavigate]" value="true" />
            <span>Go to the url</span>
            <input type="text" id="<?php echo $this->prefix; ?>_url" name="<?php echo $this->prefix; ?>[url]" value=""/><label id="mvparams-lbl" class="hasTip">&nbsp;</label>
            <span>in</span>
            <select id="<?php echo $this->prefix; ?>_target" name="<?php echo $this->prefix; ?>[target]"><option value="0"  >new window</option><option value="1" >same window</option></select>
          </div>
          <script>showhide('mvparams')</script>
        </td>
    </tr>    
   <tr valign="top">
        <th scope="row"><label>Other parameters</label></th>
        <td>		
          <textarea name="<?php echo $this->prefix; ?>[otherparams]" id="<?php echo $this->prefix; ?>_otherparams" cols="40" rows="3"></textarea>		
        </td>  
    </tr>
    <tr>
        <td></td>
        <td align="left">
            <input type="button" onclick="return <?php echo $this->prefix; ?>saveCloseCalendar(this.form);" value="<?php _e('Save Calendar'); ?>" />
            <input type="button" onclick="return <?php echo $this->prefix; ?>previewCalendar(this.form);" value="<?php _e('Save & Preview'); ?>" />
            &nbsp; <input type="button" onclick="return <?php echo $this->prefix; ?>showCalendarArea();" value="<?php _e('Cancel'); ?>" />
        </td>
    </tr>    
</table>

<div id="<?php echo $this->prefix; ?>calendarsarea">
  <div id="<?php echo $this->prefix; ?>calendarslistarea"></div>  
  <br />
  <input type="button" onclick="return <?php echo $this->prefix; ?>createNewCalendar(0);" value="<?php _e('Create New Calendar View'); ?>" />  
  <!--<input type="button" onclick="return <?php echo $this->prefix; ?>Admin.sendToEditor(this.form);" value="<?php _e('Send Calendar to Editor &raquo;'); ?>" />-->
</div>
 
  
<div id="dialog" title="Calendar Preview" style="display:none">
    <iframe frameborder="0" height="99%" width="99%" src="" id="<?php echo $this->prefix; ?>previewcalendarframe" name="<?php echo $this->prefix; ?>previewcalendarframe"></iframe>
</div>

<script type="text/javascript">  
    /** Populate functions */
    function <?php echo $this->prefix; ?>_sel_sel(id,value)
    {
         var fld = document.getElementById("<?php echo $this->prefix; ?>_"+id);
         for ( var i = 0; i < fld.options.length; i++ ) 
         if ( fld.options[i].value == value ) {
             fld.options[i].selected = true;
             return;
         }
    }
    function <?php echo $this->prefix; ?>_sel_chk(id,value)
    {
        if (value == 'true')
            document.getElementById("<?php echo $this->prefix; ?>_"+id).checked = true;
        else    
            document.getElementById("<?php echo $this->prefix; ?>_"+id).checked = false;
    }
    function <?php echo $this->prefix; ?>_sel_fld(id,value)
    {
        document.getElementById("<?php echo $this->prefix; ?>_"+id).value = value;
    }
    /** Display add new calendar view */
    function <?php echo $this->prefix; ?>createNewCalendar(id)
    {        
        document.getElementById("r<?php echo $this->prefix; ?>isediting").value = id;
        document.getElementById("<?php echo $this->prefix; ?>createbox").style.display = "";
        document.getElementById("<?php echo $this->prefix; ?>calendarsarea").style.display = "none";
    }
    /** Display calendar views */
    function <?php echo $this->prefix; ?>showCalendarArea()
    {
        document.getElementById("<?php echo $this->prefix; ?>createbox").style.display = "none";
        document.getElementById("<?php echo $this->prefix; ?>calendarsarea").style.display = "";
    }    
    /** Ajax call add/update new calendar view */
    function <?php echo $this->prefix; ?>saveCalendar(form)
    {
        var code = <?php echo $this->prefix; ?>Admin.getCode(form);        
        var $j = jQuery.noConflict();
        var data = {
            action: '<?php echo $this->prefix; ?>add_calendar',
            security: '<?php echo $this->ajax_nonce; ?>',
            viewid: form.r<?php echo $this->prefix; ?>isediting.value,
	  	    params: code
	  	    // falta mandar parametro ID para caso de update
     	};
     	$j("#<?php echo $this->prefix; ?>calendarslistarea")[0].innerHTML = '<?php _e("Loading..."); ?>';
     	$j.ajax({
                type: 'POST',
                url: ajaxurl,
                data: data,
                success: function(response) {            
                              try {
		                          $j("#<?php echo $this->prefix; ?>calendarslistarea")[0].innerHTML = response;		  
                                  var head = document.getElementsByTagName("head")[0];
                                  var sTag = document.createElement("script");
                                  sTag.type = "text/javascript";
                                  sTag.text = $j("#<?php echo $this->prefix; ?>scriptsarea")[0].innerHTML;
                                  head.appendChild(sTag);	    
                              } catch (err) {}    
	                      },
                async:false
              });
	}    
	function <?php echo $this->prefix; ?>saveCloseCalendar(form)
	{    
	    <?php echo $this->prefix; ?>saveCalendar(form);
        <?php echo $this->prefix; ?>showCalendarArea();
    }
    /** Ajax call delete calendar view */
    function <?php echo $this->prefix; ?>deleteCalendar(viewid)
    {        
        var $j = jQuery.noConflict();
        var data = {
            action: '<?php echo $this->prefix; ?>delete_calendar',
            security: '<?php echo $this->ajax_nonce; ?>',
	  	    id: viewid
     	};
     	$j("#<?php echo $this->prefix; ?>calendarslistarea")[0].innerHTML = '<?php _e("Loading..."); ?>';
        $j.post(ajaxurl, data, function(response) {
            try {
		        $j("#<?php echo $this->prefix; ?>calendarslistarea")[0].innerHTML = response;		  		    
                var head = document.getElementsByTagName("head")[0];
                var sTag = document.createElement("script");
                sTag.type = "text/javascript";
                sTag.text = $j("#<?php echo $this->prefix; ?>scriptsarea")[0].innerHTML;
                head.appendChild(sTag);
            } catch (err) {}
	    });
        <?php echo $this->prefix; ?>showCalendarArea();
    }   
    var <?php echo $this->prefix; ?>previewcount = <?php echo mt_rand(10000,999999); ?>;
    function <?php echo $this->prefix; ?>previewCalendar(form)
    {
        <?php echo $this->prefix; ?>saveCalendar(form);                
        <?php echo $this->prefix; ?>previewCalendarId(form.r<?php echo $this->prefix; ?>isediting.value)
    }
    function <?php echo $this->prefix; ?>previewCalendarId(id)
    {
        <?php echo $this->prefix; ?>previewcount++;
        document.getElementById("<?php echo $this->prefix; ?>previewcalendarframe").src = '<?php echo plugins_url('', __FILE__).'/../../../?cpmvc_do_action=preview&id='; ?>'+id+"&nc="+<?php echo $this->prefix; ?>previewcount;
        var $j = jQuery.noConflict();
        var wHeight = $j(window).height();        
        var dHeight = wHeight * 0.9;
        $j( "#dialog" ).dialog({
                                'dialogClass'   : 'wp-dialog',
                                'height': dHeight,
                                'width': '90%'
                               });
    }
    /** LOAD CALENDAR VIEWS LIST */
    var $j = jQuery.noConflict();
    var data = {
        action: '<?php echo $this->prefix; ?>get_views',
        security: '<?php echo $this->ajax_nonce; ?>'
    };
    $j("#<?php echo $this->prefix; ?>calendarslistarea")[0].innerHTML = '<?php _e("Loading..."); ?>';
    $j.post(ajaxurl, data, function(response) {     
          try {
		      $j("#<?php echo $this->prefix; ?>calendarslistarea")[0].innerHTML = response;		  
              var head = document.getElementsByTagName("head")[0];
              var sTag = document.createElement("script");
              sTag.type = "text/javascript";
              sTag.text = $j("#<?php echo $this->prefix; ?>scriptsarea")[0].innerHTML;
              head.appendChild(sTag);
          } catch (err) {}
	});
    /** getting the shortcode and posting it to the editor */
    var <?php echo $this->prefix; ?>CalendarAdmin = function () {} 
    <?php echo $this->prefix; ?>CalendarAdmin.prototype = { 
        options : {},
        generateShortCode : function() { 
            var attrs = '';
            jQuery.each(this['options'], function(name, value){
                value = value.replace(/"/g,'#');
                if (value != '') {attrs += '||||||' + name + '="' + value + '"';}
            });
            //return '[<?php echo $this->shorttag; ?>' + attrs + ']'; 
            return attrs; 
        },
        getCode : function(f) {
            var collection = jQuery(f).find("input[id^=<?php echo $this->prefix; ?>]:not(input:checkbox),input[id^=<?php echo $this->prefix; ?>]:checkbox:checked,select[id^=<?php echo $this->prefix; ?>],textarea[id^=<?php echo $this->prefix; ?>]");
            var $this = this;
            collection.each(function () {
                var name = this.name.substring(<?php echo strlen($this->prefix)+1; ?>, this.name.length-1);
               $this['options'][name] = this.value;
            });
            var shortcode = this.generateShortCode();            
            //send_to_editor(shortcode);            
            try {
                var t = jQuery('#content');
                if(t.length){
                    var v= t.val();
                    if(v.indexOf(shortcode) == -1)
                        t.val(v+shortcode);
                }   
            
            } catch(e) {}
            return shortcode;
        },
        sendToEditor : function(id,view) {                    
            send_to_editor('[<?php echo $this->shorttag; ?> view="'+view+'"]');
            try {
                var t = jQuery('#content');
                if(t.length){
                    var v= t.val();
                    if(v.indexOf(shortcode) == -1)
                        t.val(v+shortcode);
                }   
            
            } catch(e) {}
            return false;
        }
    }
    var <?php echo $this->prefix; ?>Admin = new <?php echo $this->prefix; ?>CalendarAdmin();        
</script>
