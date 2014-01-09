<div class="detailMainContentList">
	<div class="detailMainContentList1">
		<p>
			<b><?= $activity->user->firstName . " " . $activity->user->lastName;?></b><br/>
		</p>
	</div>
  <div class="detailMainContentList2">
  	<p><?= $activity->content;?></p>
  </div>
  <div class="detailMainContentList3">
  	<div class="listRtTime" title="<?= $activity->created;?>" style="float: none;"><?=  GeneralFunctions::getPrettyTime($activity->created);?></div>
  	<a href="#" data-toggle="modal" data-target="#discussionModal">Delete</a>
	</div>
</div>

		<div class="modal fade" id="discussionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title" id="myModalLabel">Are you sure to delete this comment ?</h4>
		      </div>
			 <form action="/project/delete_comment/<?= $activity->id;?>" id="newCommentForm" method="GET">
				<div class="modal-footer" style="border-top:none !important;">
					<div class="control-group buttons">
						<button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>				
						<button class="btn btn-primary" type="submit" style="float:right" id="submitCommentBtn">Delete</button>	
					</div>
		        </div>		        		      
			</form>
		      <!--<div class="modal-footer">
		        <button type="button" class="btn btn-primary">Add</button>
		      </div>-->
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
