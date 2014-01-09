
    <form action="/attachment/create" method="post">
    	<div>
    		<input type="dropbox-chooser" name="selected-file" id="db-chooser"/>
    	</div>
    	
    	<div>
    		<img id="db_icon" src=""/>
    	</div>
    	<div>
    		<span class="input_label">Filename:</span>
    		<input type="text" name="file_name" value="Please select from above" id="db_file_name" readonly/>
    	</div>
    	<div>
    		<span class="input_label">Filesize:</span>
    		<input type="text" name="file_size" value="Please select from above" id="db_file_size" readonly/>
    	</div>

    	<input type="submit" />
    </form>


<script type="text/javascript">
    // add an event listener to a Chooser button
    document.getElementById("db-chooser").addEventListener("DbxChooserSuccess",
        function(e) {

        	$('#db_file_name').val(e.files[0].name);
        	$('#db_file_size').val(e.files[0].bytes);
        	$('#db_icon').attr("src",e.files[0].icon);
        	$('#db_file_icon').val(e.files[0].icon);
        	
            alert("Here's the chosen file: " + e.files[0].link);
            

        }, false);
</script>

<script type="text/javascript" src="https://www.dropbox.com/static/api/1/dropins.js" id="dropboxjs" data-app-key="s4pp7dzg8ef1cyz"></script>
