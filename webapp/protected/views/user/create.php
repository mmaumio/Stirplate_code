<?php
/* @var $this Controller */
/* @var $model User */
/* @var $form CActiveForm */
/* @var $readonly boolean */
?>
<section>
    <div class="wrapper">
        <div id="user-profile-title" class="clearBoth"><h3>User Profile</h3></div>
        <?php
        // if a flash exists as 'update' then show the message according to the value of the 'update'
        if (Yii::app()->user->hasFlash('update')): {
            $message = '';
            $show = true;
            if (Yii::app()->user->getFlash('update') === Yii::app()->params['SUCCESS']) {
                $class = 'alert-success';
                $message = 'Your profile has been updated.';
            } elseif (Yii::app()->user->getFlash('update') === Yii::app()->params['FAILURE']) {
                $class = 'alert-warning';
                $message = 'Update unsuccessful.';
            } else {
                $show = false;
            }
            Yii::app()->user->setFlash('update', 0);
        }
            if ($show):
                ?>
                <div id="user-form-alert" class="clearBoth alert <?php echo $class; ?>">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong><?php echo $message; ?></strong>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <div class="general-form center-block">
            <?php $form = $this->beginWidget('CActiveForm', array(
                'id' => 'user-form',
                'enableAjaxValidation' => true,
                'enableClientValidation' => true,
                'focus' => array($model, 'firstName'),
                'htmlOptions' => array('class' => 'clearfix'),
            )); ?>

            <?php echo $form->errorSummary($model); ?>
            <ul class="nav nav-tabs" id="tab-panel">
                <li class="active"><a href="#general-tab" data-toggle="tab">General</a></li>
                <li><a href="#lab-tab" data-toggle="tab">Lab</a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="general-tab">
                    <?php $this->renderPartial('_general', array('form' => $form, 'model' => $model, 'readonly' => $readonly)); ?>
                </div>
                <div class="tab-pane" id="lab-tab">
                    <?php $this->renderPartial('_lab', array('form' => $form, 'model' => $model, 'readonly' => $readonly)); ?>
                </div>
            </div>

            <script>
                $(function () {
                    $('#tab-panel').find('a:first').tab('show');
                })
            </script>

            <!-- Button -->
            <div class="control-group">
                <label class="control-label" for="singlebutton"></label>

                <div class="controls">
                    <button id="singlebutton" name="singlebutton" class="btn btn-primary">Update</button>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</section>