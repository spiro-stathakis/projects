

<div class="row">
            <div class="col-sm-7-offset col-sm-offset-1 col-md-8 col-md-offset-1 main">
              <?php echo $this->render('../default/_stepBar' , ['activeElement'=>5]);?> 
            </div>
</div>
<p>&nbsp; </p> 
<p>&nbsp; </p> 

<div class="row">
            <div class="col-sm-6-offset col-sm-offset-2 col-md-7 col-md-offset-2 main">
              <?php frontend\packages\SignatureAsset::register($this); ?> 
                <div style='padding-top:100px' id="signature-pad" class="m-signature-pad">
                    <div class="m-signature-pad--body">
                      <canvas></canvas>
                    </div>

                    <div class="m-signature-pad--footer">
                      
                      <div id="signature-text" class="description">
                        <h4>
                        Participant signature. Please stay within box boundary
                        </h4>
                      </div>
                     
                      <button type="button" class="button clear btn btn-primary" data-action="clear">Clear</button>
                      <button type="button" class="button save btn btn-primary" data-action="save">Save</button>
                    </div>
                  </div>
            </div>
</div>
  
