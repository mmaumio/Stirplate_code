<h1>Project: <?php echo $project->name?></h1>
<?php 

if(count($experimentDataSets)==0)
{?>
<div> No dataset has been uploaded yet.<br/>
      <a href="/dataSet/upload?<?php echo 'projectId='.$project->id.'&experimentId='.$experiment->id ?>">Upload new dataset</a>
</div>
<div><a href="/project/list">Back to project list</a></div>
<?php
}
else foreach ($experimentDataSets as $experimentDataSet) { ?>
	<h2><?php echo $experimentDataSet['dataSet']->type ?></h2>
	<a class="btn btn-danger btn-small" onclick="confirmDelete(<?php echo $project->id.','.$experiment->id.','.$experimentDataSet['dataSet']->id ?>)" <i class="icon-trash icon-white"></i>&nbsp;Delete</a>
    <table class="footable">
        <thead>
            <? foreach ($experimentDataSet['dataSet']->columnMappings as $mapping) { ?>
                <th>
                    <span><?php echo $mapping->originalLabel ?></span>
                </th>
            <?php } ?>
        </thead>
        <tbody>
            <?php foreach ($experimentDataSet['dataSetRows'] as $row) { ?>
                <tr>
                    <?php foreach ($row as $col) { ?>
                        <td>
                            <?php echo $col ?>
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } ?>

<?php 
    //print_r($qpcr->data['sqlResults']);
?>

<script type="text/javascript">
$(document).ready(function() {
    $('table').footable();
});

function confirmDelete(projectId,experimentId,dataSetId){
	if(confirm("Are you sure you want to delete this dataset?"))
	{
		document.location = "/dataSet/delete?projectId="+projectId+"&experimentId="+experimentId+"&dataSetId="+dataSetId;
	}
}
</script>