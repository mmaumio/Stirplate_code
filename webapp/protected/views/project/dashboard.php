 
 <?php
      if(isset(Yii::app()->session['msg']) && !empty(Yii::app()->session['msg']))
      {
        ?>
        
 <div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong><p class="text-center"><?php echo Yii::app()->session['msg'];
        unset(Yii::app()->session['msg']);
        ?><p></strong> 
</div>

        
        <?php
      }
?>
<section class="middle">
	<div class="wrapper">
    	<div class="middleMain">
        	<div class="dashNewStdy">
                <div class="detailMainContentMainBtn">
            	   <a href="#" data-toggle="modal" data-target="#myModal"><img src="/img/dashboard/btnAdd.png" alt="New Project" /><span>Start New Project</span></a>
                </div>
            </div>
           
            <div class="dashBoxMainCntr">
            	<div class="dashBoxMainLft">
                    <?php $ctr = 0; ?>
                    
                    <?php foreach ($projects as $p) { ?>
                        <?php if ($ctr%3 == 0) { ?>
                        <div class="dashBoxContnr">
                        <?php } ?>

                        <?php $ctr++; ?>
                         
                        <div class="dashBox">
                        
                            <div class="dashBoxMain">
                                <div class="dashBoxMainDiv dashBoxMain<?php if(($ctr%6) == 0){echo 6;}else{echo $ctr%6;} ?>">
                                    <h3><?php echo CHtml::link($p->title, array('project/index', 'id' => $p->id)) ?></h3>
									 <?php /* <h3><a href="index.php?r=project/index&id=<?php echo $p->id ?>"><?php echo $p->title ?></h3> */ ?>
                                    
                                </div>
                                <div class="dashBoxMainFtr">
                                    <a href="/project/index/<?php echo $p->id ?>/#discussion">
                                    <div class="dashBoxMainFtrBox">
                                        <img src="/img/dashboard/dashIcon1.png" alt="Discussion" />
                                        <!--<div class="dashBoxMainFtrBoxIcon">89</div>-->
                                    </div>
                                    </a>
                                    <a href="/project/index/<?php echo $p->id ?>/#tasks">
                                    <div class="dashBoxMainFtrBox">
                                        <img src="/img/dashboard/dashIcon2.png" alt="Tasks" />
                                        <!--<div class="dashBoxMainFtrBoxIcon">36</div>-->
                                    </div>
                                    </a>
                                    <a href="/project/index/<?php echo $p->id ?>/#files">
                                    <div class="dashBoxMainFtrBox dashBoxMainFtrBoxLst">
                                        <img src="/img/dashboard/dashIcon3.png" alt="Files" />
                                        <!--<div class="dashBoxMainFtrBoxIcon">65</div>-->
                                    </div>
                                    </a>
                                   
                                </div>
                            </div>
                        </div>

                        <?php if ($ctr%3 == 0) { ?>
                        </div>
                        <?php } ?>

                    <?php } ?>
                </div>	
        </div>
                <div class="dashBoxMainRt">
                	<div class="dashBoxMainRtList">
                        <ul id="activity_stream">
                    	   <?php $this->renderPartial('//activity/_activity_streams', array('activities' => $activities)); ?>
                        </ul>
                    </div>
                </div>
            </div>
    </div>
</section>

<script type="text/javascript">
    function ajax_updater () {
        var biggest_id = 0 ;
        $.each($(".activity"), function(b, a){
            var num = parseInt($(a).attr("activity_id"));
            if(num > biggest_id)
                biggest_id = num;
        });
        $.ajax({
            url    : "project/updateactivity",
            data   : "last_id="+biggest_id,
            type   : "POST",
            success: function(result){
                if(result != ""){
                    $("#activity_stream").prepend(result);
                    $(".activity:first").hide().fadeIn(2000);
                }
                setTimeout(function(){ajax_updater();}, 2000);
            }
        });
    }
    $(document).ready(function() {
        ajax_updater ();
        
    });
</script>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">New Project</h4>
      </div>
      <form class="form-horizontal" action="project/create" method="post">
      <div class="modal-body">
        <fieldset>
            <!-- Text input-->
            <div class="form-group">
                <div class="col-md-11">
                    <input id="title" name="title" type="text" placeholder="Enter a title for this project" class="form-control input-md" required="">
                </div>
            </div>
        </fieldset>
      </div>
      <div class="modal-footer">
        <input type="submit" class="btn btn-primary" value="Create">
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->  
