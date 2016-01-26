
<?php frontend\packages\SignatureAsset::register($this); ?> 

<h4> <?php echo Yii::t('app','Participant signature');?></h4> 


<div id="signature-pad" class="m-signature-pad">
    <div class="m-signature-pad--body">
      <canvas></canvas>
    </div>
    <div class="m-signature-pad--footer">
      <div class="description">Please stay within box boundary</div>
      <button type="button" class="button clear" data-action="clear">Clear</button>
      <button type="button" class="button save" data-action="save">Save</button>
    </div>
  </div>

  <script type='text/javascript'>


  </script>