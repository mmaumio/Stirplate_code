<div class="clearfix"></div>
<?php ?>
<?php if(Yii::app()->user->hasFlash('success')){ ?>
<div class="alert alert-success" style="width:90%; margin:10px 0px 0px 5%">
  <button data-dismiss="alert" class="close" type="button">x</button>
  <?php echo Yii::app()->user->getFlash('success');?>
</div>
<?php } ?>
<?php 
 if (isset($alertMsg)) { ?>
<div class="alert alert-success">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <?php echo $alertMsg ?>
</div>
<?php } ?>
<?php if (isset($errorMsg)) { ?>
<div class="alert alert-danger">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <?php echo $errorMsg ?>
</div>
<?php } ?>
<br />
<div style="width: 300px; margin: 0px auto;clear: both;" >

<?php echo CHtml::beginForm('/user/update/' . $user->id, 'post', array('class' => 'form-horizontal')); ?>
<fieldset>

<!-- Form Name -->
<legend>
	<div class="author" style="float:left">
		<img src="<?php //echo $user->getUserImage() ?>" alt="avatar">
	</div>
	<div style="padding-left:5px;float:left;">
		<?php echo $user->getName() ?>
	</div>
	<div class="clear" style="margin-bottom:10px;"></div>
</legend>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="textinput">First Name</label>
  <div class="controls">
    <?php echo CHtml::activeTextField($user,'firstName', array('class' => 'input-xarge', 'required' => true, 'readonly' => $readonly)) ?>
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="textinput">Last Name</label>
  <div class="controls">
    <?php echo CHtml::activeTextField($user,'lastName', array('class' => 'input-xarge', 'required' => true, 'readonly' => $readonly)) ?>
  </div>
</div>

<?php if (!$readonly) { ?>
<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="textinput">Email</label>
  <div class="controls">
    <?php echo CHtml::activeTextField($user,'email', array('class' => 'input-xarge', 'required' => true, 'readonly' => $readonly)) ?>
  </div>
</div>
<?php } ?>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="textinput">Position</label>
  <div class="controls">
    <?php echo CHtml::activeTextField($user,'position', array('class' => 'input-xarge', 'readonly' => $readonly)) ?>
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="textinput">Affiliation</label>
  <div class="controls">
    <?php echo CHtml::activeTextField($user,'affiliation', array('class' => 'input-xarge', 'readonly' => $readonly)) ?>
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="textinput">Department</label>
  <div class="controls">
    <?php echo CHtml::activeTextField($user,'department', array('class' => 'input-xarge', 'readonly' => $readonly)) ?>
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="textinput">Field of Study</label>
  <div class="controls">
    <?php echo CHtml::activeTextField($user,'fieldOfStudy', array('class' => 'input-xarge', 'readonly' => $readonly)) ?>
  </div>
</div>

<!-- Text input-->
<!--
<div class="control-group">
  <label class="control-label" for="textinput">Lab Title</label>
  <div class="controls">
    <?php echo CHtml::activeTextField($user,'labTitle', array('class' => 'input-xarge', 'readonly' => $readonly)) ?>
  </div>
</div>
-->

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="textinput">Lab Web Page</label>
  <div class="controls">
    <?php echo CHtml::activeTextField($user,'labUrl', array('class' => 'input-xarge', 'readonly' => $readonly)) ?>
  </div>
</div>

<?php if (!$readonly) { ?>

  <?php //if (NULL != $user->password) { ?>
    <div class="control-group">
      <label class="controls">Leave passwords blank if unchanged</label>
    </div>
    <div class="control-group">
      <label class="control-label" for="currentPassword">Current Password</label>
      <div class="controls">
        <?php echo CHtml::passwordField('currentPassword','', array('class' => 'input-xarge', 'readonly' => $readonly)) ?>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="newPassword">New Password</label>
      <div class="controls">
        <?php echo CHtml::passwordField('newPassword','', array('class' => 'input-xarge', 'readonly' => $readonly)) ?>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="repeatPassword">Repeat Password</label>
      <div class="controls">
        <?php echo CHtml::passwordField('repeatPassword','', array('class' => 'input-xarge', 'readonly' => $readonly)) ?>
      </div>
    </div>
  <?php //} ?>

<!-- Button -->
<div class="control-group">
  <label class="control-label" for="singlebutton"></label>
  <div class="controls">
    <button id="singlebutton" name="singlebutton" class="btn btn-primary">Update</button>
  </div>
</div>
<?php } ?>

</fieldset>
<?php echo CHtml::endForm(); ?>
<div class="clearfix"></div>
</div>
<script>
$(document).ready(function() {
  $('#singlebutton').click(function() {
    if ($('#newPassword').val() !== $('#repeatPassword').val()) {
      alert("New Password and Repeat Password do not match, please enter them again");
      return false;
    } else {
      return true;
    }
  });
});
</script>
