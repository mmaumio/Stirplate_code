<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'firstName'); ?>
		<?php echo $form->textField($model,'firstName',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'firstName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lastName'); ?>
		<?php echo $form->textField($model,'lastName',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'lastName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<!--<div class="row">
		<?php echo $form->labelEx($model,'gender'); ?>
		<?php echo $form->textField($model,'gender',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'gender'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'link'); ?>
		<?php echo $form->textField($model,'link',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'link'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'timezone'); ?>
		<?php echo $form->textField($model,'timezone',array('size'=>4,'maxlength'=>4)); ?>
		<?php echo $form->error($model,'timezone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'locale'); ?>
		<?php echo $form->textField($model,'locale',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'locale'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->textField($model,'type',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'profileImageUrl'); ?>
		<?php echo $form->textField($model,'profileImageUrl',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'profileImageUrl'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created'); ?>
		<?php echo $form->textField($model,'created'); ?>
		<?php echo $form->error($model,'created'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'modified'); ?>
		<?php echo $form->textField($model,'modified'); ?>
		<?php echo $form->error($model,'modified'); ?>
	</div>
-->
	<div class="row">
		<?php echo $form->labelEx($model,'position'); ?>
		<?php echo $form->textField($model,'position',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'position'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'affiliation'); ?>
		<?php echo $form->textField($model,'affiliation',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'affiliation'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'department'); ?>
		<?php echo $form->textField($model,'department',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'department'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fieldOfStudy'); ?>
		<?php echo $form->textField($model,'fieldOfStudy',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'fieldOfStudy'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'labTitle'); ?>
		<?php echo $form->textField($model,'labTitle',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'labTitle'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'labUrl'); ?>
		<?php echo $form->textField($model,'labUrl',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'labUrl'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'researchInterests'); ?>
		<?php echo $form->textArea($model,'researchInterests',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'researchInterests'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'socialMediaFacebook'); ?>
		<?php echo $form->textField($model,'socialMediaFacebook',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'socialMediaFacebook'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'socialMediaTwitter'); ?>
		<?php echo $form->textField($model,'socialMediaTwitter',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'socialMediaTwitter'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'socialMediaLinkedIn'); ?>
		<?php echo $form->textField($model,'socialMediaLinkedIn',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'socialMediaLinkedIn'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->