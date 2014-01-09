<?php echo CHtml::beginForm('/study/create', 'post', array('class' => 'form-horizontal')); ?>
<fieldset>

<!-- Form Name -->
<legend>Create New Study</legend>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="textinput">Name of the Study</label>
  <div class="controls">
    <?php echo CHtml::activeTextField($study,'title', array(
    	'id' => 'newStudyTitle',
    	'class' => 'input-xlarge', 
    	'required' => true, 
    	'placeholder' => 'e.g. "The effects of stress on gene X"',
    	'data-trigger' => 'hover',
    	'data-content' => 'Think of this as the title to a paper',
    	'data-original-title' => 'Title')) ?>
  </div>
</div>

<!-- Select Basic -->
<div class="control-group">
  <label class="control-label" for="selectbasic">Type</label>
  <div class="controls">
  	<?php echo CHtml::activeDropDownList($study, 'type', array('' => 'Select a type', 'Reagents' => 'Reagents or Methods Test', 'Preliminary' => 'Preliminary Study', 'Full' => 'Full Study'), array(
      'id' => 'newStudyType',
      'class' => 'input-xlarge', 
      'required' => true,
      'data-trigger' => 'hover',
      'data-content' => 'Choose which type of study this is. Are you testing a method or are you collecting data to publish a paper?',
      'data-original-title' => 'Type')) ?>
  </div>
</div>

<!-- Select Basic -->
<!--
<div class="control-group">
  <label class="control-label" for="selectbasic">Visibility</label>
  <div class="controls">
  	<?php echo CHtml::activeDropDownList($study, 'visibility', array('' => 'Make this study public/private', /*'Public' => 'Public',*/ 'Private' => 'Private'), array(
      'id' => 'newStudyVisibility',
      'class' => 'input-xlarge', 
      'required' => true,
      'data-trigger' => 'hover',
      'data-content' => 'Currently all data sets are private, public datasets will be made available soon.',
      'data-original-title' => 'Visibility')) ?>
  </div>
</div>
-->

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="textinput">Project Name</label>
  <div class="controls">
    <?php echo CHtml::activeTextField($project,'name', array(
      'id' => 'newProjectName',
      'class' => 'input-xlarge', 
      'placeholder' => 'e.g. "Self Report Data"',
      'data-trigger' => 'hover',
      'data-content' => 'Think of a project as an experiment in a paper. For example, a project name could be “gene expression data for prenatal stress study” or “Behavioral data for prenatal stress study. Projects have multiple experiments under them.',
      'data-original-title' => 'Project')) ?>
  </div>
</div>

    <!-- Select Basic -->
    <div class="control-group">
      <label class="control-label" for="project_species">Animal Species</label>
      <div class="controls">
        <select id="project_species" name="Project[technique]" class="input-xlarge">
          <option value="">Select a species (optional)</option>
          <option>Rat</option>
          <option>Mouse</option>
          <option>Human</option>
          <option>Non-Human Primate</option>
          <option>Zebra Fish</option>
          <option>Drosophila</option>
        </select>
      </div>
    </div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="textinput">Experiment Name</label>
  <div class="controls">
    <?php echo CHtml::activeTextField($experiment,'name', array(
      'id' => 'newExperimentName',
      'class' => 'input-xlarge', 
      'placeholder' => 'e.g. "How much coffee consumed per..."',
      'data-trigger' => 'hover',
      'data-content' => 'Experiments are individual experiments under a project name. A majority of your data will be stored here. An example experiment would be “Postnatal day 6 qPCR data for BDNF in hippocampus”. You can have multiple experiments, but they all fall under a specific project.',
      'data-original-title' => 'Experiment')) ?>
  </div>
</div>

    <!-- Select Basic -->
    <div class="control-group">
      <label class="control-label" for="type">Technique Used</label>
      <div class="controls">
        <select id="experiment_type" name="Experiment[type]" class="input-xlarge">
          <option value="">Select a technique (optional)</option>
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

<!-- Text input-->
<!--
<div class="control-group">
  <label class="control-label" for="textinput">Technique</label>
  <div class="controls">
    <?php echo CHtml::activeDropDownList($experiment,'type', array('' => 'Select a technique', 'qPCR' => 'qPCR', 'Immunocytochemistry' => 'Immunocytochemistry', 'Pyro Sequencing' => 'Pyro Sequencing', 'PCR' => 'PCR', 'Northern Blots' => 'Northern Blots', 'Western Blots' => 'Western Blots', 'Behavior' => 'Behavior', 'Other' => 'Other'), array('class' => 'input-xlarge')) ?>
  </div>
</div>
-->

<!-- Button -->
<div class="control-group">
  <label class="control-label" for="singlebutton"></label>
  <div class="controls">
    <button id="singlebutton" name="singlebutton" class="btn btn-primary">Create</button>
  </div>
</div>

</fieldset>
<?php echo CHtml::endForm(); ?>

<div style="position:absolute;top:90px;right:30px;">
  <img src="/images/newstudy.png">
</div>

<script>
$(document).ready(function() {
	$('#newStudyTitle,#newStudyType,#newStudyVisibility,#newProjectName,#newExperimentName').popover();
});
</script>