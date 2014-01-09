<div id="confirmStudyDeleteDialog<?php echo $study->id ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form id="deleteForm" action="/study/delete" method="post" style="margin-bottom:0">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3>Delete Study - <?php echo $study->title ?>?</h3>
  </div>
  <!--
  <div class="modal-body"></div>
  -->
  <div class="modal-footer">
  	<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
  	<button type="submit" class="btn btn-danger">Delete</button>
  </div>
  <input type="hidden" name="id" value="<?php echo $study->id ?>" />
  </form>
</div>