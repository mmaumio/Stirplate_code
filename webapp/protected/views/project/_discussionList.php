
		<div class="detailMainContentMain">
    		<a id="discussion"></a>
         	<h3>Discussion</h3>
         	<div class="detailMainContentListBor">
		        <?php foreach ($activities as $activity) { ?>
		        	<?php $this->renderPartial('_discussion', array('activity' => $activity)); ?>
		    	<?php } ?>
         	</div>
         	
	        <div class="detailMainContentMainBtn">
	        	<!--a href="#" data-toggle="modal" data-target="#discussionModal"><img src="/img/details/btnAdd.png" alt="Add comment" /><span>Add Comment</span></a-->
	        	<!--
	            <a href="javascript:void(0);"><img src="/img/details/btnMore.png" alt="More Discussions" /><span>More Discussions</span></a>
	        	-->
				
				 <form action="/activity/create" id="newCommentForm" method="POST">			
		        <fieldset>
		            <div class="form-group">
		                <div class="col-md-11">
						<input type="hidden" name="activity[projectId]" value="<?php echo $project->id ?>">
				<input type="hidden" name="activity[type]" value="comment">
				<textarea id="newComment" name="activity[content]" class="diss-form col-md-8" placeholder="Add to the discussion. Direct a comment to an individual by typing @(their name)." style="word-wrap: break-word;  height: 80px;" required=""></textarea>
				<div class="clear"></div>

				<button class="btn btn-primary" type="submit" style="float:right;margin-top:45px;margin-right: 30%;" id="submitCommentBtn">Submit Comment</button>

		                   <!-- <textarea id="textarea" name="textarea">default text</textarea>-->
		                </div>
		            </div>
		        </fieldset>		      
			  </form>
	        </div>
        </div>

        <!-- Modal -->
		<div class="modal fade" id="discussionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="myModalLabel">Add new comment </h4>
		      </div>
			 <form action="/activity/create" id="newCommentForm" method="POST">
			<div class="modal-body">
		        <fieldset>
		            <div class="form-group">
		                <div class="col-md-11">
						<input type="hidden" name="activity[projectId]" value="<?php echo $project->id ?>">
				<input type="hidden" name="activity[type]" value="comment">
				<textarea id="newComment" name="activity[content]" class="diss-form" placeholder="Add comment here" rows="7" cols="70" required=""></textarea>
				<div class="clear"></div>
				<button class="btn btn-primary" type="submit" style="float:right;margin-right: 30%;" id="submitCommentBtn">Submit Comment</button>
		                   <!-- <textarea id="textarea" name="textarea">default text</textarea>-->
		                </div>
		            </div>
		        </fieldset>
		      </div>
			  </form>
		      <!--<div class="modal-footer">
		        <button type="button" class="btn btn-primary">Add</button>
		      </div>-->
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<!-- Modal -->
		<div class="modal fade" id="collaboratorsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="myModalLabel">Add collaborators</h4>
		      </div>
			 <form action="/project/add_collaborators" id="newCommentForm" method="POST">
			<div class="modal-body">
		        <fieldset>
		            <div class="form-group">
		                <div class="col-md-11">
						<input type="hidden" name="projectId" value="<?php echo $project->id ?>">
				<input id="names" placeholder="Enter users names" size="20" />
				<input id="mynames" name="names" type="hidden" />

				<div class="clear"></div>
				<button class="btn btn-primary" type="submit" style="float:right;margin-right: 30%;" id="submitCommentBtn">Submit</button>
		                   <!-- <textarea id="textarea" name="textarea">default text</textarea>-->
		                </div>
		            </div>
		        </fieldset>
		      </div>
			  </form>
		      <!--<div class="modal-footer">
		        <button type="button" class="btn btn-primary">Add</button>
		      </div>-->
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
<script>
  $(document).ready(function(){
    console.log("letting width............");
	setTimeout(function () { 
		$(".textoverlay").css("width","67%");
	}, 1000);
    
  });
</script>
		
