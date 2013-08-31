<?php if ( !is_admin() ) {echo 'Direct access not allowed.';exit;} ?>


<table class="form-table">
    <tr valign="top">
        <th scope="row"><label>MultiCalendar</label></th>
        <td><select id="<?php echo $this->prefix; ?>_id" name="<?php echo $this->prefix; ?>[id]" class="required">            	
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
</table>

<table class="form-table">    
    <tr>
        <td colspan="2">
            <p class="submit"><input type="button" onclick="return <?php echo $this->prefix; ?>Admin.sendToEditor(this.form);" value="<?php _e('Send Calendar to Editor &raquo;'); ?>" /></p>                    
        </td>
    </tr>
</table>
<script type="text/javascript">  
    var <?php echo $this->prefix; ?>CalendarAdmin = function () {} 
    <?php echo $this->prefix; ?>CalendarAdmin.prototype = { 
        options : {},
        generateShortCode : function() { 
            var attrs = '';
            jQuery.each(this['options'], function(name, value){
                value = value.replace(/"/g,'#');
                if (value != '') {attrs += ' ' + name + '="' + value + '"';}
            });
            return '[<?php echo $this->shorttag; ?>' + attrs + ']'; 
        },
        sendToEditor : function(f) {
            var collection = jQuery(f).find("input[id^=<?php echo $this->prefix; ?>]:not(input:checkbox),input[id^=<?php echo $this->prefix; ?>]:checkbox:checked,select[id^=<?php echo $this->prefix; ?>],textarea[id^=<?php echo $this->prefix; ?>]");
            var $this = this;
            collection.each(function () {
                var name = this.name.substring(<?php echo strlen($this->prefix)+1; ?>, this.name.length-1);
               $this['options'][name] = this.value;
            });
            var shortcode = this.generateShortCode()
            send_to_editor(shortcode);
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
