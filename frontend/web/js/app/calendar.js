function AppPackageCalendar() {
}



/* ********************************************************** */    

AppPackageCalendar.prototype = {
    delayed:false, // whether to load on start
    selectedDate:0, 
    selectedTime:0, 
    getEventObject:function(event){
        return {
            'id':event.id, 
            'title':event.title, 
            'allDay':event.allDay, 
            'start':event.start, 
            'end':event.end,  
            'url':event.url, 
            'className':event.class  
        }; 

    }, 
  /* ********************************************************** */    
    
    init:function() { //default function
        this.initCalendarSelector(); 
        return true;

    	// do some init like set the fields to an initial value

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
        $('#eventModal').modal(); 
		
    }, 
/* ********************************************************** */    
    eventClick:function(date, jsEvent, view)
    {
        $('#eventModal').modal(); 
        
    },
/* ********************************************************** */    
    eventMouseover:function(date, jsEvent, view)
    {
     
     console.info(moment(date._i).calendar()); 
        //$('#eventModal').modal(); 
        
    },
/* ********************************************************** */
   initCalendarSelector: function()
   {
        if (document.getElementById('calendar-selector'))
        {
            $('#calendar-selector').html('Dim calendar boyo'); 
        }

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
      $('#spanTitle').html(title); 
    }
    if (! data.error)
    { 
        $('#eventModal').modal('hide');   
        $('#full-calendar').fullCalendar('renderEvent', data.message); 
    } 
     $('#spanResponse').html(response); 
  }
/* ********************************************************** */

/* ********************************************************** */
}; 



$.app.cal = new AppPackageCalendar();  


/* ********************************************************** */    

