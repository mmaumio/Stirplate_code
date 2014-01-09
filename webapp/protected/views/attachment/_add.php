
<!-- Modal -->
<div id="addAttachmentModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Add Attachment</h3>
  </div>
  <div class="modal-body">
  	<h3>Tip: You can shift-click to choose multiple files</h3>
  <form id="newForm" action="/attachment/create" method="post">
  <fieldset>
    <input type="dropbox-chooser" name="selectedFile" id="db-chooser" data-multiselect="true" style="float:right;font-size:25px;margin: 10px;"/>
    <div id="input_data" style="display:none"></div>
    
	<input type="hidden" name="studyId" value="<?php echo $study->id ?>" />
	<input type="hidden" name="projectId" value="<?php echo $project->id ?>" />
  <?php if (isset($experiment)) { ?>
  <input type="hidden" name="experimentId" value="<?php echo $experiment->id ?>"/>
  <?php } ?>
  </fieldset>
    
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
  </div>
  </form>
  
</div>