								<li class="activity <?php echo !empty($activity->relatedObjectType) ? $activity->relatedObjectType : 'study' ?>">
									<div class="author">
										<img src="<?php echo $activity->user->getUserImage() ?>" alt="avatar">
									</div>
									<?php 
										$activityDate = new DateTime($activity->created);
										$activityDate->setTimeZone(new DateTimeZone('America/New_York'));
									?>
									<div class="date"><?php echo $activityDate->format('n/j/y'); //, g:i A') ?></div>
									<div class="activity-content">
										<div class="name"><?php echo CHtml::link($activity->user->getName(), array('user/publicProfile', 'id' => $activity->userId)); ?></div>
										<?php if ($activity->user->id === Yii::app()->user->id) { ?>
										<div class="delete deleteActivity" activityId="<?php echo $activity->id ?>"><i class="icon-remove"></i></div>
										<?php } ?>
										<div class="message"><?php echo $activity->content ?></div>
									</div>
									<div class="divide"></div>
									
									<div class="clear"></div>									

									<!-- replies -->
									<?php if (!isset($replies[$activity->id]) || count($replies[$activity->id]) < 1) { ?>
									<?php $marginLeft = 0; ?>
									<ul class="discussion-replies" style="margin:0" id="replies_<?php echo $activity->id ?>">
									<?php } else { ?>
									<?php $marginLeft = 50; ?>
									<ul class="discussion-replies" id="replies_<?php echo $activity->id ?>">
										<?php foreach ($replies[$activity->id] as $reply) { ?>
										<?php 
											$replyDate = new DateTime($reply->created);
											$replyDate->setTimeZone(new DateTimeZone('America/New_York'));
											$this->renderPartial('//activity/_reply', array('reply' => $reply, 'replyDate' => $replyDate));
											} 
										?>
									<?php }?>
									</ul>
									<div style="float:left;margin-top:5px;<?php echo ($marginLeft > 0 ? 'margin-left:50px;' : '') ?>">
										<a href="#" class="activityReplyLink">Reply</a>
									</div>

									<div class="clear"></div>

									<ul class="replyForm" id="replyform_<?php echo $activity->id ?>" style="<?php echo ($marginLeft > 0 ? 'margin-left:50px;' : '') ?>">
										<li>
											<form action="/activity/create" method="POST">
												<div style="margin:0 10px 0 0;overflow:hidden;">
													<input type="hidden" name="activity[studyId]" value="<?php echo $study->id ?>">
													<input type="hidden" name="activity[parentActivityId]" value="<?php echo $activity->id ?>">
													<input type="hidden" name="activity[type]" value="reply">
													<?php if (!empty($project)) { ?>
													<input type="hidden" name="activity[relatedObjectId]" value="<?php echo $project->id ?>">
													<input type="hidden" name="activity[relatedObjectType]" value="project">
													<?php } else if (!empty($experiment)) { ?>
													<input type="hidden" name="activity[relatedObjectId]" value="<?php echo $experiment->id ?>">
													<input type="hidden" name="activity[relatedObjectType]" value="experiment">
													<?php } ?>
													<textarea name="activity[content]" class="diss-form" placeholder="Write a comment..." style="overflow:hidden;word-wrap:break-word;resize:horizontal;height:40px;" required=""></textarea>
													<div class="clear"></div>
													<button class="btn btn-primary activityReplySubmit" type="submit" style="float:right;margin-left:10px;">Reply</button>
													<button class="btn activityReplyCancel" style="float:right;">Cancel</button>
												</div>
											</form>
										</li>
									</ul>
								
								</li>