<div id="confirmAttachmentDeleteDialog<?php echo $attachment->id ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form id="deleteForm" action="/attachment/delete" method="post" style="margin-bottom:0">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3>Remove the file <?php echo $attachment->name ?> from the project?</h3>
    <p>
    	This does not delete the file from dropbox, it only removes it from OmniScience
    </p>
  </div>
  <!--
  <div class="modal-body"></div>
  -->
  <div class="modal-footer">
  	<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
  	<button type="submit" class="btn btn-danger">Delete</button>
  </div>
  <input type="hidden" name="id" value="<?php echo $attachment->id ?>" />
  </form>
</div>