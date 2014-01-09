<!-- Modal -->
<!--<div id="newTaskModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">-->
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel"><?php echo $task->subject ?></h3>
  </div>
  <div class="modal-body">
  	<form class="form-horizontal">
    <div>&nbsp;</div>
    <fieldset>

    <!-- Text input-->
    <div class="control-group">
      <label class="control-label" for="task_subject">Task</label>
      <div class="controls">
        <input id="task_subject" type="text" value="<?php echo $task->subject ?>" class="input-xlarge" readonly>
      </div>
    </div>

    <!-- Textarea -->
    <div class="control-group">
      <label class="control-label" for="task_description">Task Details</label>
      <div class="controls">                     
        <textarea id="task_description" class="input-xlarge" readonly><?php echo $task->description ?></textarea>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="task_assigned">Assigned To</label>
      <div class="controls">                     
        <a href="/user/index/<?php echo $task->assigneeId?>"><img src="<?php echo $task->assignedToUser->getUserImage() ?>"></a>
        <a href="/user/index/<?php echo $task->assigneeId?>"><?php echo $task->assignedToUser->getName(); ?></a>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="task_created">Created By</label>
      <div class="controls">                     
        <a href="/user/index/<?php echo $task->ownerId ?>"><img src="<?php echo $task->createdByUser->getUserImage() ?>"></a>
        <a href="/user/index/<?php echo $task->ownerId ?>"><?php echo $task->createdByUser->getName(); ?></a>
      </div>
    </div>

    </fieldset>
	</form>
    
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
    <?php if (Yii::app()->user->id == $task->assigneeId) { ?>
    <button class="btn btn-primary" id="completeTaskBtn" taskId="<?php echo $task->id ?>">Mark as Complete</button>
    <?php } ?>
  </div>
  
<!--</div>-->


