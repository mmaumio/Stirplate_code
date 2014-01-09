<div class="span9 experiments" style="height:100%;margin-bottom:30px;">
	<div class="experiments-add">
		<h3 style="float:left">Experiment Data</h3>

		<!-- Button to trigger modal -->
		<a href="#addAttachmentModal" role="button" class="btn icon-plus" data-toggle="modal" style="padding:7px;float:right;margin-top:5px;"></a>
		<div class="clear"></div>
	</div>
	<ul>
		<?php if (isset($project->attachments)) { ?>
			<?php $ctr = 0; ?>
			<?php foreach ($project->attachments as $attachment) { ?>
				<?php if ((!isset($experiment) && empty($attachment->experimentId)) || (isset($experiment) && !empty($attachment->experimentId) && $experiment->id === $attachment->experimentId)) { ?>
				<?php 
					$experiementCreated = new DateTime($attachment->created);
					$experiementCreated->setTimeZone(new DateTimeZone('America/New_York'));
				?>
				<li>
					<div class="experiment-item experiment-in-progress <?php echo ($ctr++%2) != 0 ? 'odd' : ''; ?>">
						<?php if ($study->isAdmin()) { ?>
						<button type="submit" attachmentId="<?php echo $attachment->id ?>" class="btn btn-danger remove-attachment" style="position:absolute;right:1%;margin-top:10px;">Delete</button>
						<?php } ?>
						<h3><?php echo CHtml::link($attachment->name, array('attachment/download', 'id' => $attachment->id)) ?></h3>
						<p>Added <?php echo $experiementCreated->format('M j, Y') ?></p>
					</div>
				</li>
				<?php $this->renderPartial('//attachment/_delete', array('attachment' => $attachment)); ?>
				<?php } ?>
			<?php } ?>
		<?php } ?>
	</ul>
</div>

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
	
<script type="text/javascript" src="https://www.dropbox.com/static/api/1/dropins.js" id="dropboxjs" data-app-key="s4pp7dzg8ef1cyz"></script>
<script type="text/javascript">
	var selectedAttachmentId='';
	
	$(document).ready(function(){
		$("#attachDialog").dialog({ modal: true, autoOpen:false });
		
		$("#confirmDialog" ).dialog({
      		height:140,
      		modal: true,
      		autoOpen:false,
      		buttons: {
        		"Delete": function() {
        			// Submit the form
        			$('#deleteForm').submit();
        			// Close the dialog
          			$( this ).dialog( "close" );
        		},
        		Cancel: function() {
          			$( this ).dialog( "close" );
        		}
      		}	
    	});
	});
	
	// add an event listener to a Chooser button
    document.getElementById("db-chooser").addEventListener("DbxChooserSuccess",
        function(e) {
        		
        	var html = "";
        	
			for (var i=0; i<e.files.length; i++) {
				
				html += '<input type="text" name="urlLink' + i + '" value="' + e.files[i].link + '"/>';
				html += '<input type="text" name="fileName' + i + '" value="' + e.files[i].name + '"/>';
				html += '<input type="text" name="iconUrl' + i + '" value="' + e.files[i].icon + '"/>';
				//html += '<input id="dbThumbnailUrl" type="text" name="thumbnailUrl" value="' + e.files[i].thumbnail + '"/>\n';
								
				//$('#urlLink').val(e.files[i].link);
	        	//$('#inputFilename').val(e.files[i].name);
	        	//$('#db_file_size').val(e.files[0].bytes);
	        	//$('#db_icon').attr("src",e.files[i].icon);
	        	//$('#dbIconUrl').val(e.files[i].icon);
	        	//$('#dbThumbnailUrl').val(e.files[0].thumbnail); 
        	}
        	
        	// This tells the controller how many files to expect
        	html += '<input type="text" name="fileCount" value="' + e.files.length + '"/>';
        	$("#input_data").html(html);
			$("#input_data").trigger("create");

	        // Submit the form
	        $('#newForm').submit();
	        	
        }, false);

	$('.remove-attachment').on('click', function() {

		var attachment = {},
			row = $(this).parent();

		attachment.id = $(this).attr('attachmentId');

		$.post('/attachment/ajaxRemoveAttachment', attachment, function(data, textStatus, jqXHR) {
	      if (data.status === 'OK') {
	      	row.hide();
	      }
	    },'json');
	});

</script>
