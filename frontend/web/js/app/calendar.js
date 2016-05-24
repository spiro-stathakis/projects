function AppPackageCalendar() {
}



/* ********************************************************** */    

AppPackageCalendar.prototype = {
    delayed:false, // whether to load on start
    selectedDate:0, 
    selectedTime:0, 
    
  /* ********************************************************** */    
    
    init:function() { //default function
        $('#tree').treeview({
            showCheckbox:true, 
            data: $.app.mc.tree,
            highlightSelected: false, 
            levels:0, 
            onNodeChecked: function(event, data) {
              $.app.cal.calendarToggle(data); 
            },
            onNodeUnchecked: function(event, data) {
              $.app.cal.calendarToggle(data); 
            }
        });
        return true;

    	// do some init like set the fields to an initial value

    }, 
  /* ********************************************************** */  
    calendarToggle:function(data){
          console.info(data); 
    },
  /* ********************************************************** */  
    getTree: function()
    {
    return   [
      {
        text: "Parent 1",
              nodes: [
            {
              text: "Child 1",
              nodes: [
                {
                  text: "Grandchild 1"
                },
                {
                  text: "Grandchild 2"
                }
              ]
            },
            {
              text: "Child 2"
            }
          ]
        },
        {
          text: "Parent 2"
        },
        {
          text: "Parent 3"
        },
        {
          text: "Parent 4"
        },
        {
          text: "Parent 5"
        }
      ];
    },  
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

