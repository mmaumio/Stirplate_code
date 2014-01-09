<?php
/* @var $this UserController */
/* @var $data User */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('firstName')); ?>:</b>
	<?php echo CHtml::encode($data->firstName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lastName')); ?>:</b>
	<?php echo CHtml::encode($data->lastName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gender')); ?>:</b>
	<?php echo CHtml::encode($data->gender); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('link')); ?>:</b>
	<?php echo CHtml::encode($data->link); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('timezone')); ?>:</b>
	<?php echo CHtml::encode($data->timezone); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('locale')); ?>:</b>
	<?php echo CHtml::encode($data->locale); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('profileImageUrl')); ?>:</b>
	<?php echo CHtml::encode($data->profileImageUrl); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created')); ?>:</b>
	<?php echo CHtml::encode($data->created); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified')); ?>:</b>
	<?php echo CHtml::encode($data->modified); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('position')); ?>:</b>
	<?php echo CHtml::encode($data->position); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('affiliation')); ?>:</b>
	<?php echo CHtml::encode($data->affiliation); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('department')); ?>:</b>
	<?php echo CHtml::encode($data->department); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fieldOfStudy')); ?>:</b>
	<?php echo CHtml::encode($data->fieldOfStudy); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('labTitle')); ?>:</b>
	<?php echo CHtml::encode($data->labTitle); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('labUrl')); ?>:</b>
	<?php echo CHtml::encode($data->labUrl); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('researchInterests')); ?>:</b>
	<?php echo CHtml::encode($data->researchInterests); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('socialMediaFacebook')); ?>:</b>
	<?php echo CHtml::encode($data->socialMediaFacebook); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('socialMediaTwitter')); ?>:</b>
	<?php echo CHtml::encode($data->socialMediaTwitter); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('socialMediaLinkedIn')); ?>:</b>
	<?php echo CHtml::encode($data->socialMediaLinkedIn); ?>
	<br />

	*/ ?>

</div>