<!-- Modal -->
<div id="newExperimentModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Add Experiment</h3>
  </div>
  <div class="modal-body">
    <?php echo CHtml::beginForm('/experiment/create', 'post', array('class' => 'form-horizontal')); ?>
    <input type="hidden" name="Experiment[projectId]" value="<?php echo $project->id ?>">
    <input type="hidden" name="Experiment[ownerId]" value="<?php echo Yii::app()->user->id ?>">
    <div>&nbsp;</div>
    <fieldset>

    <!-- Text input-->
    <div class="control-group">
      <label class="control-label" for="experiment_name">Name</label>
      <div class="controls">
        <?php echo CHtml::activeTextField($experiment,'name', array(
          'id' => 'newExperimentName',
          'class' => 'input-xlarge hoverTooltip',
          'required' => true, 
          'placeholder' => 'Enter a name for this experiment',
          'data-trigger' => 'hover',
          'data-content' => 'Experiments are individual experiments under a project name. A majority of your data will be stored here. An example experiment would be “Postnatal day 6 qPCR data for BDNF in hippocampus”. You can have multiple experiments, but they all fall under a specific project.',
          'data-original-title' => 'Experiment')) ?>
      </div>
    </div>
    
    
    <!-- Select Basic -->
    <div class="control-group">
      <label class="control-label" for="type">Technique Used</label>
      <div class="controls">
        <select id="experiment_type" name="Experiment[type]" class="input-xlarge" required="">
          <option value="">---</option>
          <option>qPCR</option>
          <option>Immunocytochemistry</option>
          <option>Pyro Sequencing</option>
          <option>PCR</option>
          <option>Northern Blots</option>
          <option>Western Blots</option>
          <option>Behavior</option>
          <option>Other</option>
        </select>
      </div>
    </div>

    <!-- Select Basic -->
    <div class="control-group" id="machine_control" style="display:none;">
      <label class="control-label" for="selectbasic">Machine Used</label>
      <div class="controls">
        <?php echo CHtml::dropDownList('experiment_machine', '', 
          array(
            '' => '---',
            'Life Technologies 7500' => 'Life Technologies 7500',
            'Life Technologies 7900' => 'Life Technologies 7900',
            'Life Technologies ViiA 7' => 'Life Technologies ViiA 7',
            'Life Technologies StepOne' => 'Life Technologies StepOne',
            'Roche LightCycler' => 'Roche LightCycler',
            'Eppendorf Mastercycler' => 'Eppendorf Mastercycler',
            'BioRad MiniOpticon' => 'BioRad MiniOpticon',
            'BioRad MyiQ' => 'BioRad MyiQ',
            'BioRad Opticon2' => 'BioRad Opticon2',
            'BioRad Chromo4' => 'BioRad Chromo4',
            'Other' => 'Other'
          ), 
          array(
            'id' => 'experiment_machine',
            'class' => 'input-xlarge'
            )) ?>
      </div>
    </div>

    </fieldset>
    
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
    <button class="btn btn-primary">Save</button>
    <?php echo CHtml::endForm(); ?>
  </div>
  
</div>

<script>
$(document).ready(function() {
  //$('.hoverTooltip').popover();
  $('#experiment_type').on('change', function() {
    if ($(this).val() == 'qPCR') {
      $('#machine_control').show();
    } else {
      $('#machine_control').hide();
    }
  });
});
</script>