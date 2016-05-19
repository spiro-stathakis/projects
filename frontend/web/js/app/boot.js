$.app = {
    page:undefined,
    mc:undefined, 
    objList:{}, 
    arrList:[], 
    hexRed:'#C83025',
    hexGreen:'#009933',
    hexAmber:'#FFBF00', 
    hexGrey:'#C0C0C0',
    
    init:function () 
    {
         if ($.app.page !== undefined) 
        {       
    
            // Flag, to check if the page javascript component of the app has been loaded. 
            // the bootcode for this resides in //layouts/_javascript.php
            // Spi April 25  20014      
            if (!$.app.page.delayed) // Flag, in case you don't need to load file on start
                $.app.page.init.call($.app.page);
        }
        if ($.app.cal !== undefined)
        {
             if (!$.app.cal.delayed) 
                $.app.cal.init.call($.app.cal);
        }


    },
    /* ********************************************************** */

	resizeName:function () {
		
	},    
    /* ********************************************************** */

    inString:function (str,substr,start)
    {    
	    var oStr = new String(str);
	    return oStr.indexOf(substr,start);
    }, 
    /* ********************************************************** */

    
    /* ********************************************************** */

    
    /* ********************************************************** */

    /* ********************************************************** */

    /* ********************************************************** */

    geoSuccess:function(position)
    {    
    	    		
    	  
    },
    /* ********************************************************** */

    objLength:function(obj){ 
    	/* function to validate the existence of each key in the object to get the number of valid keys. */
    	var size = 0;
    	for (key in obj){
    		if (obj.hasOwnProperty(key)) {
    			size++;
    		}
    	}
    	return size;
    },
    /* ********************************************************** */

    geoError:function() 
    {
    	alert('Geo location failure');
    },
    /* ********************************************************** */

    isFloat: function(n)
    {
    	return n === +n && n !== (n|0);

    }, 
    /* ********************************************************** */

    isInteger: function(n)
    {
    	return n === +n && n === (n|0);

    }, 
    /* ********************************************************** */

    svgSupport: function() {
    	return window.SVGSVGElement;
    }, 
    /* ********************************************************** */

    geoLocate:function()
    {
	    if (navigator.geolocation) 
	    {
	    	    navigator.geolocation.getCurrentPosition(this.geoSuccess, this.geoError);
	    	    
	    }
    }    
    /* ********************************************************** */

    
};

$(document).ready(function () { //jQuery ready event
    $.app.init();
});

