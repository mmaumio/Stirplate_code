<?php
/* @var $model User */

/**
 * This contains the content of the lab tab.
 */
?>

<div class="control-group">
    <label class="control-label" for="textinput">Subject Type</label>

    <div class="controls">
        <?php echo CHtml::activeCheckBoxList($model, 'selectedLabs', CHtml::listData(Lab::model()->findAll(), 'id', 'name'),
            array('class' => 'input-xlarge',)) ?>
    </div>
    <div class="controls">
        <?php echo 'Other: ' . CHtml::activeTextField($model, 'otherLabName', array('class' => 'input-xarge')); ?>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="textinput">Techniques</label>

    <div class="controls">
        <?php echo CHtml::activeCheckBoxList($model, 'selectedTechs', CHtml::listData(Tech::model()->findAll(), 'id', 'name'),
            array('class' => 'input-xlarge',)) ?>
    </div>
    <div class="controls">
        <?php echo 'Other: ' . CHtml::activeTextField($model, 'otherTechName', array('class' => 'input-xarge')); ?>
    </div>
</div>