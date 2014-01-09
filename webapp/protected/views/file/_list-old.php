<h2>Files</h2>

	<div class="span12 discussions pull-left" style="margin-left:0">
		<div class="experiments-add">

			<?php if (!empty($project->files)) { ?>
				<?php $ctr = 0; ?>
				<?php foreach ($project->files as $data) { ?>
					<?php 
						$projectCreated = new DateTime($data->created);
						$projectCreated->setTimeZone(new DateTimeZone('America/New_York'));
					?>
					
						<div class="experiment-item">
							<h3><?php echo CHtml::link($data->name, '/file/download/' . $data->id, array('objId' => $data->id, 'data-toggle' => 'modal')) ?> - <?php echo $data->mimetype ?></h3>
							<p><?php echo $projectCreated->format('M j, Y') ?> by <?php echo isset($data->user) ? CHtml::link($data->user->getName(), array('user/view', 'id' => $data->userId)) : '' ?></p>
						</div>
					
				<?php } ?>

			<?php } ?>
		</div>

		<div class="clear">&nbsp;</div>

		<input type="filepicker" 
		data-fp-apikey="<?php echo Yii::app()->params['filepickerioapikey'] ?>" 
		data-fp-mimetypes="*/*" 
		data-fp-container="modal"
		data-fp-multiple="true" 
		data-fp-services="COMPUTER,BOX,DROPBOX"
		data-fp-button-text="Add Files" 
		onchange="processFpResponse(event);"
		class="btn btn-success fpaddfiles">
			
	</div>


<script>

var processFpResponse = function(event) {
	//console.log(event);

	// file uploaded successfully

	// save record to DB

	var data = {},
		length = event.fpfiles.length,
		attachments = [],
		file,
		i = -1;

	while (++i < length)
	{
		file = event.fpfiles[i];

		attachments.push({
			filename : file.filename,
			mimetype : file.mimetype,
			url : file.url,
			projectId : <?php echo $project->id ?>
		});
	}

	//console.log("attachments", attachments);

	data['attachments'] = attachments;

	//console.log(data);

	$.post('/file/ajaxCreate', data, function(data, textStatus, jqXHR) {
		// refresh page
		location.reload();
	});

}
</script>