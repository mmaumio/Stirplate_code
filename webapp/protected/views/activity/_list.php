			<!--<div class="row-fluid">-->


				<div class="span9 discussions pull-left" style="margin-left:0">
					<div class="activity-post">

					<div class="divide"></div>
					<div class="spacer"></div>
					<h3>Activity Stream</h3>
					<ul>
						<form action="/activity/create" id="newCommentForm" method="POST">
							<input type="hidden" name="activity[studyId]" value="<?php echo $study->id ?>">
							<input type="hidden" name="activity[type]" value="comment">
							<?php if (!empty($experiment)) { ?>
							<input type="hidden" name="activity[relatedObjectId]" value="<?php echo $experiment->id ?>">
							<input type="hidden" name="activity[relatedObjectType]" value="experiment">
							<?php } else if (!empty($project)) { ?>
							<input type="hidden" name="activity[relatedObjectId]" value="<?php echo $project->id ?>">
							<input type="hidden" name="activity[relatedObjectType]" value="project">
							<?php } ?>
							<textarea id="newComment" name="activity[content]" class="diss-form" placeholder="Add comment here" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 40px;" required=""></textarea>
							<div class="clear"></div>
							<!--
							<div class="attachment-post">
							<i class="icon-paper-clip"></i><i class="icon-globe"></i><i class="icon-bar-chart"></i>
							</div>
							-->
							<button class="btn btn-success" type="submit" style="float:right" id="submitCommentBtn">Submit Comment</button>
						</form>
					</ul>
					<div class="clear"></div>
					<div class="divide"></div>
					</div>

					<ul id="activityStream">
						
						<?php if (isset($study->activities) && count($study->activities) > 0) { ?>
							<?php $replies = array(); ?>
							<?php foreach ($study->activities as $activity) { ?>

								<?php 
									$isStudy = !isset($project) && !isset($experiment);
									$projectMatch = isset($project) && $activity->relatedObjectType === 'project' && $activity->relatedObjectId === $project->id;
									$experimentMatch = isset($experiment) && $activity->relatedObjectType === 'experiment' && $activity->relatedObjectId === $experiment->id;
									if ($activity->type !== 'event' && ($isStudy || $projectMatch || $experimentMatch)) {
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
											$this->renderPartial('//activity/_comment', array('study' => $study, 'project' => isset($project) ? $project : null, 'experiment' => isset($experiment) ? $experiment : null, 'activity' => $activity, 'replies' => $replies));
										} 
									}
								?>


							<?php } ?>

						<?php } ?>
						
					</ul>	
					
				</div>
			
			<!--</div>	-->

<script>
	$(document).ready(function() {

		$(document).on('click', '.deleteActivity', function(e) {
			var activity = {},
				row = $(this);
			activity.activityId = $(this).attr('activityId');

			if (activity.activityId) {
				$.post('/activity/ajaxDelete', activity, function(data, textStatus, jqXHR) {
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

		    $.post('/activity/ajaxCreate', activity, function(data, textStatus, jqXHR) {
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

		    $.post('/activity/ajaxCreate', activity, function(data, textStatus, jqXHR) {
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