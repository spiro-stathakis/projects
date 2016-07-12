

function admin() {
}

admin.prototype = {   
   
    currentRecord:{}, 
    init:function () { 
          
    }, 
    

    getDataForm:function(){
      return {
            '_csrf' : $.app.mc.csrfToken 
          };
    } ,
    /* #################################################################### */  
    ldapSearchUser:function()
    {
        var form = this.getDataForm();
        form.user_name = $('#searchUser').val(); 
        $.ajax({
            url: $.app.mc.ldapSearchUserUri,
            type: 'post',
            data: form,
            success: function (data) {
                //data = jQuery.parseJSON(data);
               

                if (data.message.count > 0)    
                {
                    $('#span_first_name').html(data.message.data.first_name);
                    $('#span_last_name').html(data.message.data.last_name);
                    $('#span_email').html(data.message.data.email);
                    $('#div-display-user').show(); 
                    $.extend(true, $.app.page.currentRecord,data.message.data,form); 
                }
            }, 
            dataType: 'json'

        });


    }, 

    /* #################################################################### */
    createUser:function()
    {
        var form = {'User':$.app.page.currentRecord}; 
        $.ajax({
            url: $.app.mc.createUserUri,
            type: 'post',
            data: form,
            success: function (data) {
                var type = 'success'
                if (data.error)
                    type= 'danger'
                for(var i=0 ; i < data.message.length ; i++)
                    $.bootstrapGrowl(data.message[i] , {'type':type}, 1000 );
                
            }, 
            dataType: 'json'

        });
        

    } 
/* #################################################################### */


}; 




   
$.app.page = new admin();
 







