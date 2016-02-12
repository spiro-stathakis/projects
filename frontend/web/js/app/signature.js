

function signaturePad() {
}

signaturePad.prototype = {   
    wrapper: document.getElementById("signature-pad"),
    clearButton: '',
    saveButton:'',
    canvas:'',
    signaturePad:'', 
    signee:'subject',
    hash:'', 
    init:function () { 
            
            
            this.clearButton=this.wrapper.querySelector("[data-action=clear]");
            this.saveButton=$.app.page.wrapper.querySelector("[data-action=save]");
            this.canvas=$.app.page.wrapper.querySelector("canvas");
            

            window.onresize = $.app.page.resizeCanvas;
                $.app.page.resizeCanvas();
                $.app.page.signaturePad = new SignaturePad(this.canvas);
                $.app.page.clearButton.addEventListener("click", function (event) {
                $.app.page.signaturePad.clear();
            });

           this.saveButton.addEventListener("click", function (event) {
                if ($.app.page.signaturePad.isEmpty()) {
                    alert("Please provide signature first.");
                } else {
                    //window.open(signaturePad.toDataURL());
                  return  $.app.page.saveSignature();  
                }
            });


         
    }, 
    resizeCanvas:function()
    {

            var ratio =  Math.max(window.devicePixelRatio || 1, 1);
            $.app.page.canvas.width = $.app.page.canvas.offsetWidth * ratio;
            $.app.page.canvas.height = $.app.page.canvas.offsetHeight * ratio;
            $.app.page.canvas.getContext("2d").scale(ratio, ratio);
    }, 
    saveSignature:function()
    {


        var data = {}; 
        data.signature = this.signaturePad.toDataURL();
        data.signee = this.signee; 
        data.hash = this.hash;
        $.ajax({
              type: "POST",
              url: $.app.mc.signatureUri,
              data: data,
              success: function(){},
              dataType: 'json'
        });
        

        if (this.signee=='subject')
        {
            alert('Thank you - Please return device to the researcher.'); 
            document.getElementById('signature-text').innerHTML = '<h4>Researcher signature. Please stay within box boundary</h4>';
            this.signee = 'researcher';
            $.app.page.signaturePad.clear(); 
        }else
          window.location = $.app.mc.redirectUri;

         return true; 
       
       
    }




}; 




   
$.app.page = new signaturePad();
 







