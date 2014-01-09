<div class="span9 experiments" style="height:100%;">
	<div class="experiments-add">
		<h3 style="float:left">Experiments</h3>

		<!-- Button to trigger modal -->
		<a href="#newExperimentModal" role="button" class="btn icon-plus" data-toggle="modal" style="padding:7px;float:right;margin-top:5px;"></a>
		<div class="clear"></div>
		<?php $this->renderPartial('//experiment/_new', array('project' => $project, 'experiment' => $experiment)); ?>
	</div>
	<ul>
		
		<?php if (isset($project->experiments) && count($project->experiments) > 0) { ?>
			<?php $ctr = 0; ?>
			<?php foreach ($project->experiments as $experiment) { ?>
				<?php 
					$experiementCreated = new DateTime($experiment->created);
					$experiementCreated->setTimeZone(new DateTimeZone('America/New_York'));
				?>
				<li>
					<div class="experiment-item experiment-in-progress <?php echo ($ctr++%2) != 0 ? 'odd' : ''; ?>">
						<?php if ($study->isAdmin()) { ?>
						<button type="submit" experimentId="<?php echo $experiment->id ?>" experimentTitle="<?php echo $experiment->name ?>" class="btn btn-danger deleteExperimentBtn" style="position:absolute;right:1%;margin-top:10px;">Delete</button>
						<?php } ?>
						<?php if ($experiment->type == 'qPCR') { ?>
						<!--
						<button type="submit" experimentId="<?php echo $experiment->id ?>" class="btn btn-primary viewResultsBtn" style="position:absolute;right:<?php echo ($study->isAdmin() ? '85' : '0') ?>px;margin-top:10px;">Results</button>
						-->
						<?php } ?>
						<h3><?php echo CHtml::link($experiment->name, array('experiment/index', 'id' => $experiment->id)) ?> (<?php echo $experiment->type ?>)</h3>
						<p><?php echo $experiementCreated->format('M j, Y') ?></p>

					</div>
				</li>
			<?php } ?>
		<?php } ?>
	</ul>
</div>

<div id="confirmExperimentDeleteDialog" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form id="deleteExperimentForm" action="" method="post" style="margin-bottom:0">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="experimentDeleteModalLabel"></h3>
  </div>
  <!--
  <div class="modal-body"></div>
  -->
  <div class="modal-footer">
  	<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
  	<button type="submit" class="btn btn-primary">OK</button>
  </div>
  </form>
</div>

<script>
$(document).ready(function() {

	$('.viewResultsBtn').click(function() {
		window.location.href = '/experiment/results/' + $(this).attr('experimentId');
	});

	$('.deleteExperimentBtn').on('click', function() {
		//console.log($(this).attr('projectId'));
		//console.log($(this).attr('projectTitle'));
		$('#experimentDeleteModalLabel').html('Confirm deletion of: ' + $(this).attr('experimentTitle'));
		$('#deleteExperimentForm').attr('action', '/experiment/delete/' + $(this).attr('experimentId'));
		$('#confirmExperimentDeleteDialog').modal();
	});

});
</script>