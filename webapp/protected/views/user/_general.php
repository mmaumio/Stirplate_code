<?php
/* @var $model User */
/* @var $readonly boolean */

/**
 * This contains the content of the general tab.
 */
?>
<!-- Text input-->
<div class="control-group">
    <label class="control-label" for="textinput">First Name</label>

    <div class="controls">
        <?php echo CHtml::activeTextField($model, 'firstName', array('class' => 'input-xarge', 'required' => true,
            'readonly' => $readonly)) ?>
    </div>
</div>

<!-- Text input-->
<div class="control-group">
    <label class="control-label" for="textinput">Last Name</label>

    <div class="controls">
        <?php echo CHtml::activeTextField($model, 'lastName', array('class' => 'input-xarge', 'required' => true,
            'readonly' => $readonly)) ?>
    </div>
</div>

<!-- Text input-->
<div class="control-group">
    <label class="control-label" for="textinput">Email address</label>

    <div class="controls">
        <?php echo CHtml::activeTextField($model, 'email', array('class' => 'input-xarge', 'required' => true,
            'readonly' => $readonly)) ?>
    </div>
</div>

<!-- Text input-->
<div class="control-group">
    <label class="control-label" for="textinput">Preferred contact email</label>

    <div class="controls">
        <?php echo CHtml::activeTextField($model, 'contactEmail', array('class' => 'input-xarge', 'required' => true,
            'readonly' => $readonly)) ?>
    </div>
</div>

<!-- Text input-->
<div class="control-group">
    <label class="control-label" for="textinput">Position</label>

    <div class="controls margin-left-3em">
        <?php echo CHtml::activeRadioButtonList($model, 'selectedPositions[0]', CHtml::listData(Position::model()->findAll(), 'id', 'name'),
            array('class' => 'input-xlarge', 'readonly' => $readonly)) ?>
    </div>
</div>

<!-- Text input-->
<div class="control-group">
    <label class="control-label" for="textinput">Affiliation</label>

    <div class="controls">
        <?php echo CHtml::activeTextField($model, 'affiliation', array('class' => 'input-xarge', 'readonly' => $readonly)) ?>
    </div>
</div>

<!-- Text input-->
<div class="control-group">
    <label class="control-label" for="textinput">Department</label>

    <div class="controls">
        <?php echo CHtml::activeTextField($model, 'department', array('class' => 'input-xarge', 'readonly' => $readonly)) ?>
    </div>
</div>

<!-- Text input-->
<div class="control-group">
    <label class="control-label" for="textinput">Field of Study</label>

    <div class="controls">
        <?php echo CHtml::activeTextField($model, 'fieldOfStudy', array('class' => 'input-xarge', 'readonly' => $readonly)) ?>
    </div>
</div>

<!-- Text input-->
<div class="control-group">
    <label class="control-label" for="textinput">Lab Title</label>

    <div class="controls">
        <?php echo CHtml::activeTextField($model, 'labTitle', array('class' => 'input-xarge', 'readonly' => $readonly)) ?>
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="textinput">
        <?php echo CHtml::link('Forgot Password?', Yii::app()->createUrl('site/ForgotPassword')); ?>
    </label>
</div>