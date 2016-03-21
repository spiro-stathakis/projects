

function select2() {
}

select2.prototype = {   
    
    searchUri:'', 
    addUri:'', 
    removeUri:'', 
     
    init:function () { 
            
         this.searchUri = $.app.mc.searchUri; 
        
         $(document).ready(function() {
  				$($.app.mc.targetId).select2({
					theme: "classic",
					ajax: {
    					url: $.app.mc.searchUri,
    				}
  				})
				.on("select2:select", function(e) {
          				return $.app.page.addRecord(e);
          		})
        		.on("select2:unselect", function(e) {
          				return $.app.page.removeRecord(e);
        		}); // end ajax 
		});   // end jquery
        

         
    }, 
    
    /* **************************************************** */ 
    addRecord:function(e)
    {
    		var formData = {id:e.params.data.id, col:$.app.mc.collectionId,mem:$.app.mc.memberType }; 
    		$.ajax({
  				type: "POST",
  				url: $.app.mc.addUri,
  				data: formData,
  				success: function(){},
  				dataType: 'JSON'
			});
    		
    }, 
    /* **************************************************** */ 
    removeRecord:function(e)
    {
			var formData = {id:e.params.data.id, col:$.app.mc.collectionId,mem:$.app.mc.memberType }; 
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
 







