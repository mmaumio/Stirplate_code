<?php echo CHtml::beginForm('/admin/addUser', 'post', array('class' => 'form-horizontal')); ?>
<fieldset>

<!-- Form Name -->
<legend>Add User</legend>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="textinput">First Name</label>
  <div class="controls">
    <?php echo CHtml::activeTextField($user,'firstName', array(
    	'id' => 'firstName',
    	'class' => 'input-xlarge', 
    	'required' => true)) ?>
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="textinput">Last Name</label>
  <div class="controls">
    <?php echo CHtml::activeTextField($user,'lastName', array(
      'id' => 'lastName',
      'class' => 'input-xlarge', 
      'required' => true)) ?>
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="textinput">Email</label>
  <div class="controls">
    <?php echo CHtml::activeTextField($user,'email', array(
      'id' => 'email',
      'class' => 'input-xlarge', 
      'required' => true)) ?>
  </div>
</div>

<!-- Select Basic -->
<div class="control-group">
  <label class="control-label" for="selectbasic">Group</label>
  <div class="controls">
    <?php echo CHtml::dropDownList('user_group', '',
      $groups, 
      array(
        'id' => 'user_group',
        'class' => 'input-xlarge', 
        'required' => true)) ?>
  </div>
</div>

<!-- Select Basic -->
<div class="control-group">
  <label class="control-label" for="selectbasic">Group Role</label>
  <div class="controls">
    <?php echo CHtml::dropDownList('user_group_role', '',
      array('Admin', 'Normal'), 
      array(
        'id' => 'user_group',
        'class' => 'input-xlarge', 
        'required' => true)) ?>
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="textinput">Password</label>
  <div class="controls">
    <?php echo CHtml::activePasswordField($user,'password', array(
      'id' => 'password',
      'class' => 'input-xlarge', 
      'required' => true)) ?>
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="textinput">Password Confirm</label>
  <div class="controls">
    <?php echo CHtml::passwordField('password_confirm', '', array(
      'id' => 'password_confirm',
      'class' => 'input-xlarge', 
      'required' => true)) ?>
  </div>
</div>

<!-- Button -->
<div class="control-group">
  <label class="control-label" for="singlebutton"></label>
  <div class="controls">
    <button id="singlebutton" name="singlebutton" class="btn btn-primary">Create</button>
  </div>
</div>

</fieldset>
<?php echo CHtml::endForm(); ?>


<?php echo CHtml::beginForm('/admin/addGroup', 'post', array('class' => 'form-horizontal')); ?>
<fieldset>

<!-- Form Name -->
<legend>Add Group</legend>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="textinput">Group Name</label>
  <div class="controls">
    <?php echo CHtml::activeTextField($group,'name', array(
      'id' => 'group_name',
      'class' => 'input-xlarge', 
      'required' => true)) ?>
  </div>
</div>

<!-- Button -->
<div class="control-group">
  <label class="control-label" for="singlebutton"></label>
  <div class="controls">
    <button id="singlebutton" name="singlebutton" class="btn btn-primary">Create</button>
  </div>
</div>

</fieldset>
<?php echo CHtml::endForm(); ?>

