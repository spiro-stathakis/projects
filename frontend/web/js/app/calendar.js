function AppPackageCalendar() {
}



/* ********************************************************** */    

AppPackageCalendar.prototype = {
    delayed:false, // whether to load on start
    selectedDate:0, 
    selectedTime:0, 
    calId:0, 
  /* ********************************************************** */    
    
    init:function() { //default function
       

      
       /*** set up calendar - project relationship ******/ 
        $('#calendar_id').change(function(){
            var cal_id=$(this).val();  
            var project_option = false; 
              for (var i =0 ; i<$.app.mc.myCalendars.length ; i++ )
                  if (cal_id == $.app.mc.myCalendars[i].calendar_id)        
                      if ($.app.mc.myCalendars[i].project_option_id == $.app.mc.types_boolean.true)
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
    getDataForm:function(){
      return {
            '_csrf' : $.app.mc.csrfToken 
          };
    } ,
  
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
    eventClick:function(event, jsEvent, view)
    {
        
        $('#span-event-title').val(event.title); 
        $('#span-event-description').val(event.description); 
        $('#eventShowModal').modal(); 
        
        
    },
/* ********************************************************** */    
    eventMouseover:function(date, jsEvent, view)
    {
     
    // console.info(moment(date._i).calendar()); 
        //$('#eventModal').modal(); 
        
    },
/* ********************************************************** */
  

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
              success: function(data, textStatus, jqXHR){return $.app.cal.processCreateEvent( data, textStatus, jqXHR)},
              dataType: 'JSON'
            });
    } ,
/* ********************************************************** */
  processCreateEvent: function ( data, textStatus, jqXHR)
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
  }
/* ********************************************************** */

/* ********************************************************** */
}; 



$.app.cal = new AppPackageCalendar();  


/* ********************************************************** */    

