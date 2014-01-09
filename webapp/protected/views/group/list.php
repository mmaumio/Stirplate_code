<ul class="breadcrumb" style="padding-left:0;margin-bottom:0">
  <li class="active">Groups</li> 
</ul>

<div class="span12 experiments">	
	<ul>
		<?php $ctr = 0; ?>
		<?php foreach ($groups as $group) { ?>

				<?php 
					$created = new DateTime($group->created);
					$created->setTimeZone(new DateTimeZone('America/New_York'));
				?>
				<li>
					<div class="experiment-item <?php echo ($ctr++%2) != 0 ? 'odd' : ''; ?>">

					<?php if ($group->isAdmin()) { ?>
					<button type="submit" class="btn btn-danger" onclick="$('#confirmDeleteGroupDialog<?php echo $group->id ?>').modal();" style="position:absolute;right:0;margin-top:20px;">Delete</button>
					<?php } ?>

						<h3><?php echo CHtml::link($group->name, array('group/index', 'id' => $group->id)) ?></h3>
						<p>
							<?php echo $created->format('n/j/y') ?> by <?php echo isset($group->owner) ? CHtml::link($group->owner->getName(), array('user/view', 'id' => $group->owner->id)) : '' ?>
						</p>
					</div>
				</li>
				<?php $this->renderPartial('//group/_delete', array('group' => $group)); ?>
		<?php } ?>
	</ul>
</div>
