<div id="confirmExperimentDeleteDialog" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form id="deleteForm" action="/experiment/delete" method="post">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Delete Experiment - <?php echo $experiment->name ?> </h3>
  </div>
  <!--
  <div class="modal-body">
  	
  </div>
  -->
  <div class="modal-footer">
  	<button type="submit" class="btn">OK</button>
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
  </div>
  <input type="hidden" name="id" value="<?php echo $experiment->id ?>" />
  </form>
</div>