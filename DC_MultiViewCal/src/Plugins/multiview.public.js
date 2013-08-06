try {
    for (var i=0; i<100;i++)
    {
        var tt = eval("cpmvc_configmultiview"+i);
        if (tt)
        {
            (function($) {    
                mvcconfig = $.parseJSON(tt.obj);
                if (mvcconfig.params.otherparams)
                {
                    //console.log("var others={"+mvcconfig.params.otherparams+"};");
                    eval("var others={"+mvcconfig.params.otherparams+"};");
                    mvcconfig.params = $.extend(mvcconfig.params, others);
                }
            })(jQuery);             
            var pathCalendar = mvcconfig.ajax_url;
            dc_subjects = "";
            dc_locations = "";
            initMultiViewCal("cal"+mvcconfig.calendar, mvcconfig.calendar,(mvcconfig.params));
        }
    }
}catch (e) {} 