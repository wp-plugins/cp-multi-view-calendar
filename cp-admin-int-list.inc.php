<?php

if ( !is_admin() ) 
{
    echo 'Direct access not allowed.';
    exit;
}

$current_user = wp_get_current_user();

global $wpdb;
$message = "";
if (isset($_GET['u']) && $_GET['u'] != '')
{    
    $wpdb->query('UPDATE `'.$wpdb->prefix.'dc_mv_calendars` SET title="'.esc_sql(strip_tags($_GET["name"])).'",published='.intval($_GET["public"]).',owner="'.esc_sql(strip_tags($_GET["owner"])).'" WHERE id='.intval($_GET['u']));           
    $message = "Item updated";
}


if ($message) echo "<div id='setting-error-settings_updated' class='updated settings-error'><p><strong>".$message."</strong></p></div>";

?>
<div class="wrap">
<h2><?php echo $this->plugin_name; ?></h2>

<script type="text/javascript">
 function cp_updateItem(id)
 {
    var calname = document.getElementById("calname_"+id).value;
    var owner = document.getElementById("calowner_"+id).options[document.getElementById("calowner_"+id).options.selectedIndex].value;    
    if (owner == '')
        owner = 0;
    var is_public = (document.getElementById("calpublic_"+id).checked?"1":"0");
    document.location = 'admin.php?page=<?php echo $this->menu_parameter; ?>_manage&u='+id+'&r='+Math.random()+'&public='+is_public+'&owner='+owner+'&name='+encodeURIComponent(calname);    
 }
 
 function cp_manageSettings(id)
 {
    document.location = 'admin.php?page=<?php echo $this->menu_parameter; ?>_manage&cpmvc_id='+id+'&r='+Math.random();
 }
 
 function cp_deleteItem(id)
 {
    alert('Feature not available in free version since this version supports one calendar.');
 } 
  
 function cp_cloneItem(id)
 {
    alert('Feature not available in free version since this version supports one calendar.'); 
 } 
 
</script>


<div id="normal-sortables" class="meta-box-sortables">

  <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>Instructions</span></h3>
  <div class="inside"> 
   
      <p><span style="font-weight:bold;color:#ff3333">To insert a calendar into a page or post</span>, go to the <strong>edition of the page/post</strong> and use the box named "<strong>CP Multi View Calendar</strong>" below the edition area.</p> 
      
      <p>In that area you can create a new view and when ready sent the shortcode to the editor through the button included for that purpose.</p>     
      
    <p><span style="font-weight:bold;color:#ff3333">To add events to the calendar</span> click the "<strong>Admin Calendar Data</strong>" button below that leads to a page where you can add/edit/delete events on the calendar (just click over the desired dates).</p>
      
      <p><strong>Want to help to the development of this plugin?</strong> The main features of this plugin are provided free of charge. We need your help to continue developing it and adding new features. If you want to help with the development please <a href="https://wordpress.org/support/view/plugin-reviews/cp-multi-view-calendar?rate=5#postform" style="color:#0000ff;font-weight:bold;">add a review to support it</a>. Thank you!</p>
  </div>    
 </div>

 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>Calendar List / Items List</span></h3>
  <div class="inside">
  
  
  <table cellspacing="5"> 
   <tr>
    <th align="left">Calendar Name</th><th align="left">User</th><th align="left">&nbsp; &nbsp; Published?</th><th align="left">&nbsp; &nbsp; Options</th>
   </tr> 
<?php  
  $users = $wpdb->get_results( "SELECT user_login,ID FROM ".$wpdb->users." ORDER BY ID DESC" );                                                                     
  $myrows = $wpdb->get_results( "SELECT * FROM ". $wpdb->prefix."dc_mv_calendars");                                                                       
  foreach ($myrows as $item)   
      if ($this->is_administrator() || ($current_user->ID == $item->owner))
      {     
?>
   <tr> 
      <td nowrap><input <?php if (!$this->is_administrator()) echo ' readonly '; ?> type="text" name="calname_<?php echo $item->id; ?>" id="calname_<?php echo $item->id; ?>" value="<?php echo esc_attr($item->title); ?>" /></td>
    <?php if ($this->is_administrator()) { ?>
      <td nowrap>
      <select name="calowner_<?php echo $item->id; ?>" id="calowner_<?php echo $item->id; ?>">
       <option value="0"<?php if (!$item->owner) echo ' selected'; ?>></option>
       <?php foreach ($users as $user) { 
       ?>
          <option value="<?php echo $user->ID; ?>"<?php if ($user->ID."" == $item->owner) echo ' selected'; ?>><?php echo $user->user_login; ?></option>
       <?php  } ?>
      </select>
    </td>    
    <?php } else { ?>
        <td nowrap>
        <?php echo $current_user->user_login; ?>
        </td>
    <?php } ?>
    <?php if ($this->is_administrator()) { ?>
      <td nowrap>&nbsp; &nbsp; <input type="checkbox" name="calpublic_<?php echo $item->id; ?>" id="calpublic_<?php echo $item->id; ?>" value="1" <?php if ($item->published) echo " checked "; ?> /></td>
    <?php } ?>  
      <td nowrap>&nbsp; &nbsp; 
                  <?php if ($this->is_administrator()) { ?> 
                             <input type="button" name="calupdate_<?php echo $item->id; ?>" value="Update" onclick="cp_updateItem(<?php echo $item->id; ?>);" /> &nbsp;                              
                  <?php } ?>  
                             <input type="button" name="calmanage_<?php echo $item->id; ?>" value="Admin Calendar Data" onclick="cp_manageSettings(<?php echo $item->id; ?>);" /> &nbsp; 
                  <?php if ($this->is_administrator()) { ?>                              
                             <input type="button" name="calclone_<?php echo $item->id; ?>" value="Clone" onclick="cp_cloneItem(<?php echo $item->id; ?>);" /> &nbsp;   
                             <input type="button" name="caldelete_<?php echo $item->id; ?>" value="Delete" onclick="cp_deleteItem(<?php echo $item->id; ?>);" /></td>
                  <?php } ?>             
   </tr>
<?php  
  } 
?>   
     
  </table> 
    
    
   
  </div>    
 </div> 

 
<?php if ($this->is_administrator()) { ?>    
 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span>New Calendar / Item</span></h3>
  <div class="inside"> 
   
        * Pro version supports multiple calendars. <a href="http://wordpress.dwbooster.com/calendars/cp-multi-view-calendar#download">Click here for details</a>.

  </div>    
 </div>
<?php } ?>

  
</div> 


[<a href="http://wordpress.dwbooster.com/contact-us" target="_blank">Request Custom Modifications</a>] | [<a href="http://wordpress.dwbooster.com/calendars/cp-appointment-calendar" target="_blank">Help</a>]
</form>
</div>














