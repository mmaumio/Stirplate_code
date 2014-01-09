<!-- Modal -->
<div id="newDataSetModal" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Add Data Set</h3>
  </div>
  <div class="modal-body">
    <div>&nbsp;</div>
    <fieldset>

    <div class="control-group">
      <label class="control-label" for="experiment_name">Data</label>
      <div class="controls">
            <form action="/data/upload" id="filedrop1" class="dropzone" style="width:100%;height:200px;min-height:200px;">
                <input type="hidden" name="dataSet[experimentId]" class="experiment" value="<?php echo $experiment->id ?>">
                <input type="hidden" name="dataSet[type]" value="Data">
            </form>
      </div>
    </div>

      <div class="control-group">
      <label class="control-label" for="experiment_name">Treatment Codes</label>
      <div class="controls">
            <form action="/data/upload" id="filedrop2" class="dropzone" style="width:100%;height:200px;min-height:200px;">
                <input type="hidden" name="dataSet[experimentId]" class="experiment" value="<?php echo $experiment->id ?>">
                <input type="hidden" name="dataSet[type]" value="Codes">
            </form>
      </div>
    </div>

    </fieldset>
    
  </div>
  <div class="modal-footer">
    <!--
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
    -->
    <button class="btn" id="processDataBtn">Process data</button>
  </div>
  
</div>

<script>
Dropzone.options.filedrop1 = {
  accept: function(file, done) {
    if (file.name.match('.xls$') || file.name.match('.xlsx$')) {
      done();
    } else {
      alert('Please upload only .xls files');
    }
  }
};

Dropzone.options.filedrop2 = {
  accept: function(file,done) {
    if (file.name.match('.xls$') || file.name.match('.xlsx$')) {
      done();
    } else {
      alert('Please upload only .xls files');
    }
  }
};

$('#processDataBtn').on('click', function() {
  document.location.href = "/experiment/results/" + "<?php echo $experiment->id ?>";

});
</script>