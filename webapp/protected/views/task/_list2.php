<div class="span3 tasks" style="float:right;">
	<h3 style="float:left;">Tasks</h3>
	<span>
		<a href="#newTaskModal" role="button" class="btn icon-plus" data-toggle="modal" style="padding:7px;float:right;"></a>
	</span>
	<div class="clear"></div>
	<ul id="taskList" style="margin-left:0">
    <?php if (isset($tasks) && count($tasks) > 0) { ?>
      <?php foreach ($tasks as $task) { ?>
        <li id="taskRow_<?php echo $task->id ?>">
          <a href="/user/publicProfile/<?php echo $task->assigneeId ?>"><img src="<?php echo $task->assignedToUser->getUserImage() ?>"></a>
          <span><?php echo CHtml::link($task->subject, '#', array('objId' => $task->id, 'data-toggle' => 'modal', 'class' => 'omnitasks')); ?></span>
          <div class="clear"></div>
        </li>
      <?php } ?>
    <?php } ?>
	</ul>
</div>

<!-- Modal -->
<div id="newTaskModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Add Task</h3>
  </div>
  <div class="modal-body">
    <form class="form-horizontal" id="newTaskForm">
      <input type="hidden" name="task[studyId]" value="<?php echo $study->id ?>">
      <?php if (isset($project)) { ?>
      <input type="hidden" name="task[relatedObjectId]" value="<?php echo $project->id ?>">
      <input type="hidden" name="task[relatedObjectType]" value="project">
      <?php } ?>
    <div>&nbsp;</div>
    <fieldset>

    <!-- Text input-->
    <div class="control-group">
      <label class="control-label" for="task_subject">Task</label>
      <div class="controls">
        <input id="task_subject" name="task[subject]" placeholder="Enter a task summary" class="input-xlarge" required="" type="text">
      </div>
    </div>

    <!-- Textarea -->
    <div class="control-group">
      <label class="control-label" for="task_description">Task Details</label>
      <div class="controls">                     
        <textarea id="task_description" name="task[description]"></textarea>
      </div>
    </div>

    <!-- Select Basic -->
    <div class="control-group">
      <label class="control-label" for="task_assignee">Assignee</label>
      <div class="controls">
        <select id="task_assignee" name="task[assigneeId]" class="input-xlarge" required="">
          <option value="">---</option>
          <?php foreach ($study->members as $member) { ?>
          <option value="<?php echo $member->userId ?>"><?php echo $member->user->getName(); ?></option>
          <?php } ?>
        </select>
      </div>
    </div>

    </fieldset>
    
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
    <button class="btn btn-primary" id="saveTaskBtn">Save Task</button>
    </form>
  </div>
  
</div>

<script>

  $('#saveTaskBtn').on('click', function(ev) {
    ev.preventDefault();

    var formElements = $('#newTaskForm').serializeArray(),
        task = {};

    for (var el in formElements) {
      task[formElements[el].name] = formElements[el].value;
    }

    $.post('/task/ajaxCreate', task, function(data, textStatus, jqXHR) {
      if (data.status === 'OK') {
        var appendHtml = '<li>'

        appendHtml += '<a href=/user/publicProfile/"' + data.id + '">';
        appendHtml += '<img src="' + data.task.assigneeImgUrl + '">';
        appendHtml += '</a>';

        appendHtml += '<span>';
        //appendHtml += '<a href="/task/view/' + data.id + '" taskId="' + data.id + '" data-toggle="modal">' + data.task.subject + '</a>';
        appendHtml += '<a objId="' + data.id + '" data-toggle="modal" class="omnitasks">' + data.task.subject + '</a>';

        appendHtml += '</span>';

        appendHtml += '</li>';

        $('#taskList').append(appendHtml);
      }
    },'json');

    $('#newTaskModal').modal('hide');

  });

  $(document).on('click', '.omnitasks', function(e) {
    e.preventDefault();
    var url = '/task/view/' + $(this).attr('objId');
    if (url.indexOf('#') == 0) {
      $(url).modal('open');
    } else {
      $.get(url, function(data) {
        if ($('#viewTaskModal').length) {
          $('#viewTaskModal').html(data).modal('show');
        } else {
          $('<div class="modal hide fade" id="viewTaskModal">' + data + '</div>').modal();
        }
      }).success(function() { $('input:text:visible:first').focus(); });
    }
  });

  $(document).on('click', '#completeTaskBtn', function() {
    $.get('/task/ajaxComplete/' + $(this).attr('taskId'), function(resp) {
      if (resp.status === 'OK') {
        $('#viewTaskModal').modal('hide');
        $('#taskRow_' + resp.id).hide();
      }
    });

  });

</script>
