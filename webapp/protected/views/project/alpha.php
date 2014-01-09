			<div class="row-fluid">
				<div class="span12 projects">
					<div id="editTitleContainer">
						<h1><?php echo $project->title ?></h1>
					</div>

					<div class="collaborators" style="margin:0">
					<?php if (!empty($project->users)) { ?>
						<?php foreach ($project->users as $user) { ?>							
								<a href="/user/publicProfile/<?php echo $user->id ?>"><img src="<?php echo $user->getUserImage() ?>" title="<?php echo $user->getName() ?>"></a>
						<?php } ?>
					<?php } ?>
					</div>
					
				</div>
			</div>
			
			<div class="row-fluid">
				<?php $this->renderPartial('//discussion/_list', array('project' => $project)); ?>				
			</div>

			<div class="row-fluid">
				<?php $this->renderPartial('//task/_list', array('project' => $project)); ?>				
			</div>

			<div class="row-fluid">
				<?php $this->renderPartial('//file/_list', array('project' => $project)); ?>				
			</div>




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
		box-sizing: border-box;
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