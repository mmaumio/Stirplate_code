<a href="#" data-toggle="modal" data-target="#newtask"><img src="/img/details/btnAdd.png" alt="New Task" /><span>New Task</span></a>
<!-- New Task Modal -->
<div class="modal fade" id="newtask" tabindex="-1" role="dialog" aria-labelledby="newModalTask" aria-hidden="true">
 <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Add New Task</h4>
      </div>
        <div class="form-horizontal">
            <?php $form=$this->beginWidget('CActiveForm', array(
                      'id'=>'task-form',
                      'enableAjaxValidation'=>true,
                      'enableClientValidation'=>true,
                      'clientOptions'=>array(
                              'validateOnSubmit'=>true,
                      ),
              )); 
            
            ?>
            <div class="modal-body">
                <p class="note">Fields with <span class="required">*</span> are required.</p>

                <?php echo $form->errorSummary($task); ?>

                <?php echo $form->hiddenField($task,'ownerId',array('value'=>Yii::app()->user->id)); ?>
                <?php echo $form->hiddenField($task,'projectId',array('value'=>$_GET['id'])); ?>
                <div class="form-group">
                    <?php echo $form->labelEx($task,'assigneeId',array('class'=>'col-sm-2 control-label')); ?>
                    <div class="col-sm-6">
                      <?php  echo $form->dropDownList($task,'assigneeId',  Omniscience::getUsers($_GET['id']),array('class'=>'form-control input-sm') );?>
                      <?php echo $form->error($task,'assigneeId'); ?>
                    </div>
                </div>

                <div class="form-group">
                      <?php echo $form->labelEx($task,'subject',array('class'=>'col-sm-2 control-label')); ?>
                   <div class="col-sm-6">
                        <?php echo $form->textField($task,'subject',array('size'=>47,'maxlength'=>128,'placeholder'=>'Subject','class'=>'form-control input-sm')); ?>
                        <?php echo $form->error($task,'subject'); ?>
                    </div>
                </div>

                 <div class="form-group">
                      <?php echo $form->labelEx($task,'description',array('class'=>'col-sm-2 control-label')); ?>
                      <div class="col-sm-6">
                        <?php echo $form->textArea($task,'description',array('rows'=>6, 'cols'=>50,'placeholder'=>'Description','class'=>'form-control input-sm')); ?>
                        <?php echo $form->error($task,'description'); ?>
                      </div>
                </div>

                 <div class="form-group">
                      <?php echo $form->labelEx($task,'status',array('class'=>'col-sm-2 control-label')); ?>
                      <div class="col-sm-6">
                        <?php echo $form->dropDownList($task, 'status', array('Pending'=>'Pending','Complete'=>'Complete'),array('class'=>'form-control input-sm')); ?>
                        <?php echo $form->error($task,'status'); ?>
                      </div>
                </div>

                 <div class="form-group">
                      <?php echo $form->labelEx($task,'dueBy',array('class'=>'col-sm-2 control-label')); ?>
                     <div class="col-sm-6">
                        <?php 
                            $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                            'attribute'=>'dueBy',
                            'model'=>$task,
                            // additional javascript options for the date picker plugin
                            'options'=>array(
                                'showAnim'=>'fold',
                            ),
                            'htmlOptions'=>array(
                                'class'=>'form-control input-sm'
                            ),
                        )); 
                                ?>
                        <?php echo $form->error($task,'dueBy'); ?>
                      </div>
                </div>
               
            </div>
            <div class="modal-footer">
              <div class="control-group buttons">
                    <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                    <?php echo CHtml::ajaxSubmitButton('Create',array('project/ajaxTaskCreate' ),
                              array('type'=>'POST',
                             'dataType'=>'json',
                             'success'=>'js:function(data){
                                                if(data.status == "success"){
                                                    window.location.reload();
                                                }
                                                else{  
                                                    
                                                    $.each(data, function(key, val) {
                                                        $("#task-form #"+key+"_em_").text(val).focus(); 
                                                        $("#task-form #"+key+"_em_").show();
                                                    });
                                                     
                                                }
                                            }' 
                            ),
                            array('class'=>'btn btn-primary')); ?>
              </div>
            </div>
            <?php  $this->endWidget(); ?>
</div><!-- form -->

      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog --> 
</div><!-- /.modal -->