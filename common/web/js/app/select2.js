

function select2() {
}

select2.prototype = {   
    
    searchUri:'', 
    addUri:'', 
    removeUri:'', 
     
    init:function () { 
            
         this.searchUri = $.app.mc.searchUri; 
        
         $(document).ready(function() {
  				

          $($.app.mc.memberTargetId).select2({
					theme: "classic",
					ajax: {
    					url: $.app.mc.searchUri,
    				}
  				})
				.on("select2:select", function(e) {
          				return $.app.page.addRecord(e,$.app.mc.memberType);
          		})
        		.on("select2:unselect", function(e) {
          				return $.app.page.removeRecord(e,$.app.mc.memberType);
        		}); // end ajax 
            $($.app.mc.managerTargetId).select2({
          theme: "classic",
          ajax: {
              url: $.app.mc.searchUri,
            }
          })
        .on("select2:select", function(e) {
                  return $.app.page.addRecord(e,$.app.mc.managerType);
              })
            .on("select2:unselect", function(e) {
                  return $.app.page.removeRecord(e,$.app.mc.managerType);
            }); // end ajax 
		});   // end jquery
        

         
    }, 
    
    /* **************************************************** */ 
    addRecord:function(e,type)
    {
    		var formData = {
                        id:e.params.data.id, 
                        col:$.app.mc.collectionId,
                        mem:type,
                        _csrf:$.app.mc.csrfToken 
                      }; 
    		$.ajax({
  				type: "POST",
  				url: $.app.mc.addUri,
  				data: formData,
  				success: function(){},
  				dataType: 'JSON'
			});
    		
    }, 
    /* **************************************************** */ 
    removeRecord:function(e,type)
    {
			var formData = {
                      id:e.params.data.id, 
                      col:$.app.mc.collectionId,
                      mem:type,
                      _csrf:$.app.mc.csrfToken 
                    }; 
    		$.ajax({
  				type: "POST",
  				url: $.app.mc.removeUri,
  				data: formData,
  				success: function(){},
  				dataType: 'JSON'
			});

    }
	/* **************************************************** */ 
    
}; 




   
$.app.page = new select2();
 







