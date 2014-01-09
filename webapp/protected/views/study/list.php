<ul class="breadcrumb" style="padding-left:0;margin-bottom:0">
  <li class="active">Studies</li> 
</ul>

<div class="row-fluid">

	<div class="span12 experiments">	
		<ul>
			<?php $ctr = 0; ?>
			<?php foreach ($studies as $study) { ?>

					<?php 
						$created = new DateTime($study->created);
						$created->setTimeZone(new DateTimeZone('America/New_York'));
					?>
					<li>
						<div class="experiment-item <?php echo ($ctr++%2) != 0 ? 'odd' : ''; ?>">

						<?php if ($study->isAdmin()) { ?>
						<button type="submit" class="btn btn-danger" onclick="$('#confirmStudyDeleteDialog<?php echo $study->id ?>').modal();" style="position:absolute;right:15px;margin-top:20px;">Delete</button>
						<?php } ?>

							<h3><?php echo CHtml::link($study->title, array('study/index', 'id' => $study->id)) ?></h3>
							<p>
								<?php echo $created->format('M j, Y') ?> by <?php echo isset($study->owner) ? CHtml::link($study->owner->getName(), array('user/publicProfile', 'id' => $study->owner->id)) : '' ?>
							</p>
						</div>
					</li>
					<?php $this->renderPartial('//study/_delete', array('study' => $study)); ?>
			<?php } ?>
		</ul>
	</div>

</div>