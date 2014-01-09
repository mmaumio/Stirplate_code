<h1>Project: <?php echo $project->name?></h1>

<div style="float:left">
    <h2>Upload Data Sets:</h2>
    <form action="" id="filedrop1" class="dropzone" style="width:450px;height:200px;">
        <input type="hidden" name="experimentId" class="experiment" value="">
        <input type="hidden" name="projectId" value="<?php echo $project->id ?>">
        <input type="hidden" name="projectType" value="Data">
    </form>
</div>

<div style="float:right">
    <h2>Upload Treatment Codes:</h2>
    <form action="" id="filedrop2" class="dropzone" style="width:450px;height:200px;">
        <input type="hidden" name="experimentId" class="experiment" value="">
        <input type="hidden" name="projectId" value="<?php echo $project->id ?>">
        <input type="hidden" name="projectType" value="Treatment">
    </form>
</div>

<div class="clear"></div>

<div style="text-align:center;padding-top:50px;">
    <form action="/project/preview">
        <input type="hidden" name="projectId" value="<?php echo $project->id ?>">
        <input type="submit" value="Back">
    </form>
</div>

<script>
    Dropzone.options.filedrop1 = {
        init: function() {
            // once a file has been uploaded successfully, disable dropzone so no other files can be uploaded
            this.on('success', function(file, resp) { 
                this.disable();
                var respJson = $.parseJSON(resp);
                $('.experiment').val(respJson['experimentId']);
            });
        }
    };
    Dropzone.options.filedrop2 = {
        init: function() {
            // once a file has been uploaded successfully, disable dropzone so no other files can be uploaded
            this.on('success', function(file, resp) { 
                this.disable();
                var respJson = $.parseJSON(resp);
                $('.experiment').val(respJson['experimentId']);
            });
        }
    };
</script>