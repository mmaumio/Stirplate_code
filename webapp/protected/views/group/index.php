<ul class="breadcrumb" style="padding-left:0;margin-bottom:0">
	<li><a href="/group/list">Groups</a><span class="divider">/</span></li>
	<li class="active"><?php echo $group->name ?></li>
</ul>

<div class="span12 experiments">	
	<ul>
		<?php $ctr = 0; ?>
		<?php foreach ($group->members as $member) { ?>

				<?php 
					$created = new DateTime($member->created);
					$created->setTimeZone(new DateTimeZone('America/New_York'));
				?>
				<li>
					<div class="experiment-item <?php echo ($ctr++%2) != 0 ? 'odd' : ''; ?>">

					<?php if ($member->isAdmin()) { ?>
						<button type="submit" class="btn btn-danger" onclick="$('#confirmGroupMemberDeleteDialog<?php echo $member->groupId ?>').modal();" style="position:absolute;right:0;margin-top:20px;">Delete</button>
					<?php } ?>

						<h3><?php echo isset($member->user) ? CHtml::link($member->user->getName(), array('user/view', 'id' => $member->user->id)) : '' ?></h3>
					</div>
				</li>
		<?php } ?>
	</ul>
</div>