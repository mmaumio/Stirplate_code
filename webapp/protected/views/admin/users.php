<table class="table">
	<tr>
		<th>&nbsp;</th>
		<th>Name</th>
		<th>Email</th>
		<th>Groups</th>
		<th>Studies</th>
		<th>Last Login</th>
		<th>&nbsp;</th>
	</tr>
<?php if ($users) { ?>

	<?php foreach ($users as $user) { ?>

	<tr>
		<td><button userName="<?php echo $user->getShortName() ?>" userId="<?php echo $user->id ?>" name="singlebutton" class="btn btn-danger deleteUser">Delete</button></td>
		<td><?php echo $user->getName() ?></td>
		<td><?php echo $user->email ?></td>
		<td>
			<?php if ($user->groups) { ?>
				<?php foreach ($user->groups as $group) { ?>
					<?php $userGroup = UserGroupMember::model()->findByAttributes(array('userId' => $user->id, 'groupId' => $group->id)); ?>
					--- <?php echo $group->name ?> (<?php echo $userGroup->role ?>)<br>
				<?php } ?>
			<?php } ?>
		</td>
		<td>
			<?php if ($user->studies) { ?>
				<?php foreach ($user->studies as $study) { ?>
					<?php echo $study->title ?><br>
				<?php } ?>
			<?php } ?>
		</td>
		<td>
			<?php if (isset($lastLogins[$user->id])) { ?>
				<?php echo $lastLogins[$user->id] ?>
			<?php } else { ?>
				&nbsp;
			<?php } ?>
		</td>
		<td>

			<?php echo CHtml::beginForm('/admin/addUserToGroup', 'post', array('class' => 'form-horizontal')); ?>
			<fieldset>

			<input type="hidden" name="userId" value="<?php echo $user->id ?>">

			<!-- Select Basic -->
			<div class="control-group">
			  <label class="control-label" for="selectbasic" style="width:60px">Group</label>
			  <div class="controls" style="margin-left:80px">
			    <?php echo CHtml::dropDownList('group', '',
			      $groups, 
			      array(
			        'id' => 'user_group',
			        'class' => 'input-xlarge', 
			        'required' => true)) ?>
			  </div>
			</div>
			<div class="control-group">
			  <label class="control-label" for="selectbasic" style="width:60px">Role</label>
			  <div class="controls" style="margin-left:80px">
			    <?php echo CHtml::dropDownList('role', '',
			      array('Admin', 'Normal'), 
			      array(
			        'id' => 'user_group',
			        'class' => 'input-xlarge', 
			        'required' => true)) ?>
			  </div>
			</div>

			<!-- Button -->
			<div class="control-group">
			  <label class="control-label" for="singlebutton"></label>
			  <div class="controls">
			    <button id="singlebutton" name="singlebutton" class="btn btn-primary">Add User to Group</button>
			  </div>
			</div>

			</fieldset>
			<?php echo CHtml::endForm(); ?>
		</td>
	</tr>
	<?php } ?>

<?php } ?>
</table>

<script>
	$(document).ready(function() {
		$('.deleteUser').on('click', function() {
			var deleteUser = confirm("Are you sure you want to delete " + $(this).attr('userName'));

			if (deleteUser == true) {
				window.location.href = '/admin/deleteUser/' + $(this).attr('userId');
			}
		});
	});
</script>