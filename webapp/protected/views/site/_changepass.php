<?php 
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'change-form',
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
        <p class="note">Enter a new password.</p>
        <p class="note">Fields with <span class="required">*</span> are required.</p>
        
	<div class="form-group">
		<?php echo CHtml::label('New Password *','newpassword'); ?>
                <?php echo CHtml::passwordField('newpassword','',array('required'=>'required','class'=>'form-control')); ?>
	</div>
        
        <div class="form-group">
		<?php echo CHtml::label('Confirm Password *','confirmpassword'); ?>
                <?php echo CHtml::passwordField('confirmpassword','',array('required'=>'required','class'=>'form-control')); ?>
	</div>
        <?php 
            if(isset($k))
            echo CHtml::hiddenField('k', $k); 
        ?>
	<?php echo CHtml::submitButton('Submit', array('class'=>'btn btn-primary')); ?>

<?php $this->endWidget(); ?>
