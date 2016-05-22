
<!-- Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel">
  <div class="modal-dialog large" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="eventModalLabel">New booking</h4>
      </div>
      <div class="modal-body">
        <?= $this->render('_bookingForm', [
        'model' => $model,
          ]) ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-event-create" onclick="js:$.app.cal.createEvent();">Save changes</button>
      </div>
    </div>
  </div>
</div>