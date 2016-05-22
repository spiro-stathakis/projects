function AppPackageCalendar() {
}



/* ********************************************************** */    

AppPackageCalendar.prototype = {
    delayed:false, // whether to load on start
    selectedDate:0, 
    selectedTime:0, 

    init:function() { //default function
        moment.locale("en-gb");
        this.initCalendarSelector(); 
        return true;

    	// do some init like set the fields to an initial value

    }, 
/* ********************************************************** */    
    dayClick:function(date, jsEvent, view)
    {
        this.selectedDate = date.format('L');
        this.selectedTime = date.format('LT')
        //$('#start_date').datetimepicker('date' , this.selectedDate);
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

            $('#calendar-selector').html('hello there'); 
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
              url: $.app.mc.aa,
              data: data,
              success: success,
              dataType: dataType
            });
    } 
/* ********************************************************** */
/* ********************************************************** */

/* ********************************************************** */
}; 



$.app.cal = new AppPackageCalendar();  


/* ********************************************************** */    

