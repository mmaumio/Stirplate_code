<section class="middle">
	<div class="wrapper">
    	<div class="middleMain">
            <div class="dashNewStdy">
                <div class="detailMainContentMainBtn">
            	   <a href="#"><span>Change Password?</span></a>
                </div>
            </div>
            <div class="dashBoxMainCntr">
            	<?php 
                    if(isset($k)){
                        $this->renderPartial('_changepass', array('model' => $model, 'k'=>$k));
                    }else{
                        $this->renderPartial('_changepass', array('model' => $model));
                    }
                ?> 
            </div>
        </div>
    </div>
</section>