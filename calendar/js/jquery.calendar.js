/*
 *	jQuery FullCalendar Extendable Plugin
 *	An Ajax (PHP - Mysql - jquery) script that extends the functionalities of the fullcalendar plugin
 *  Dependencies: 
 *   - jquery
 *   - jquery Ui
 *   - jquery Fullcalendar
 *   - Twitter Bootstrap
 *  Author: Paulo Regina
 *  Website: www.pauloreg.com
 *  Contributions: Patrik Iden, Jan-Paul Kleemans, Bob Mulder
 *	Version 1.5.8 [Bootstrap 3.X just removed input-block-level to form-control], May - 2014
 *	Released Under Envato Regular or Extended Licenses
 */
 
(function($, undefined) 
{
	$.fn.extend 
	({
		// FullCalendar Extendable Plugin
		FullCalendarExt: function(options) 
		{	
			// Default Configurations
            var defaults = 
			{
				calendarSelector: '#calendar',
				
				timeFormat: 'H:mm - {H:mm}',
				
				ajaxJsonFetch: 'includes/cal_events.php',
				ajaxUiUpdate: 'includes/cal_update.php',
				ajaxEventSave: 'includes/cal_save.php',
				ajaxEventQuickSave: 'includes/cal_quicksave.php',
				ajaxEventDelete: 'includes/cal_delete.php',
				ajaxEventEdit: 'includes/cal_edit_update.php',
				ajaxEventExport: 'includes/cal_export.php',
				
				modalViewSelector: '#cal_viewModal',
				modalEditSelector: '#cal_editModal',
				modalQuickSaveSelector: '#cal_quickSaveModal',
				formAddEventSelector: 'form#add_event',
				formFilterSelector: 'form#filter-category select',
				formSearchSelector: 'form#search',
				formEditEventSelector: 'form#edit_event', // php version
				
				successAddEventMessage: 'Successfully Added Event',
				successDeleteEventMessage: 'Successfully Deleted Event',
				successUpdateEventMessage: 'Successfully Updated Event',
				failureAddEventMessage: 'Failed To Add Event',
				failureDeleteEventMessage: 'Failed To Delete Event',
				failureUpdateEventMessage: 'Failed To Update Event',
				
				visitUrl: 'Visit Url:',
				titleText: 'Title:',
				descriptionText: 'Description:',
				categoryText: 'Category:',
				
				defaultColor: '#587ca3',
								
				monthNames: ['January','February','March','April','May','June','July','August','September','October','November','December'],
				monthNamesShort: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
				dayNames: ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
				dayNamesShort: ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'],
				today: 'today',
				month: 'month',
				week: 'week',
				day: 'day',
				
				weekType: 'agendaWeek', // basicWeek
				dayType: 'agendaDay', // basicDay
				
				editable: true,
				disableDragging: false,
				disableResizing: false,
				ignoreTimezone: true,
				lazyFetching: true,
				filter: true,
				quickSave: true,
				firstDay: 0,
				
				gcal: false,
				
				version: 'modal',
				
				quickSaveCategory: '',
				
				savedRedirect: 'index.php',
				removedRedirect: 'index.php',
				updatedRedirect: 'index.php'  
            }

			var options =  $.extend(defaults, options);
			
			var opt = options;
						
			if(opt.version == 'modal' && opt.gcal == false)
			{
			// fullCalendar
			$(opt.calendarSelector).fullCalendar
			({
				timeFormat: opt.timeFormat,
				header: 
				{
						left: 'prev,next',
						center: 'title',
						right: 'month,'+opt.weekType+','+opt.dayType	

				},
				monthNames: opt.monthNames,
				monthNamesShort: opt.monthNamesShort,
				dayNames: opt.dayNames,
				dayNamesShort: opt.dayNamesShort,
				buttonText: {
					today: opt.today,
					month: opt.month,
					week: opt.week,
					day: opt.day
				},
				editable: opt.editable,
				disableDragging: opt.disableDragging,
				disableResizing: opt.disableResizing,
				ignoreTimezone: opt.ignoreTimezone,
				firstDay: opt.firstDay,
				lazyFetching: opt.lazyFetching,
				selectable: opt.quickSave,
				selectHelper: opt.quickSave,
				select: function(start, end, allDay) 
				{
					calendar.quickModal(start, end, allDay);
					$(opt.calendarSelector).fullCalendar('unselect');
				},
				eventSources: [{url: opt.ajaxJsonFetch, allDayDefault: false}],
				eventDrop: 
					function(event) 
					{ 
						$.post(opt.ajaxUiUpdate, event, function(response) {
							// just update $(opt.calendarSelector).fullCalendar('refetchEvents');
						});
					},
				eventResize:
					function(event) 
					{ 
						$.post(opt.ajaxUiUpdate, event, function(response){
							// just update $(opt.calendarSelector).fullCalendar('refetchEvents');
						});
					},
				eventRender: 
					function(event, element) 
					{	
						element.attr('data-toggle', 'modal');
						element.attr('onclick', 'calendar.openModal("' + event.title + '","' + escape(event.description) + '","' + event.url + '","' + event.id + '","' + event.start + '","' + event.end + '");');  	
					}	
				}); //fullCalendar
				
				 // Function to Open Modal
				calendar.openModal = function(title, description, url, id, eStart, eEnd)
				{
					 calendar.title = title;
					 calendar.description = description;
					 calendar.url = url;
					 calendar.id = id;
					 
					 calendar.eventStart = eStart;
					 calendar.eventEnd = eEnd;
					  					  
					  if(calendar.url === 'undefined') 
					  {
					  	$(".modal-body").html(unescape(calendar.description)); 
					  } else {
					  	$(".modal-body").html(unescape(calendar.description)+'<br /><br />'+opt.visitUrl+' <a href="'+calendar.url+'">'+calendar.url+'</a>'); 	  
					  }
					  
					  $(".modal-header").html('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>'+'<h4>'+calendar.title+'</h4>'); 
					  
					  $(opt.modalViewSelector).modal('show');
		
					  	// Edit Button
						$(".modal-footer").delegate('[data-option="edit"]', 'click', function(e) 
						{
							$(opt.modalViewSelector).modal('hide');
							
							if(calendar.url === 'undefined') {
								$(".modal-header").html('<form id="event_title_e"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><label>'+opt.titleText+' </label>'+'<input type="text" class="form-control" name="title_update" value="'+calendar.title+'"></form>');
								$(".modal-body").html('<form id="event_description_e"><label>'+opt.descriptionText+' </label>'+'<textarea class="form-control" name="description_update">'+unescape(calendar.description)+'</textarea></form>');
							} else {
								$(".modal-header").html('<form id="event_title_e"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><label>'+opt.titleText+' </label>'+'<input type="text" class="form-control" name="title_update" value="'+calendar.title+'"></form>');
								$(".modal-body").html('<form id="event_description_e"><label>'+opt.descriptionText+' </label>'+'<textarea class="form-control" name="description_update">'+unescape(calendar.description)+'</textarea><label>Url: </label>'+'<input type="text" class="form-control" name="url_update" value="'+calendar.url+'"></form>');	
							}
							
							$(opt.modalEditSelector).modal('show'); 
							
							  // On Modal Hidden
							 $(opt.modalEditSelector).on('hidden', function() {
								//$(opt.calendarSelector).fullCalendar('refetchEvents'); (by uncommenting this fixes multiply loads bug)
							 })
							 
							 // Close Button - This is due cache to prevent data being saved on another view
							 $(".modal-footer").delegate('[data-dismiss="modal"]', 'click', function(e) 
							 {
								 //$(opt.calendarSelector).fullCalendar('refetchEvents'); (by uncommenting this fixes multiply loads bug)
								 e.preventDefault();
							 });
						 	 
							e.preventDefault();
						});
				} // openModal
				
				// After all step above save
			    // Update button
				$(".modal-footer").delegate('[data-option="save"]', 'click', function(e) 
				{	
					var event_title_e = $("form#event_title_e").serializeArray(); 
					var event_description_e = $("form#event_description_e").serializeArray();
					var event_url = $("form#event_description_e").serializeArray();
					
					calendar.update(calendar.id, event_title_e[1], event_description_e, event_url);
					
					e.preventDefault();
				});
					
				// Delete button
				$(".modal-footer").delegate('[data-option="remove"]', 'click', function(e) 
				{
					calendar.remove(calendar.id);	
					e.preventDefault();
				 });
				 
				 // Export button
				$(".modal-footer").delegate('[data-option="export"]', 'click', function(e) 
				{
					calendar.exportIcal(calendar.id, calendar.title, calendar.description, calendar.eventStart, calendar.eventEnd, calendar.url);	
					e.preventDefault();
				 });
										
				// Function to quickModal
				calendar.quickModal = function(start, end, allDay)
				{
					$(".modal-header").html('<form id="event_title"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><label>'+opt.titleText+' </label>'+'<input type="text" class="form-control" name="title" value=""></form>');
					
					$(".modal-body").html('<form id="event_description"><label>'+opt.descriptionText+' </label>'+'<textarea class="form-control" name="description"></textarea>'+opt.quickSaveCategory+'</form>');
						
					$(opt.modalQuickSaveSelector).modal('show');
					
					calendar.start = start;
					calendar.end = end;
					calendar.allDay = allDay;
					
					// Save button
					$(".modal-footer").delegate('[data-option="quickSave"]', 'click', function(e) 
					{	
						var event_title = $("form#event_title").serialize();
						var event_description = $("form#event_description").serialize();
						
						calendar.quickSave(event_title, event_description, calendar.start, calendar.end, calendar.allDay);
						
						e.preventDefault();
					});
					
					e.preventDefault();

				} // end quickModal
					
				// Function quickSave 
				calendar.quickSave = function(event_title, event_description, start, end, allDay)
				{
					var start_factor = $.fullCalendar.formatDate(start, 'yyyy-MM-dd');
					var startTime_factor = $.fullCalendar.formatDate(start, 'HH:mm');
					var end_factor = $.fullCalendar.formatDate(end, 'yyyy-MM-dd');
					var endTime_factor = $.fullCalendar.formatDate(end, 'HH:mm');
					var constructor = 'title='+event_title+'&description='+event_description+'&start_date='+start_factor+'&start_time='+startTime_factor+'&end_date='+end_factor+'&end_time='+endTime_factor+'&url=false&color='+opt.defaultColor+'&allDay='+allDay;
					$.post(opt.ajaxEventQuickSave, constructor, function(response) 
					{				
						if(response == 1 || response == '' || response == true) 
						{
							$(opt.modalQuickSaveSelector).modal('hide');
							$(opt.calendarSelector).fullCalendar('refetchEvents');
						} else {
							alert(response);	
						}
					});	
					e.preventDefault();
				} // end quickSave
					   
				// Function to Save Data to the Database 
				calendar.save = function()
				{
					$(opt.formAddEventSelector).on('submit', function(e)
					{
						$.post(opt.ajaxEventSave, $(this).serialize(), function(response) 
						{
							if(response == 1) 
							{
								alert(opt.successAddEventMessage);
								document.location.reload();
							} else {
								alert(opt.failureAddEventMessage);
							}
							
						});	
						e.preventDefault();
					}); 
				};
					
				// Function to Remove Event ID from the Database
				calendar.remove = function(id)
				{
					var construct = "id="+id;
					
					$.post(opt.ajaxEventDelete, construct, function(response) 
					{
						if(response == '') 
						{
							$(opt.modalViewSelector).modal('hide');
							$(opt.calendarSelector).fullCalendar('refetchEvents');
						} else {
							alert(opt.failureDeleteEventMessage);
						}
					});	
				};
					
				// Function to Update Event to the Database
				calendar.update = function(id, title, description, url)
				{
					if(calendar.url === 'undefined') {
						var construct = "id="+id+"&title="+title.value+"&description="+description[1].value;	
					} else {
						var construct = "id="+id+"&title="+title.value+"&description="+description[2].value+'&url='+url[3].value;		
					}
					
					$.post(opt.ajaxEventEdit, construct, function(response) 
					{
						if(response == '') 
						{
							$(opt.modalEditSelector).modal('hide');
							$(opt.calendarSelector).fullCalendar('refetchEvents');
						} else {
							alert(opt.failureUpdateEventMessage);	
						}
					});	
				}
				
				// Function to Export Calendar
				calendar.exportIcal = function(expID, expTitle, expDescription, expStart, expEnd, expUrl)
				{ 
					var start_factor = $.fullCalendar.formatDate($.fullCalendar.parseDate(expStart), 'yyyy-MM-dd HH:mm:ss');
					var end_factor = $.fullCalendar.formatDate($.fullCalendar.parseDate(expEnd), 'yyyy-MM-dd HH:mm:ss');
					
					var construct = 'method=export&id='+expID+'&title='+expTitle+'&description='+expDescription+'&start_date='+start_factor+'&end_date='+end_factor+'&url='+expUrl;	

					$.post(opt.ajaxEventExport, construct, function(response) 
					{
						
						$(opt.modalViewSelector).modal('hide');
						window.location = 'includes/Event-'+expID+'.ics';
						var construct2 = 'id='+expID;
						$.post(opt.ajaxEventExport, construct2, function() {});
					});
				}
					
			} else {
						
				if(opt.gcal == true) { opt.weekType = ''; opt.dayType = ''; }
				
				// php view mode fullcalendar
				$(opt.calendarSelector).fullCalendar
				({
					timeFormat: opt.timeFormat,
					header: 
					{
						left: 'prev,next',
						center: 'title',
						right: 'month,'+opt.weekType+','+opt.dayType
					},
					monthNames: opt.monthNames,
					monthNamesShort: opt.monthNamesShort,
					dayNames: opt.dayNames,
					dayNamesShort: opt.dayNamesShort,
					buttonText: {
						today: opt.today,
						month: opt.month,
						week: opt.week,
						day: opt.day
					},
					editable: opt.editable,
					disableDragging: opt.disableDragging,
					disableResizing: opt.disableResizing,
					ignoreTimezone: opt.ignoreTimezone,
					firstDay: opt.firstDay,
					eventSources: [{url: opt.ajaxJsonFetch, allDayDefault: false}],
					eventDrop: 
						function(event) 
						{ 
							$.post(opt.ajaxUiUpdate, event, function(response){
								// success, its ajax so no visible response
							});
						},
					eventResize:
						function(event) 
						{ 
							$.post(opt.ajaxUiUpdate, event, function(response){
								// success, its ajax so no visible response
							});
						}
				}); // fullcalendar
				
				// php view mode Function to Save Data to the Database 
				calendar.save = function()
				{
					$(opt.formAddEventSelector).on('submit', function(e)
					{
						$.post(opt.ajaxEventSave, $(this).serialize(), function(response) 
						{
							if(response == 1) 
							{
								alert(opt.successAddEventMessage);
								window.location = opt.savedRedirect;
							} else {
								alert(opt.failureAddEventMessage);	
							}
							
						});	
						e.preventDefault();
					}); 
				};
				
				// php view mode Function to Remove Event ID from the Database
				calendar.remove = function(id)
				{
					var construct = "id="+id;
					
					$.post(opt.ajaxEventDelete, construct, function(response) 
					{
						if(response == '') 
						{
							alert(opt.successDeleteEventMessage);
							window.location = opt.removedRedirect;
						} else {
							alert(opt.failureDeleteEventMessage);
						}
					});	
				};
				
				calendar.update = function(id)
				{
					var construct = $(opt.formEditEventSelector).serialize()+"&id="+id;
				
					$(opt.formEditEventSelector).on('submit', function(e) 
					{
						$.post(opt.ajaxEventEdit, construct, function(response) 
						{
							if(response == '') {
								alert(opt.successUpdateEventMessage);
								window.location = opt.updatedRedirect;
							} else {
								alert(opt.failureUpdateEventMessage);
							}
							
						});	
						e.preventDefault();
					});  
				};
						
			} // if condition
			
			// Commons - modal + phpversion
			// Fiter
			if(opt.filter == true)
			{
				$(opt.formFilterSelector).on('change', function(e) 
				{
					 selected_value = $(this).val();
					 
					 construct = 'filter='+selected_value;
					 
					 $.post('includes/loader.php', construct, function(response) 
					{
						$(opt.calendarSelector).fullCalendar('refetchEvents');
					});	
					 
					 e.preventDefault();  
				});
			}
			
			// Commons - modal + phpversion
			// Search Form
			if(opt.filter == true)
			{
				// keypress
				$(opt.formSearchSelector).keypress(function(e) 
				{
					if(e.which == 13)
					{
						search_me();
						e.preventDefault();
					}
				});
				
				// submit button
				$(opt.formSearchSelector+' button').on('click', function(e) 
				{
					search_me();
				});
				
				function search_me()
				{
					 value = $(opt.formSearchSelector+' input').val();
					 
					 construct = 'search='+value;
					 
					 $.post('includes/loader.php', construct, function(response) 
					{
						$(opt.calendarSelector).fullCalendar('refetchEvents');
					});		
				}
			}
		   
		} // FullCalendar Ext
		
	}); // fn
	 
})(jQuery);

// define object at end of plugin to fix ie bug
var calendar = {};