				<div class="span12 experiments">
					<div class="experiments-add">
						<h3 style="float:left">Uploaded Data Sets</h3>
						<!-- Button to trigger modal -->
						<a href="#" role="button" id="newDataBtn" class="btn icon-plus" style="padding:7px;float:right;margin-top:5px;"></a>
						<!--
						<input type="filepicker" 
							data-fp-apikey="<?php echo Yii::app()->params['filepickerioapikey'] ?>" 
							data-fp-mimetypes="*/*" 
							data-fp-container="modal"
							data-fp-multiple="true" 
							data-fp-services="COMPUTER,BOX,DROPBOX"
							data-fp-button-text="Add Files" 
							onchange="processFpResponse(event);"
							class="btn btn-success fpaddfiles"
							>
						-->
						<div class="clear"></div>
					</div>
					<ul>
						<?php $this->renderPartial('//data/_new', array('experiment' => $experiment)); ?>

						<?php if (!empty($experiment->dataSets)) { ?>
							<?php $ctr = 0; ?>
							<?php foreach ($experiment->dataSets as $data) { ?>
								<?php 
									$projectCreated = new DateTime($data->created);
									$projectCreated->setTimeZone(new DateTimeZone('America/New_York'));
								?>
								<li>
									<div class="experiment-item experiment-in-progress <?php echo ($ctr++%2) != 0 ? 'odd' : ''; ?>">

										<?php if ($study->isAdmin()) { ?>
										
										<button type="submit" projectId="<?php echo $project->id ?>" projectTitle="<?php echo $project->name ?>" class="btn btn-danger deleteProjectBtn" style="position:absolute;right:1%;margin-top:10px;">Delete</button>
										
										<?php } ?>

										<h3><?php echo CHtml::link($data->name, '#', array('objId' => $data->id, 'data-toggle' => 'modal')) ?> - <?php echo $data->type ?></h3>
										<p><?php echo $projectCreated->format('M j, Y') ?> by <?php echo isset($data->owner) ? CHtml::link($data->owner->getName(), array('user/view', 'id' => $data->ownerId)) : '' ?></p>
									</div>
								</li>
							<?php } ?>

						<?php } ?>
					</ul>
				</div>


<script>

var processFpResponse = function(event) {
	console.log(event);

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
			studyId : <?php echo $study->id ?>,
			projectId : <?php echo $project->id ?>,
			experimentId : <?php echo $experiment->id ?>
		});
	}

	console.log("attachments", attachments);

	data['attachments'] = attachments;

	console.log(data);

	$.post('/attachment/ajaxCreate', data, function(data, textStatus, jqXHR) {

	});

	// refresh page
}

$(document).ready(function() {

	processFpResponse({fpfiles: [{filename:'ABC', mimetype:'DEF', url:'http://www.google.com'}]});

  $('#newDataBtn').on('click', function() {
  	$('#newDataSetModal').modal('show');
  });

  $('[data-toggle="modal"]').click(function(e) {
    e.preventDefault();
    var url = '/data/view/' + $(this).attr('objId');
    //if (url.indexOf('#') == 0) {
    //  $(url).modal('open');
    //} else {
      $.get(url, function(data) {
        if ($('#viewDataModal').length) {
          $('#viewDataModal').html(data).modal('show');
        } else {
          $('<div class="modal hide fade" id="viewDataModal">' + data + '</div>').modal();
        }
      }).success(function() { $('input:text:visible:first').focus(); });
    //}
  });
});
</script>

<style>
	.btn.fpaddfiles {
		float:right;
	}
</style>