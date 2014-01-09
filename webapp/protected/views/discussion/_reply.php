											<li>
												<div class="author">
													<img src="<?php echo $reply->user->getUserImage(); ?>" alt="avatar">
												</div>
												<div class="date"><?php echo (isset($replyDate) ? $replyDate->format('n/j/y') /*, g:i A')*/ : date('n/j/y') /*, g:i A')*/) ?></div>
												<div class="activity-content">
													<div class="name"><?php echo CHtml::link($reply->user->getName(), array('user/publicProfile', 'id' => $reply->userId)); ?></div>
													<?php if ($reply->user->id === Yii::app()->user->id) { ?>
													<div class="delete deleteActivity" activityId="<?php echo $reply->id ?>"><i class="icon-remove"></i></div>
													<?php } ?>
													<div class="message"><?php echo $reply->content ?></div>
													<div class="clear"></div>
												</div>
											</li>