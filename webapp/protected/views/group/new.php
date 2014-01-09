<?php var_dump($_POST) ?>

<?php echo CHtml::beginForm('/group/create', 'post', array('class' => 'form-horizontal')); ?>
<fieldset>

<!-- Form Name -->
<legend>Create New Group</legend>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="textinput">Name</label>
  <div class="controls">
    <?php echo CHtml::activeTextField($group,'name', array(
    	'id' => 'newGroupTextField',
    	'class' => 'input-xlarge', 
    	'required' => true, 
    	'placeholder' => 'Enter a name for the group',
    	'data-trigger' => 'hover',
    	'data-content' => 'Group Name',
    	'data-original-title' => 'Group')) ?>
  </div>
</div>

<!-- Add user -->
<div style="border:1px solid #ddd; padding:0px 5px;" >
<fieldset id="groupMembers">
	<legend>Members <input type="text" id="memberCount" style="width:2em;" /> <a role="button" class="btn icon-plus" style="padding:7px;margin-top:5px;" onClick="newInput();"></a></legend>

	<div id="additionalMembers"></div>
<!--
	<div class="control-group">
	  <label class="control-label" for="invitedEmailOrName">Email or Name</label>
	  <div class="controls">
	    <input id="invitedEmailOrName" name="invitedEmailOrName" placeholder="Enter an email address or a user name" class="typeahead input-xlarge" required="" type="text"/>
	    <i class="icon-remove" style="display:none;"></i>
	  </div>
	</div>
	
	
-->

</fieldset>
</div>

<!-- Button -->
<div class="control-group" style="padding:10px;">
  <label class="control-label" for="singlebutton"></label>
  <div class="controls">
    <button id="singlebutton" name="singlebutton" class="btn btn-primary">Create</button>
  </div>
</div>

</fieldset>
<?php echo CHtml::endForm(); ?>

<script>
var memberCount = 0;
var uniqueCount = 0;

function newInput() {
		memberCount ++;
	    var intId = ++uniqueCount;
	    var varName = "invitedEmailOrName" + intId;
        var fControlGroup = $("<div class=\"control-group\">");
        var fControl = $("<div class=\"controls\" style=\"padding:3px;\">");
        var fLabel = $("<label class=\"control-label\" for=\"" + varName + "\">Email or Name</label>");
        //var fInput = $("<input id=\"" + varName + "\" name=\"" + varName + "\" placeholder=\"Enter an email address or a user name\" class=\"typeahead input-xlarge group-member\" required=\"\" type=\"text\"/>");
        var fInput = $("<input id=\"" + varName + "\" name=\"groupMembers[" + uniqueCount + "]\" placeholder=\"Enter an email address or a user name\" class=\"typeahead input-xlarge group-member\" type=\"text\"/>");
        var fAdmin = $("<div id=\"" + "checkbox" + varName + "\" class=\"make-switch\" data-on-label=\"Admin\" data-off-label=\"No\"><input name=\"groupAdmin[]\" type=\"checkbox\"/></div>");
        var fCheckbox = $("<input name=\"groupAdmin[" + uniqueCount + "]\" type=\"checkbox\" value=\"admin\"/></div>");
        var removeButton = $("<i class=\"icon-remove\"></i>");
        
        // Remove the Entry
        removeButton.click(function() {
            $(this).parent().parent().remove();
            
            memberCount--;
            $("#memberCount").val(memberCount);
        });
        
		// Element
        fControl.append(fInput);
        //fControl.append(fAdmin);
        fControl.append(fCheckbox);
        fControl.append(removeButton);
        
        fControlGroup.append(fLabel);
        fControlGroup.append(fControl);
        $("#additionalMembers").append(fControlGroup);
        
        // Add typeahead to the created element
        // I don't think this is needed because
        // you don't usually have a list of people in the
        // system when you create your group
        // The flow should be something like you
        // create a group and invite your team to join.
        var typeAhead=$('#' + varName).typeahead({
	        source: function (query, process) {
		        return $.get('/collaboration/autoComplete', { query: query }, function (data) {
		            return process(data.options);
		        });
		    }
        });
        
        /*
        $('#' + varName).keypress(function (event) {
        	if (event.which == 13) {
        		var inputTextName = newInput();
        		$('#' + inputTextName).focus();
        	}
        });
        */
       
       // Update the member count
       $("#memberCount").val(memberCount);
                     
        return varName;
}

function handleMemberCountChange() {
	var count = $("#memberCount").val();
	var pCount = memberCount;
	
	if (count > 0) {
		// clear the groupMembers
		memberCount = 0;
		$("#additionalMembers").empty();
		
		var firstInput = "";
		for (var i=0; i<count; i++) {
			var input = newInput();
			if (i == 0) {
				firstInput = input;
			}
		}
		$('#' + firstInput).focus();		
	}	
}

$(document).ready(function() {
	
	$("#memberCount").bind('keyup input paste', function() {
		handleMemberCountChange();
	});
	
  	newInput();

});
</script>

<link rel="stylesheet" href="/css/bootstrap-switch.css">
<script src="/js/bootstrap-switch.min.js"></script>