<?php 
            if(isset($tasks)){
                foreach($tasks as $val){
                   
                   ?>
                       <div class="detailMainContentList">
                           <div class="detailMainContentList1 detailMainContentList1Sm"><?php if(isset($user->profileImageUrl)){ ?> <img src="<?php echo $user->profileImageUrl;?>" alt="Image" /><?php } ?><p><b><?php echo ucfirst($user->firstName).' '.ucfirst($user->lastName); ?></b><br/><?php echo ucfirst($user->labTitle); ?></p></div>
                            <div class="detailMainContentList2">
                                    <p><?php echo $val->description;?></p>
                            </div>
                        </div>
                       
                  <?php
                }
            }
            else{
                ?>
                    <div class="detailMainContentList">
                        No Result Found
                    </div>
                  <?php
            }
?> 