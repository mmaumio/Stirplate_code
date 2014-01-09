<?php 
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'forgot-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
        'htmlOptions' => array('class'=>"form general-form", 'role'=>"form"),
)); 
?>
<?php if(Yii::app()->user->hasFlash('error')):?>
            <div id="success" class='success alert alert-danger'>
                <span style="margin-left:10px;">
                 <?php echo Yii::app()->user->getFlash('error'); ?>
                </span>
            </div>
        <?php endif; ?>
<?php if(Yii::app()->user->hasFlash('success')):?>
            <div id="success" class='success alert alert-success'>
                <span style="margin-left:10px;">
                 <?php echo Yii::app()->user->getFlash('success'); ?>
                </span>
            </div>
        <?php endif; ?>
        <p class="note">Enter your registered email.</p>
        <p class="note">Fields with <span class="required">*</span> are required.</p>
        
	<div class="form-group">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('class'=>'form-control ')); ?>
		<?php echo $form->error($model,'email'); ?>
              
	</div>
        
	<?php echo CHtml::submitButton('Submit', array('class'=>'btn btn-primary')); ?>

<?php $this->endWidget(); ?>
