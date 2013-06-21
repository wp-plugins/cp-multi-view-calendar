for (var i=0; i<100;i++)
{
var tt = eval("cpmvc_configmultiview"+i);
if (tt)
{
(function($) {    
 mvcconfig = $.parseJSON(tt.obj);
 console.log(mvcconfig.params);
 //console.log($.parseJSON(mvcconfig.params));
})(jQuery);
var pathCalendar = mvcconfig.ajax_url;
dc_subjects = "";
dc_locations = "";
initMultiViewCal("cal"+mvcconfig.calendar, mvcconfig.calendar,(mvcconfig.params));
}
}