function AppPackageCalendar() {
}



/* ********************************************************** */    

AppPackageCalendar.prototype = {
    delayed:false, // whether to load on start
  
    init:function() { //default function
    	return true; 
    	// do some init like set the fields to an initial value

    }, 
/* ********************************************************** */    
    dayClick:function(date, jsEvent, view)
    {
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
     
     console.info(moment(date._start._i).calendar()); 
        //$('#eventModal').modal(); 
        
    },
/* ********************************************************** */
   

/* ********************************************************** */
/* ********************************************************** */
/* ********************************************************** */

/* ********************************************************** */
}; 



$.app.cal = new AppPackageCalendar();  


/* ********************************************************** */    

