

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
    
	<!--<input type="hidden" name="studyId" value="<?php // echo $study->id ?>" />-->
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


				
 <div class="detailMainContentMainBtn">
	<!--<h3 style="float:left;">Attachments</h3>-->
		<?php 
			if (isset($project->attachments) ) {
				echo "(" . count($project->attachments) . ")";
			}
		?>
	
	<span>
      <!--
			<input class="right-side-button" type="submit" id="submit" value="+" onclick="$('#attachDialog').dialog('open');">
    -->
      <a href="#addAttachmentModal" role="button" class="btn icon-plus" data-toggle="modal"><img src="/img/details/btnAdd.png" alt="Add Files" /><span>Add Files</span></a>
	</span>
	<div class="clear"></div>

	<ul style="height:200px;overflow:auto;margin:0;">
		<?php if (isset($project->attachments) ) { ?>
			<?php foreach ($project->attachments as $attachment) { ?>
				<?php if ((!isset($experiment) && empty($attachment->experimentId)) || (isset($experiment) && !empty($attachment->experimentId) && $experiment->id === $attachment->experimentId)) { ?>
				<li>
					<?php /*
					<a href="<?php echo $attachment->urlLink ?>" target="_blank"><img src="<?php echo $attachment->iconLink ?>" width="32" height="32"/><?php echo $attachment->name ?></a>
					*/ ?>
					<a href="/attachment/download?id=<?php echo $attachment->id ?>"><img src="<?php echo $attachment->iconLink ?>" width="32" height="32"/><?php echo $attachment->name ?></a>
					<?php if ($study->isAdmin()) { ?>
					<!--
					<i class="icon-remove" style="float:right;margin-top:7px;" onClick="$('#confirmAttachmentDeleteDialog<?php echo $attachment->id ?>').modal();"></i>
				-->
					<?php } ?>
					<i class="icon-remove remove-attachment" style="float:right;cursor:pointer;margin-top:12px;" attachmentId="<?php echo $attachment->id ?>"></i>
				</li>
				<?php $this->renderPartial('//attachment/_delete', array('attachment' => $attachment)); ?>
				<?php } ?>
			<?php } ?>
		<?php } ?>
	</ul>

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
