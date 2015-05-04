=== CP Multi View Event Calendar ===
Contributors: codepeople
Donate link: http://wordpress.dwbooster.com/calendars/cp-multi-view-calendar
Tags: calendar,calendars,event calendar,event,event manager,images,picture calendar,plugin,page,post,shortcode,images calendar,calendar plugin
Requires at least: 3.0.5
Tested up to: 4.2
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Event calendar for WordPress websites that features multiple visualization modes.

== Description ==

The CP Multi View Event Calendar is an **event calendar** for WordPress websites that features multiple visualization modes and multiple predefined styles.

= Features: =

* Classic month view (like Google Calendar)
* Multi-month view (show a configurable number of months at once)
* Day view
* Week view
* Multiple configurations for the views, the same view can be used in a very different way
* Allows multiple views for the same event calendar on the same page
* Configurable start day of the week
* Can be setup to edit the events from the public website
* You can select which button show/display (ex: navigation buttons, refresh button, others...)
* The event calendar information can be displayed in many ways: Title on the event calendar + tooltip on mouse over or Title on the event calendar + tooltip on mouse click
* Events can have a location and an extended rich text description
* Multiple selectable colors to highlight events in the calendar
* Events can be linked to other pages.
* Can display images directly on the calendar cells
* Can be easily published in a page or post by using its shortcode or visual publish button
* Can be setup to use a 12 or 24 hour clock.
* Can be setup to display only the weekdays needed
* Fast Ajax load for the events data

You can see 20 sample visualization modes and an online demo at: http://wordpress.dwbooster.com/calendars/cp-multi-view-calendar

**Languages Included in the Calendar**

* English
* Spanish
* French
* German
* Italian
* Russian
* Portuguese
* Portuguese (Brasil)
* Danish
* Czech
* Dutch
* Norwegian
* Polish
* Slovak

If your language is not listed here and not available in the calendar feel free to open a support ticket and it will be added asap.

**Update note**

New: The latest update features a new interface for easily editing a previously inserted event calendar view and preview buttons for a faster verification of how the event calendar will look in the website.


== Installation ==

To install **CP Multi View Event Calendar**, follow these steps:

1.	Download and unzip the CP Multi View Event Calendar plugin
2.	Upload the entire cp-multi-view-calendar/ directory to the /wp-content/plugins/ directory
3.	Activate the CP Multi View Event Calendar plugin through the Plugins menu in WordPress
4.	Configure the settings at the administration menu >> CP Multi View Event Calendar. 
5.	To insert the calendar form into some content or post use the icon that will appear when editing contents


== Frequently Asked Questions ==

= Q: What means each field in the event calendar settings area? =

A: The product's page contains detailed information about each event calendar field and customization:

http://wordpress.dwbooster.com/calendars/cp-multi-view-calendar

= Q: How events are added into the event calendar? =

A: In the dashboard area go to "WordPress administration menu >> CP Multiview Event Calendar" and click the button "Admin Calendar Data" that leads to a page where you can add/edit/delete events on the events calendar.

The events edition on the public event calendar can be also (optionally) enabled, that way the website visitors can edit events directly in the event calendar without having to access through the dashboard.

= Q: How show the entire title on month,week and day view? =

A: Open the file "wp-content/plugins/cp-multi-view-calendar/DC_MultiViewCal/css/main.css" and add this CSS rule at end of the file:

    #multicalendar .rb-i{white-space:normal}
    

= Q: How to show differents colors in the event calendar nMonth view? =

A: Use the following configuration parameter:

        date_box_with_color_in_nmonth_view:true

The parameters should be added into the "Other Parameters" box. These parameters must be comma separated and will overwrite the initialconfiguration selected for the event calendar.

The "Other Parameters" box can be found in the following location (link to image):

http://wordpress.dwbooster.com/UserFiles/Image/cp-multiview-calendar/additional-parameters.gif

= Q: How to allow edition on the public event calendar only for some registered users? =

A: If you want to setup the event calendar editable only by some users in the public website then publish a view of the event calendar in a private page (restrict the access to the page with the event calendar with "Edition" enabled).

You can have multiple views of the same event calendar, one for read-only public access and another view with edition enabled on a private page accessible only by registered users.

Note that there are two different concepts here:

* **An event calendar:** This is a unit of information and events. The events aren't shared with other event calendars.
* **An event calendar's view:** This is the way an event calendar is displayed. The same event calendar can have multiple views in the same page or in different pages. Since the event calendar unit is the same the data is shared between all views but the visual settings and features can be different.

See also this other FAQ entry about additional permissions settings: http://wordpress.dwbooster.com/faq/cp-multi-view-calendar#q205

= Q: How show the entire title on month,week and day view on the event calendar? =

A: Open the calendar plugin file "wp-content/plugins/cp-multi-view-calendar/DC_MultiViewCal/css/main.css" and add this CSS rule at end of the file:

        #multicalendar .rb-i{white-space:normal}

= Q: Can I change the event calendar plugin date format to DD/MM/YYYY? =

A: The date format is automatically defined with each language to the proper values, however if you want to overwrite those settings open your plugin language file "wp-content\plugins\cp-multi-view-calendar\DC_MultiViewCal\language\multiview_lang_**xx-XX**.js", where **xx-XX** in the file name is your language identifier and into that file modify the items marked below:

        "fulldaykey": "MMddyyyy",
        "fulldayshow": "L d yyyy",
        "fulldayvalue": "M/d/yyyy",
        "Md": "W M/d",
        "nDaysView": "M/d",
        "Md3": "L d",
        "separator": "/",
        "year_index": 2,
        "month_index": 0,
        "day_index": 1,

... to this:

        "fulldaykey": "ddMMyyyy",
        "fulldayshow": "d L yyyy",
        "fulldayvalue": "d/M/yyyy",
        "Md": "W d/M",
        "nDaysView": "d/M",
        "Md3": "d L",
        "separator": "/",
        "year_index": 2,
        "month_index": 1,
        "day_index": 0,


== Other Notes ==

= Settings in the event calendar insertion area =

To insert the event calendar form into some content or post use the insertion area that will appear below the editor when editing contents. It looks like the following image: 

http://wordpress.dwbooster.com/UserFiles/Image/cp-multiview-calendar/insert-calendar.png

The fields on the event calendar insertion area (shown in the above image) are the following:

* MultiCalendar: Which of the event calendars will be shown.
* Calendar Views: The event calendar views that will be included in the event calendar.
* Default View: Wich of the event calendar views will appear as default.
* Start day of the week: The start day of the week (Ex: Sunday, Monday, ...).
* CSS Style: Select one of the CSS styles available to render the calendar.
* Palette Color: The palete color used for the events in the calendar.
* Allow edition: Check this box if the event calendar will allow edition on the public website.
* Other buttons: Select the buttons that will be displayed on the top of the event calendar.
* Number of Months for nMonths View: Number of months shown at the same time in the event calendar's nMonths View.
* Other parameters for nMonths View: Other parameters for the event calendar's nMonths View (more info below).
* Other parameters: Other parameters that apply to all event calendar views (more info below).

= Adding custom parameters to the event calendar = 

The additional parameters should be added into the "Other Parameters" box in the event calendar insertion area. These parameters must be comma separated and will overwrite the initial configuration selected for the event calendar. 

The "Other Parameters" box can be found in the following location (click to enlarge image): http://wordpress.dwbooster.com/demos/multi-view/screenshots/additional-parameters.png

= Adding custom CSS Styles to the event calendar = 

The custom CSS styles for the event calendar should be set at the end of the CSS file "wp-content/plugins/cp-multi-view-calendar/DC_MultiViewCal/css/main.css". 

= Sample event calendar views = 

The following area some sample event calendar views. You can apply or mix configurations to get your own event calendar views in addition to the following samples:

1.	**View day only:** Event calendar configured with the "day" view option only, the "Default View" should be "day". The views "Week", "Month", "nMonth" should be unchecked. To fix the height, just add (for example) the parameter "height:400". Event Calendar sample for this view: http://wordpress.dwbooster.com/demos/multi-view/01-view-day-only.html    

2.	**View week only:** Event calendar configured with the view week option only; the "Week" view should be enabled and the default view should be "week". The views "Day", "Month" and "nMonth" should be disabled. To fix the height, just add (for example) the parameter "height:400". Event Calendar sample for this view: http://wordpress.dwbooster.com/demos/multi-view/02-view-week-only.html

3.	**View month only:** Event calendar configured with the view month option only. To get this enable the "Month" view and set the default view to "month". The views "Day", "Week" and "nMonth" should be unchecked. To fix the height, just add (for example) the parameter "height:400". Event Calendar sample for this view: http://wordpress.dwbooster.com/demos/multi-view/03-view-month-only.html

4.	**View n-Months only:** Event calendar configured with the view n-Months option only. This can be done by setting the amount of months to display in the event calendar to 12, enable only the "n-Month" view and setting the "Default View" to "nMonth". All the other views and buttons should be unchecked. In the styles for this sample we have selected to fix the calendar width. Event Calendar sample for this view: http://wordpress.dwbooster.com/demos/multi-view/04-view-n-months-only.html 

5.	**Small event calendar:** You can configure the event calendar just like a single small event calendar. This can be done by selecting the n-Months view and setting the "Number of Months for nMonths View" dropdown select box to 1. Event Calendar sample for this view: http://wordpress.dwbooster.com/demos/multi-view/05-small-calendar.html 

6.	**n-Month view, only one month, large view:** Event calendar with the n-Month view configured to display a single month in a large view. To get this result enable only the "n-Month" view and add the styles specified in the following event calendar sample page: http://wordpress.dwbooster.com/demos/multi-view/06-one-month-large-view.html

7.	**n-Month view with 2 months using all the width:** To get this result in the event calendar enable only the "n-Month" view, set the "Number of Months for nMonths View" dropdown select box to 2 and add the styles specified in the following sample page to fix the width of both the event calendar area and the width of each month: http://wordpress.dwbooster.com/demos/multi-view/07-two-months-using-all-the-width.html

8.	**n-Month view, 3 months with vertical align:** The first settings needed to get this event calendar configuration is to enable only the "n-Month" view and set the "Number of Months for nMonths View" dropdown select box to show 3 months. After that proceed to add some CSS styles to fix the width to the desired column width. This way you can publish the calendar in the sidebar of your website. Event Calendar sample for this view: http://wordpress.dwbooster.com/demos/multi-view/08-various-months-with-vertical-align.html 

9.	**Tooltip displayed on month,week and day view:** In this event calendar sample, when you click over an event in the calendar, a floating tooltip panel with additional information is displayed. This type of tooltip is available for the month, week and day views. The n-Month view has a different type of tooltip panel. To enable the tooltips, the parameter "showtooltipdwm" must be set to "true" (or enable it by checking the checkbox in the visual configuration). In addition to these parameters, add also the styles mentioned in the following page as instructed: http://wordpress.dwbooster.com/demos/multi-view/09-tooltip-displayed.html 

10.	**Lighter view for events and center align:** This event calendar sample features the month, week and day views showing the events with a more lighter view: a color border is used instead filled backgrounds and the text is centered. The tooltips are already enabled for this sample; to enable the tooltips you can do that by checking the tooltip checkbox in the visual configuration or just by setting parameter "showtooltipdwm" to "true", this is also explained in other demos. To get the more lighter view you can add the styles indicated at this page: http://wordpress.dwbooster.com/demos/multi-view/10-lighter-view-center-align.html 

11.	**Multi-line event description:** Event calendar that displays a multi-line event description in the month, week and day views, this is useful to display more information directly over the calendar. Only two CSS rules should be added to the styles to get this configuration. It will work with any selection of parameters if you are using one of the mentioned views. Check the detailed instructions at this page: http://wordpress.dwbooster.com/demos/multi-view/11-multi-line-event-description.html

12.	**Images and HTML formatting in tooltip:** The tooltips on the event calendar can show images and formatted text. There are some styles that can be used to show/hide/customize the title, location, description and time: these styles are the CSS classes named "bubbletitle", "bubblelocation", "bubbledescription" and "bubbletime". In this sample we have used only the class "bubbletime" to align it at the bottom of the content/image: http://wordpress.dwbooster.com/demos/multi-view/12-images-and-html-formatting-in-tooltip.html

13.	**Images directly on the calendar cells:** You can use this event calendar like a picture calendar. The images should be added to the event description and the css rules mentioned in the following page to complete the formatting: http://wordpress.dwbooster.com/demos/multi-view/13-images-directly-on-the-calendar-cells.html

14.	**Show only from Monday to Friday:** In this event sample we have disabled the Saturday and Sunday since this is a common configuration. In the "viewWeekDays" parameter, each number in the array represents a weekday from Sunday to Saturday. An zero means that the weekday is disabled (not shown) and a 1 means that the day is enabled (shown). Details at: http://wordpress.dwbooster.com/demos/multi-view/14-show-only-from-monday-to-friday.html

15.	**Using 12 or 24 hour clock:** This event calendar supports both the 12 and the 24 hour clock (also known as military time). The 24-hour clock is enabled as default; if you prefer to use the 12-hour clock then just set the parameter "militaryTime" to "false". Event calendar sample for this view: http://wordpress.dwbooster.com/demos/multi-view/15-using-12-or-24-hour-clock.html

16.	**Showing the n-Days view:** With this event calendar view you can display many days in a view similar to the single day view. First you should enable the "nDays" view and then set the number of days to view on each calendar page. The parameters are viewNDays:true for enabling the view, numberOfDays:10 for setting the number of days and viewdefault:"nDays" to make it the default view if needed. Event calendar sample for this view: http://wordpress.dwbooster.com/demos/multi-view/16-n-days-view.html 

17.	**Selecting hours to be shown:** In some applications you may want to select only some hours to be shown in the event calendar, for example working hours. In the "Days", "nDays" and "Week" views you can select the range of hours to be shown be setting the start and end hours. Three parameters must be specified for this: the start hour hoursStart:8, the end hour hoursEnd:17 and the height of a single hour cell cellheight:60. Hours are in military time, so 17 means 5:00pm. Event calendar sample for this view: http://wordpress.dwbooster.com/demos/multi-view/17-selecting-hours-to-be-shown.html

18.	**Using drop-down lists for location and title:** The location and title that are part of each event's description in the calendar are open/editable fields by default but you can convert them in drop-down lists to make them easier to edit and keep the data consistency. Event calendar sample for this view and detailed instructions: http://wordpress.dwbooster.com/demos/multi-view/18-lists-for-location-and-title.html

19.	**Multi-column day view, location or title:** In this event calendar sample the location and title have been converted in drop-down lists as explained in the previous sample #18. In addition to that now we have selected to use the "title" field as the column header in the day view, this way the events are placed in different columns agrupated by their titles. The same can be done with the location instead the title. Event calendar sample for this view and detailed instructions: http://wordpress.dwbooster.com/demos/multi-view/19-multi-column-day-view.html

20.	**Day view with location & title grid:** The event calendar day view can be modified to show the title and location as headers of the rows and column instead the default single columns and the hour in the row header. This is useful to display informations agrupated by title and location on each day. Event calendar sample for this view and detailed instructions: http://wordpress.dwbooster.com/demos/multi-view/20-day-view-with-location-title-grid.html


== Screenshots ==

1. Classic Multi View Event Calendar (Google Calendar Style)
2. Event calendar in Month view with event information floating panel
3. Event calendar with images on the event calendar cells
4. Classic little event calendar for sidebars
5. Event calendar in single day view
6. Event calendar in single month view
7. Advanced sample: Event calendar with custom information on rows
8. Advanced sample: Event calendar with custom information on both rows and columns


== Changelog ==

= 1.0 =
* First stable version released.
* More configuration options added.

= 1.0.1 =
* Interface modifications.
* Added missing images folder
* Preview options for the event calendar views
* Fixed bug with special characters in events
* Compatible with the latest WP versions
* Modifications to make the calendar responsive

= 1.0.2 =
* Improved plugin security 
* Fixed warning that appeared with PHP safe mode restrictions 
* Sanitized GET parameters used in queries

= 1.1.5 =
* Fixed SQL and XSS Vulnerabilities (vulnerability was found by Joaquin Ramirez Martinez with the help Christian Mondragon Uriel Zarate)
* Translations improved
* Update to the ajax url paths
* Fixed bug related to the date format

= 1.1.6 =
* Sanitized output of items on the admin area

= 1.1.7 =
* Tooltip setting is now marked as default
* New col attribute in the day view with columns
* Pre-selection of items in quick add tooltip features
* Compatible with the latest WordPress 4.2.x version

Important note: If you are using the Professional version don't update via the WP dashboard but using your personal update link. Contact us if you need further information: http://wordpress.dwbooster.com/support

== Upgrade Notice ==

= 1.1.7 =
* Tooltip setting is now marked as default
* New col attribute in the day view with columns
* Pre-selection of items in quick add tooltip features

 
Important note: If you are using the Professional version don't update via the WP dashboard but using your personal update link. Contact us if you need further information: http://wordpress.dwbooster.com/support