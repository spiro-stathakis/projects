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
		
    }
/* ********************************************************** */    
    eventCreate
/* ********************************************************** */    
    
/* ********************************************************** */
   

/* ********************************************************** */
/* ********************************************************** */
/* ********************************************************** */

/* ********************************************************** */
}; 



$.app.cal = new AppPackageCalendar();  


/* ********************************************************** */    
