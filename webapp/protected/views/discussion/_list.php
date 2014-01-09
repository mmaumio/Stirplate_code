<h2>Discussions</h2>

	<div class="span12 discussions pull-left" style="margin-left:0">
		<div class="activity-post">
			<form action="/activity/create" id="newCommentForm" method="POST">
				<input type="hidden" name="activity[projectId]" value="<?php echo $project->id ?>">
				<input type="hidden" name="activity[type]" value="comment">
				<textarea id="newComment" name="activity[content]" class="diss-form" placeholder="Add comment here" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 40px;" required=""></textarea>
				<div class="clear"></div>
				<button class="btn btn-primary" type="submit" style="float:right" id="submitCommentBtn">Submit Comment</button>
			</form>
		
		<div class="clear"></div>
		<div class="divide"></div>
		</div>

		<ul id="activityStream">
			
			<?php if (isset($project->discussions) && count($project->discussions) > 0) { ?>
				<?php $replies = array(); ?>
				<?php foreach ($project->discussions as $activity) { ?>

					<?php 
						
						if ($activity->type !== 'event') {
							if (!empty($activity->parentActivityId)) 
							{
								// this comment is a reply, so don't show it, but add it to the replies array

								if (!isset($replies[$activity->parentActivityId]))
								{
									$replies[$activity->parentActivityId] = array();
								}

								array_unshift($replies[$activity->parentActivityId], $activity);

							} 
							else
							{
								// just a regular comment, so render to the screen
								$this->renderPartial('//discussion/_comment', array('project' => $project,  'activity' => $activity, 'replies' => $replies));
							} 
						}
					?>


				<?php } ?>

			<?php } ?>
			
		</ul>	
		
	</div>

<script>
	$(document).ready(function() {

		$(document).on('click', '.deleteActivity', function(e) {
			var activity = {},
				row = $(this);
			activity.activityId = $(this).attr('activityId');

			if (activity.activityId) {
				$.post('/discussion/ajaxDelete', activity, function(data, textStatus, jqXHR) {
	      			if (data.status === 'OK') {	      				
	      				row.parent().parent().hide();
	      			} else {
	      			}
	      		});
			}
		});

		$(document).on('click', '.activityReplyLink', function(e) {
			e.preventDefault();
			$(this).parent().hide();
			$(this).parent().next().next().show();
			return false;
		});

		$(document).on('click', '.activityReplyCancel', function(e) {
			e.preventDefault();
			$(this).parent().parent().parent().parent().hide();
			$(this).parent().parent().parent().parent().prev().prev().show();
			return false;
		});

		$(document).on('click', '.activityReplySubmit', function(e) {
			e.preventDefault();

			var formElements = $(this).parent().parent().serializeArray(),
        		activity = {},
        		button = $(this);


		    for (var el in formElements) {
		    	if (formElements[el].name == 'activity[content]' && formElements[el].value =='') {
		    		alert("Please enter a reply");
		    		return false;
		    	}
				activity[formElements[el].name] = formElements[el].value;
		    }

		    if (activity['content'] == '') return false;

		    $.post('/discussion/ajaxCreate', activity, function(data, textStatus, jqXHR) {
      			if (data.status === 'OK') {
      				$('#replies_' + data.parentId).append(data.html);
      				button.prev().prev().val('');
      			} else {
      				//console.log("error = ", data);
      			}
      		});

			return false;
		});

		$('#submitCommentBtn').on('click', function(e) {
			e.preventDefault();

    		var formElements = $('#newCommentForm').serializeArray(),
        		activity = {};

		    for (var el in formElements) {
		    	if (formElements[el].name == 'activity[content]' && formElements[el].value =='') {
		    		alert("Please enter a comment");
		    		return false;
		    	}
		     	activity[formElements[el].name] = formElements[el].value;
		    }

		    $.post('/discussion/ajaxCreate', activity, function(data, textStatus, jqXHR) {
      			if (data.status === 'OK') {
      				$('#activityStream').prepend(data.html);
      				$('#newComment').val('');

      			} else {
      				console.log("error = ", data);
      			}
      		});
		});
	});
</script>