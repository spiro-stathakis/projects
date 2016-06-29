function AppPackageCalendar() {
}



/* ********************************************************** */    

AppPackageCalendar.prototype = {
    delayed:false, // whether to load on start
    selectedDate:0, 
    selectedTime:0, 
    calId:0, 
    moment:moment(), 
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
        if ($.app.mc.allCalendars[i].cal_id == cal_id )
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
  eventClick:function(event, jsEvent, view)
    {
        
        $('#span-event-title').html(event.title); 
        $('#span-event-description').html(event.description); 
        var form = this._buildUpdateEventForm(event).pk; 

           $('#span-event-title').editable({
              type: 'text',
              value: event.title, 
              pk: form,
              name:'title',
              url: $.app.mc.updateEventUri,
              title: 'Event title',
              success: function(response, newValue) {
                  $('#full-calendar').fullCalendar('refetchEvents'); 
              }
          });


        $('#eventShowModal').modal(); 
        
        
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

