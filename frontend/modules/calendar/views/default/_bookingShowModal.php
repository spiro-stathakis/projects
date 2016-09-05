
<!-- Modal -->
<div class="modal fade" id="eventShowModal" tabindex="-1" role="dialog" aria-labelledby="eventShowModalLabel">
  <div class="modal-dialog large" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="eventShowModalLabel">Show booking</h4>
      </div>
      <div class="modal-body">
        <?= $this->render('_bookingShow', []); ?>
      </div>
      <div class="modal-footer">
        <span id="spanShowTitle" style="float:left; text-align:left"></span>
        <span id="spanShowResponse" style="float:left; text-align:left"></span>
        <button type="button" class="btn btn-default" id="delete-button">Delete</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
       
      </div>
    </div>
  </div>
</div>