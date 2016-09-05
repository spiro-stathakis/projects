function AppPackageCalendar() {
}



/* ********************************************************** */    

AppPackageCalendar.prototype = {
    delayed:false, // whether to load on start
    selectedDate:0, 
    selectedTime:0, 
    calId:0, 
    moment:moment(), 
    currentEvent:{}, 
  /* ********************************************************** */    
    
    init:function() { //default function
       

             
       /*** set up calendar - project relationship ******/ 
        $('#calendar_id').change(function(){
            var cal_id=$(this).val();  
            var project_option = false; 
              for (var i =0 ; i<$.app.mc.allCalendars.length ; i++ )
                  if (cal_id == $.app.mc.allCalendars[i].calendar_id)        
                      if ($.app.mc.allCalendars[i].project_option_id == $.app.mc.types_boolean.true)
                          project_option = true;
              
            $('#project_id').prop('disabled', ! project_option); 
             
        });


        $('#booking-all_day_option_id').change(function(){
            var cal_id = $('#calendar_id').val(); 
             
            if (cal_id != 0 )
            {
              var r = $.app.cal.getCalendarRecord(cal_id); 
              
            }
        }); 
        
        $('#delete-button').click(function(){
            $.app.cal.deleteEvent(); 
        }); 
        /*** set up tree view  ******/ 
        $('#tree').treeview({
            showCheckbox:true, 
            data: $.app.mc.tree,
            highlightSelected: false, 
            levels:0, 
            showTags:true, 
            onNodeChecked: function(event, data) {
              $.app.cal.subscribe(data); 
            },
            onNodeUnchecked: function(event, data) {
              $.app.cal.unsubscribe(data); 
            }
        });
         $('#project_id').prop('disabled', true); 
        return true;

    	// do some init like set the fields to an initial value

    }, 
  /* ********************************************************** */
  deleteEvent: function(){
        if (! this.currentEvent.editable)
            return false; 
        if (confirm('Click OK if you are sure.'))  
        {
            var form = this.getDataForm(); 
            form.ee_id = this.currentEvent.event_entry_id; 
            $.ajax({
              type: "POST",
              url: $.app.mc.deleteEventUri,
              data: form,
              success: function(data,status,xhr){
               var type= 'success'; 
               $('#full-calendar').fullCalendar('refetchEvents');
               $.app.cal.resetFields(); 
               $('#eventShowModal').modal('toggle'); 
               message = 'Event deleted'; 
               $.bootstrapGrowl(message , {'type':type}, 1000 );

              },
              dataType: 'json'
            });

        }

  },
  /* ********************************************************** */
  getDataForm:function(){
      return {
            '_csrf' : $.app.mc.csrfToken 
          };
    } ,
  
  /* ********************************************************** */
  getCalendarRecord:function(cal_id)
  {
      var record = {}; 
      for(var i =0 ; i < $.app.mc.allCalendars.length;i++)
        if ($.app.mc.allCalendars[i].calendar_id == cal_id )
          record = $.app.mc.allCalendars[i]; 
       
      
      return record; 

  }, 
  /* ********************************************************** */
  
  /* ********************************************************** */  
    subscribe:function(data){
          var form = this.getDataForm(); 
          form.cal_id = data.cal_id;
          $.app.cal.calId = data.cal_id; 
          $.ajax({
              type: "POST",
              url: $.app.mc.subscribeUri,
              data: form,
              success: function(data,status,xhr){
                 $('#full-calendar').fullCalendar('refetchEvents');
              },
              dataType: 'json'
            });
    },
  /* ********************************************************** */  
  
    unsubscribe:function(data){
          var form = this.getDataForm(); 
          form.cal_id = data.cal_id;
          $.app.cal.calId = data.cal_id; 
          $.ajax({
              type: "POST",
              url: $.app.mc.unsubscribeUri,
              data: form,
              success: function(data,status,xhr){
                  $('#full-calendar').fullCalendar('removeEvents', function(event) { 
                        return event.cal_id == $.app.cal.calId; 
              });

              },
              dataType: 'json'
            });
    },
  /* ********************************************************** */  
   
    dayClick:function(date, jsEvent, view)
    {
        this.selectedDate = date.format('DD-MM-YYYY');
        this.selectedTime = date.format('LT')
        //$('#start_date').datetimepicker('date' , this.selectedDate);
        $('#start_date-disp').val(this.selectedDate);
        $('#start_date').val(this.selectedDate);
        $('#start_time').val(this.selectedTime);
        $('#end_time').val(date.add(1, 'hours').format('LT'));
        $('#booking-title').val(''); 
        $('#eventModal').modal(); 
		
    }, 
/* ********************************************************** */    
    
/* ********************************************************** */    
    eventMouseover:function(event, jsEvent, view,that)
    {
     
      
     var div = this._popoverDiv(event);
     $("body").append(div);
    $(that).mouseover(function(e) {
         // $(that).css('z-index', 10000);
          $('.popover').fadeIn('10');
          $('.popover').fadeTo('10', 1.9);
      }).mousemove(function(e) {
          $('.popover').css('top', e.pageY + 10);
          $('.popover').css('left', e.pageX + 20);
      }).mouseout(function(e){
         
      });

     
    },
/* ********************************************************** */
 
  
  eventMouseout:function(event, jsEvent, view)
    {
      $('.popover').remove();
    },
/* ********************************************************** */
  eventDrop:function(event, delta, revertFunc, jsEvent, ui, view )
  {

    cal = this.getCalendarRecord(event.calendar_id);
    event.start.add(event.start._data);
    event.end.add(event.end._data);
    var form = this._buildUpdateEventForm(event); 
    
     $.ajax({
              type: "POST",
              url: $.app.mc.updateEventUri,
              data: form,
              success: function(data, textStatus, jqXHR){return $.app.cal._updateEvent( data, textStatus, jqXHR,revertFunc)},
              dataType: 'JSON'
            });


  },
  /* ********************************************************** */
  
  _buildUpdateEventForm: function(event)
  {
      var form ={}; 
      form.pk = this.getDataForm();
      form.pk.start_date = event.start.format($.app.mc.momentUkDateFormat); 
      form.pk.start_time = event.start.format($.app.mc.momentUkTimeFormat); 
      form.pk.end_date = event.end.format($.app.mc.momentUkDateFormat); 
      form.pk.end_time = event.end.format($.app.mc.momentUkTimeFormat); 
      form.pk.ee_id = event.event_entry_id;    
      return form; 
  }, 

  /* ********************************************************** */
  eventResize:function(event, delta, revertFunc, jsEvent, ui, view )
  {

    event.end.add(event.end._data);     
    var form = this._buildUpdateEventForm(event); 

    
    $.ajax({
              type: "POST",
              url: $.app.mc.updateEventUri,
              data: form,
              success: function(data, textStatus, jqXHR){return $.app.cal._updateEvent( data, textStatus, jqXHR,revertFunc)},
              dataType: 'JSON'
            });
  },
   /* ********************************************************** */
  resetFields: function()
    {
        $('#span-event-title').html('') 
        $('#span-event-description').html('');
        $('#span-event-date').html(''); 
        $('#span-event-from').html(''); 
        $('#span-event-to').html(''); 

         $('#span-event-create').html('');
         $('#span-event-create-date').html('');
    }, 
  /* ********************************************************** */
  eventClick:function(event, jsEvent, view)
    {
        
        this.currentEvent = event;  
        $('#span-event-title').editable('destroy');
        $('#span-event-description').editable('destroy');
        $('#span-event-calendar').editable('destroy'); 

        $('#span-event-title').html(event.title); 
        $('#span-event-description').html(event.description);
        $('#span-event-date').html(moment(event.start).format('L')); 
        $('#span-event-from').html(moment(event.start).format('HH:mm')); 
        $('#span-event-to').html(moment(event.end).format('HH:mm')); 

         $('#span-event-create').html(event.create_name);
         $('#span-event-create-date').html(event.created_at);
         
         if (event.editable)
            $('#delete-button').show();
         else 
            $('#delete-button').hide();
          
        
        
        var form = this._buildUpdateEventForm(event).pk; 
           $('#span-event-title').editable({
              type: 'text',
              value: event.title, 
              pk: form,
              name:'title',
              placement:'bottom', 
              url: $.app.mc.updateEventUri,
              title: 'Event title',
              disabled: ! (event.editable),
              success: function(response, newValue) {
                  $('#full-calendar').fullCalendar('refetchEvents'); 
              }
          });
           $('#span-event-description').editable({
              type: 'textarea',
              value: event.event_entry_description, 
              pk: form,
              name:'description',
              placement:'bottom',
              url: $.app.mc.updateEventUri,
              disabled: ! (event.editable),
              title: 'Event description',
              success: function(response, newValue) {
                  $('#full-calendar').fullCalendar('refetchEvents'); 
                 
              }
          });
           $('#span-event-calendar').editable({
              type: 'select',
              value: event.cal_id, 
              pk: form,
              source: function()
              {
                  var a = [];
                  for (var i =0 ; i < $.app.mc.myCalendars.length ; i++ )
                    a.push({'value': $.app.mc.myCalendars[i].calendar_id , 'text':$.app.mc.myCalendars[i].calendar_title }); 
                  return a; 
              },
              name:'calendar_id',
              placement:'bottom',
              url: $.app.mc.updateEventUri,
              disabled: ! (event.editable),
              title: 'Event Calendar',
              success: function(response, newValue) {
                    $.app.cal._eventClick(response, newValue)
              
              }
          });
           $('#span-event-project').editable({
              type: 'select',
              value: event.project_id, 
              pk: form,
              source: function()
              {
                  var a = [];
                  for (var i =0 ; i < $.app.mc.myProjects.length ; i++ )
                    a.push({'value': $.app.mc.myProjects[i].project_id , 'text':$.app.mc.myProjects[i].project_title }); 
                  return a; 
              },
              name:'project_id',
              placement:'bottom',
              url: $.app.mc.updateEventUri,
              disabled: ! (event.editable),
              title: 'Event Project',
              success: function(response, newValue) {
                    $.app.cal._eventClick(response, newValue)
              }
            });
           

             $('#span-event-date').editable({
                    type:'date',
                    placement:'bottom',  
                    format: 'yyyy-mm-dd', 
                    url: $.app.mc.updateEventUri,
                    disabled: true, //! (event.editable),   
                    viewformat: 'dd/mm/yyyy',   
                    success: function(response, newValue) {
                       $.app.cal._eventClick(response, newValue)
                    },  
                    datepicker: {
                        weekStart: 1
                    }
              });

        
        $('#eventShowModal').modal(); 
        
        
    },
    /* ********************************************************** */
    
    /* ********************************************************** */
    _eventClick:function(response , newValue )
    {
           response = jQuery.parseJSON( response );
            if (response.error)
            {
              var title = 'There is a problem: ';
              var message = ''; 
              for(var i=0 ; i < response.message.length ; i++)
                  message += response.message[i] + '  '; 
              
              $('#spanShowResponse').css('color','#990000'); 
              $('#spanShowTitle').html(title); 
              $('#spanShowResponse').html(message); 
            }
            else 
                $('#full-calendar').fullCalendar('refetchEvents'); 

            return true; 
            
    }, 
    /* ********************************************************** */ 
    createEvent: function ()
    {
           var values = {};
            $.each($('#frmBookingForm').serializeArray(), function(i, field) {
                values[field.name] = field.value;
               
            });
          $.ajax({
              type: "POST",
              url: $.app.mc.createEventUri,
              data: values,
              success: function(data, textStatus, jqXHR){return $.app.cal._createEvent( data, textStatus, jqXHR)},
              dataType: 'JSON'
            });
    } ,
/* ********************************************************** */
  _createEvent: function ( data, textStatus, jqXHR)
  {
    var response = '';
    var title = ''; 

    if (data.error)
    {
      title = 'There is a problem: ';
      for(var i=0 ; i < data.message.length ; i++)
        response += data.message[i] + '  '; 
        $('#spanResponse').css('color','#990000'); 
      
    }
    if (! data.error)
    { 
        $('#eventModal').modal('hide');   
        $('#full-calendar').fullCalendar('renderEvent', data.message); 
        response = 'Event updated.'; 
    } 
    $('#spanTitle').html(title);  
    $('#spanResponse').html(response); 
  },
  /* ********************************************************** */
  _updateEvent: function ( data, textStatus, jqXHR,revertFunc)
  {
    var type= 'success'; 
    var message = '';
    for(var i =0 ; i < data.message.length ; i++)
        message += data.message[i]; 

    if (data.error)
    {
        type = 'danger'
        revertFunc(); 
    }  
    else 
        message = 'Event updated'; 
        $.bootstrapGrowl(message , {'type':type}, 1000 );
                
  },
/* ********************************************************** */
 
  drop:function(date, jsEvent, ui, resourceId , that)
  {
    

  },
  /* ********************************************************** */

  
  /* ********************************************************** */
  _popoverDiv:function(event)
  {
      var div = ''; 
      var start =moment(event.start).format('LT'); 
      var end = moment(event.end).format('LT'); 
      var date = moment(event.start).format('LL')
      div += '<div class="popover">'; 
      div += '<h3 class="popover-title">'; 
      div +=  date; 
      div +=  ' ' + start + ' to ' + end; 
      div += '</h3>'; 
      div += '<div class="popover-content">'; 
      div += '<h4>' + event.title +'</h4>';
      
      div +=  'From: ' + start;
      div += ' to: '+ end ; 
      div += '<br />'; 
      div += event.calendar_title; 
      div += '<br/>'; 
      div += event.project_collection_title; 
      div += '<hr>'; 
      div += '<font size="0.9em">'; 
      div += 'Created by ' + event.create_name + ' on ' + event.created_at; 
      div += '</font>'; 
      div += '</div>'; 
      div += '</div>'; 

      return div; 

  }

/* ********************************************************** */
  
}; 



$.app.cal = new AppPackageCalendar();  


/* ********************************************************** */    

