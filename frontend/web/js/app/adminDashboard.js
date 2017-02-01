

function adminDashboard() {
}

adminDashboard.prototype = {   
   
    init:function () { 
          
               

            
    }, 
    

    getDataForm:function(){
      return {
            '_csrf' : $.app.mc.csrfToken 
          };
    } ,
    /* #################################################################### */  
   
    /* #################################################################### */
    
    /* #################################################################### */


}; 




   
$.app.page = new adminDashboard();
 







