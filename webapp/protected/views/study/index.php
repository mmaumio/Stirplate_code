			<ul class="breadcrumb" style="padding-left:0;margin-bottom:0">
			  <li><a href="/study/list">Studies</a> <span class="divider">/</span></li>
			  <li class="active"><?php echo $study->title ?></li> 
			</ul>
			<div class="row-fluid">
				<div class="span12 projects">
					<div class="row-fluid">
						<div id="editTitleContainer" class="span12" style="position:relative;">
							<?php if ($study->isAdmin()) { ?>
							<button type="submit" id="deleteStudyBtn" class="btn btn-danger" style="position:absolute;right:0px;margin-top:20px;">Delete</button>
							<?php } ?>
							<div id="editTitleTooltip"><i class="icon-info-sign"></i>&nbsp;Click to edit the title</div>
							<h1 id="studyTitle" contenteditable="true" onclick="$('#editTitleTooltip').hide();"><?php echo $study->title ?></h1>
						</div>
					</div>
					<div class="clear"></div>
					<div class="project-author">
						
						<?php 
							$studyCreated = new DateTime($study->created);
							$studyCreated->setTimeZone(new DateTimeZone('America/New_York'));
						?>

						<p>
							<?php if ($study->visibility === 'Private') { ?>
							<i class="icon-lock"></i> 
							<?php } ?>
							Started on <?php echo $studyCreated->format('M j, Y'); ?> by: 
							<?php foreach ($study->members as $member) { ?>
								<?php if ($member->role === 'admin') { ?>
									<?php echo CHtml::link($member->user->getName(), array('user/publicProfile', 'id' => $member->userId)); ?>
								<?php } ?>
							<?php } ?>
							<!-- <a href="/study/delete/<?php echo $study->id ?>" class="icon-trash" style="float:right;"></a> -->
							<!--<a href="#confirmStudyDeleteDialog" role="button" class="icon-trash" data-toggle="modal" style="float:right;"></a>-->
						<p>
					</div>
				</div>
			</div>

			<div class="row-fluid">
				<!-- project list -->
				<?php $this->renderPartial('//project/_list', array('study' => $study)); ?>

				<!-- collaborators -->
				<div class="span3 collaborators pull-right">
					<h3 style="float:left;">Collaborators</h3>
					<span>
						<a href="#addCollaboratorModal" role="button" class="btn icon-plus" data-toggle="modal" style="padding:7px;float:right;"></a>
					</span>
					<?php $this->renderPartial('_addCollaborator',array('study'=>$study, 'users' => $users)); ?>
					<div class="clear"></div>
					<ul>
						<?php if (!empty($study->users)) { ?>
							<?php foreach ($study->users as $user) { ?>
								<li>
									<a href="#"><img src="<?php echo $user->getUserImage() ?>"><?php echo CHtml::link($user->getName(), array('user/publicProfile', 'id' => $user->id)); ?>
									<?php if ($study->isAdmin() && $user->id != Yii::app()->user->id) { ?>
									<i class="icon-remove remove-collaborator" style="float:right;cursor:pointer;margin-top:12px;" studyId="<?php echo $study->id ?>" userId="<?php echo $user->id ?>"></i>
									<?php } ?>
								</li>
							<?php } ?>
						<?php } ?>
					</ul>
					
				</div>

				<!-- Task::start -->
				<?php $this->renderPartial('//task/_list2', array('tasks' => $tasks, 'study' => $study)); ?>
				<!-- Task::end -->

				<?php $this->renderPartial('//activity/_list', array('study'=>$study)); ?>

			</div>
			
<script type="text/javascript">
	$(document).ready(function() {
		$('#studyTitle').on('blur', function(e) {
			
			// Lose focus
			// We can save the study title
			$('#inputStudyTitle').val($('#studyTitle').text());
			$('#editTitleForm').submit();
			
	    	//alert('Updated Title:' + $('#studyTitle').text());
		});

		$('#deleteStudyBtn').on('click', function() {
			$('#confirmStudyDeleteDialog').modal();
		});

		$('.deleteProjectBtn').on('click', function() {
			//console.log($(this).attr('projectId'));
			//console.log($(this).attr('projectTitle'));
			$('#projectDeleteModalLabel').html('Confirm deletion of: ' + $(this).attr('projectTitle'));
			$('#deleteProjectForm').attr('action', '/project/delete/' + $(this).attr('projectId'));
			$('#confirmProjectDeleteDialog').modal();
		});

		$('.remove-collaborator').on('click', function() {

			var user = {},
				row = $(this).parent();

			user.id = $(this).attr('userId');
			user.studyId = $(this).attr('studyId');

			$.post('/collaboration/ajaxRemoveUser', user, function(data, textStatus, jqXHR) {
		      if (data.status === 'OK') {
		      	row.hide();
		      }
		    },'json');
		});

    	$('.activity.project').show();
    	$('.activity.experiment').hide();
	});

</script>

	<style>

		.replyForm {
			display:none;
		}

		.discussions ul li ul.discussion-replies {
			margin:0 0 0 50px;
		}

		.discussions ul li ul.discussion-replies .message {
			margin:15px -10px 0 50px;
		}

		.experiments {
			height:350px;
		}
		.collaborators, .experiments-add{
			background: white;
		padding: 1%;
		box-sizing: border-box;
		box-shadow: 1px 1px 1px gray;
		border-radius: 2px;
		-webkit-box-shadow: 0 1px 0 1px #e4e6eb;
		-moz-box-shadow: 0 1px 0 1px #e4e6eb;
		box-shadow: 0 1px 0 1px #e4e6eb;
		}
		.attachments, .tasks {
			float:right;
			background: white;
			padding: 1%;
			box-sizing: border-box;
			box-shadow: 1px 1px 1px gray;
			border-radius: 2px;
			-webkit-box-shadow: 0 1px 0 1px #e4e6eb;
			-moz-box-shadow: 0 1px 0 1px #e4e6eb;
			box-shadow: 0 1px 0 1px #e4e6eb;
			margin-bottom:3%;
		}
		.discussions a{
		color:#08c;
		}
		.discussions ul li {
		list-style: none;
		position:relative;
		-webkit-border-radius:2px;
		-moz-border-radius:2px;
		border-radius:2px;
		-webkit-box-shadow:0 1px 0 1px #e4e6eb;
		-moz-box-shadow:0 1px 0 1px #e4e6eb;
		box-shadow:0 1px 0 1px #e4e6eb;
		background:#fff;
		-webkit-box-sizing:border-box;
		-moz-box-sizing:border-box;
		box-sizing:border-box;
		margin-top:20px;
		margin-bottom:20px;
		/*margin-right:40px;*/
		padding:10px 0 10px 10px;
		}

		.discussions ul li:before {
		content:'';
		width:20px;
		height:20px;
		top:15px;
		left:-20px;
		position:absolute;
		}

		.discussions ul li .author {
		z-index:1;
		margin-right:1%;
		float:left;
		top:0;
		}

		.discussions ul li .author img {
		height:50px;
		-webkit-border-radius:50em;
		-moz-border-radius:50em;
		border-radius:50em;
		-webkit-box-shadow:0 1px 0 1px #e4e6eb;
		-moz-box-shadow:0 1px 0 1px #e4e6eb;
		box-shadow:0 1px 0 1px #e4e6eb;
		}

		.discussion ul li .actvity-content {
			margin-left:50px;
		}

		.discussions ul li .name {
		-webkit-border-radius:2px 0 0 2px;
		-moz-border-radius:2px 0 0 2px;
		border-radius:2px 0 0 2px;
		padding:0 10px;
		}

		.discussions ul li .date {
		position:absolute;
		top:10px;
		right:0;
		z-index:1;
		background:#f3f4f6;
		font-size:.7em;
		-webkit-border-radius:2px 0 0 2px;
		-moz-border-radius:2px 0 0 2px;
		border-radius:2px 0 0 2px;
		padding:5px 50px 5px 10px;
		}

		.discussions ul li .delete {
		position:absolute;
		-webkit-border-radius:0 2px 2px 0;
		-moz-border-radius:0 2px 2px 0;
		border-radius:0 2px 2px 0;
		background:#e4e6eb;
		top:10px;
		right:0;
		display:inline-block;
		cursor:pointer;
		padding:5px 10px;
		z-index:999;
		}

		.discussions ul li .message {
		margin:15px -10px 0 60px;
		padding:0px;
		}

		.discussions ul.children{
		padding-left:10px;
		}

		.discussions ul li ul {
		overflow:hidden;
		}

		.discussions ul li ul li{
		-webkit-box-shadow:none;
		-moz-box-shadow:none;
		box-shadow:none;
		border-bottom:1px solid #e4e6eb;
		margin:0;
		}
		.discussions ul.children li {
		//border-top:1px solid #e4e6eb;
		}

		.discussions ul li ul li .author {
		top:10px;
		left:10px;
		}

		.discussions ul li ul li .author img {
		height:40px;
		-webkit-border-radius:50em;
		-moz-border-radius:50em;
		border-radius:50em;
		-webkit-box-shadow:0 1px 0 1px #e4e6eb;
		-moz-box-shadow:0 1px 0 1px #e4e6eb;
		box-shadow:0 1px 0 1px #e4e6eb;
		}

		.discussions ul li ul li .name {
		left:70px;
		}

		/*
		.discussions ul li ul li .date {
		background:transparent;
		right:30px;
		}
		*/

		.discussions ul li ul li textarea {
		border:0;
		background:rgba(199, 203, 213, 0.15);
		-webkit-box-shadow:none;
		-moz-box-shadow:none;
		box-shadow:none;
		width:100%;
		padding:5px;
		}
		.discussions ul li ul li textarea::-webkit-input-placeholder {
		color:gray!important;
		font-size:.7em;
		}
		.discussions ul li ul li textarea:-moz-placeholder { /* Firefox 18- */
		color:gray!important;
		}

		.discussions ul li ul li textarea::-moz-placeholder {  /* Firefox 19+ */
		color:gray!important;  
		}

		.discussions ul li ul li textarea:-ms-input-placeholder {  
		color:gray!important;
		}
		.discussions .attachment{
		margin-top:10px;
		font-size:.85em;
		}
		.discussions ul{
		margin-left:0px;
		}
		.discussions .attachment li{
		border: none;
		padding: 0 10px;
		}
		.discussions .attachment i{
		margin-right:1%;
		}
		.discussions .attachment a{
		cursor: pointer;
		}
		.discussions .reply-footer a{
		float:right;
		}
	</style>	

<form id="editTitleForm" action="/study/edit" method="post">
	<input id="inputStudyTitle" type="text" name="title" style="display:none" />
	<input type="hidden" name="studyId" value="<?php echo $study->id ?>" />
</form>		
		

<div id="confirmStudyDeleteDialog" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form id="deleteForm" action="/study/delete" method="post" style="margin-bottom:0">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Delete Study - <?php echo $study->title ?> </h3>
  </div>
  <!--
  <div class="modal-body"></div>
  -->
  <div class="modal-footer">
  	<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
  	<button type="submit" class="btn btn-primary">OK</button>
  </div>
  <input type="hidden" name="id" value="<?php echo $study->id ?>" />
  </form>
</div>

<div id="confirmProjectDeleteDialog" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form id="deleteProjectForm" action="" method="post" style="margin-bottom:0">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="projectDeleteModalLabel"></h3>
  </div>
  <!--
  <div class="modal-body"></div>
  -->
  <div class="modal-footer">
  	<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
  	<button type="submit" class="btn btn-primary">OK</button>
  </div>
  <input type="hidden" name="id" value="<?php echo $study->id ?>" />
  </form>
</div>

<link rel="stylesheet" type="text/css" href="../../css/title-edit.css" />