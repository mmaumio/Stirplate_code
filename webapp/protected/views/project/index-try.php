<section class="detailMain">
	<div class="wrapper">
        <div class="detailMainGreen">
            <h3><?php echo $project->title ?></h3>
            <p><!--#edtalk #edteach #edtech--></p>
            <div class="detailMainGreenImg">
            	<?php foreach ($project->users as $user) { ?>            		
            		<img src="<?php echo $user->profileImageUrl ?>" alt="<?php echo $user->firstName ?>" />
            	<?php } ?>
            </div>
        </div>
    </div>
</section>	
<section class="detailNav">
	<div class="wrapper">
    	<div class="detailNavMain">
        	<ul>
            	<li><a href="/dashboard"><img src="/img/details/dashNav1.png" alt="Dashboard"><span>Dashboard</span></a></li>
                <li><a href="#discussion"><img src="/img/details/dashNav2.png" alt="Discussion"><span>Discussion</span></a></li>
                <li><a href="#tasks"><img src="/img/details/dashNav3.png" alt="Tasks"><span>Tasks</span></a></li>
                <li><a href="#files"><img src="/img/details/dashNav4.png" alt="Files"><span>mFiles</span></a></li>
               
            </ul>
        </div> 
    </div>
</section>
<section class="detailMainContent"> 
	<div class="wrapper"> 
    	<?php $this->renderPartial('_discussionList', array('activities' => $project->activities)); ?>
        
        <div class="detailMainContentMain detailMainContentMainLft">
         <a id="tasks"></a>
         <h3>My Tasks</h3>
         <div class="detailMainContentListBor">
            <div class="detailMainContentList">
            	<div class="detailMainContentList1 detailMainContentList1Sm"><img src="images/sampleImg1.png" alt="Image" /><p><b>Albert E</b><br/>Job Title Scientist</p></div>
                <div class="detailMainContentList2">
                	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam aliquet convallis libero, ut congue leo rutrum quis. </p>
                </div>
            </div>
            
            <div class="detailMainContentList">
            	<div class="detailMainContentList1 detailMainContentList1Sm"><img src="images/sampleImg1.png" alt="Image" /><p><b>Albert E</b><br/>Job Title Scientist</p></div>
                <div class="detailMainContentList2">
                	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam aliquet convallis libero, ut congue leo rutrum quis. </p>
                </div>
            </div>
            
            <div class="detailMainContentList">
            	<div class="detailMainContentList1 detailMainContentList1Sm"><img src="images/sampleImg1.png" alt="Image" /><p><b>Albert E</b><br/>Job Title Scientist</p></div>
                <div class="detailMainContentList2">
                	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam aliquet convallis libero, ut congue leo rutrum quis. </p>
                </div>
            </div>
            
            <div class="detailMainContentList">
            	<div class="detailMainContentList1 detailMainContentList1Sm"><img src="images/sampleImg1.png" alt="Image" /><p><b>Albert E</b><br/>Job Title Scientist</p></div>
                <div class="detailMainContentList2">
                	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam aliquet convallis libero, ut congue leo rutrum quis. </p>
                </div>
            </div> 
         </div>
         <div class="detailMainContentMainBtn">
            	<a href="javascript:void(0);"><img src="/img/details/btnAdd.png" alt="New Task" /><span>New Task</span></a>
            	<!--
                <a href="javascript:void(0);"><img src="/img/details/btnMore.png" alt="More Task" /><span>More Task</span></a>
            	-->
            </div>
        </div>
        
        <div class="detailMainContentMain detailMainContentMainRt">
        <h3>Group Tasks</h3>
         <div class="detailMainContentListBor">
            <div class="detailMainContentList">
            	<div class="detailMainContentList1 detailMainContentList1Sm"><img src="images/sampleImg1.png" alt="Image" /><p><b>Albert E</b><br/>Job Title Scientist</p></div>
                <div class="detailMainContentList2">
                	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam aliquet convallis libero, ut congue leo rutrum quis. </p>
                </div>
            </div>
            
            <div class="detailMainContentList">
            	<div class="detailMainContentList1 detailMainContentList1Sm"><img src="images/sampleImg1.png" alt="Image" /><p><b>Albert E</b><br/>Job Title Scientist</p></div>
                <div class="detailMainContentList2">
                	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam aliquet convallis libero, ut congue leo rutrum quis. </p>
                </div>
            </div>
            
            <div class="detailMainContentList">
            	<div class="detailMainContentList1 detailMainContentList1Sm"><img src="images/sampleImg1.png" alt="Image" /><p><b>Albert E</b><br/>Job Title Scientist</p></div>
                <div class="detailMainContentList2">
                	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam aliquet convallis libero, ut congue leo rutrum quis. </p>
                </div>
            </div>
            
            <div class="detailMainContentList">
            	<div class="detailMainContentList1 detailMainContentList1Sm"><img src="images/sampleImg1.png" alt="Image" /><p><b>Albert E</b><br/>Job Title Scientist</p></div>
                <div class="detailMainContentList2">
                	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam aliquet convallis libero, ut congue leo rutrum quis. </p>
                </div>
            </div>
            
         </div>
        </div>
        
        
        <div class="detailMainContentMain">
         <a id="files"></a>
         <h3>
         	Files
         	<!--
         	<span class="floatRt">
	         	<input type="text" value="" name="" placeholder="Filter File Type" class="inputFilter" />
	         	<input type="text" value="" name="" placeholder="Search File" class="inputSearch" /> 
         	</span>
         	-->
     	</h3>
         <div class="detailMainContentListBor">
            
            	
				<?php
	//$proid=$project->id;
	$uid=Yii::app()->session['uid'];
	$row = Yii::app()->db->createCommand(array(
    'select' => array('projectId','name', 'fpUrl'),
    'from' => 'file',
    'where' => 'userId=:userId',
    'params' => array(':userId'=>$uid),
))->queryAll();
// $rowcount=$row->execute();

foreach($row as $d)
				{ ?>
				            <div class="detailMainContentList">
				<div class="detailMainContentList1"><img src="images/sampleImg1.png" alt="Image" /><p><b>
				<?php $url= $d['fpUrl']; ?>
				
				
				
				<a href="<?php echo $url; ?>" download><?php
				echo $d['name'];
				?></b><?php 
				echo "<br/>";
				?></a>
				<?php echo $user->firstName ?>
				</p></div>
				</div>
				<?php
				}
				?>	
				
                <!--<div class="detailMainContentList2">
                	<p>
                    	<span><img src="/img/details/greenIcon1.png" alt="Icon" />10 Documents</span>
                        <span><img src="/img/details/greenIcon2.png" alt="Icon" />24 Pictures</span>
                        <span><img src="/img/details/greenIcon3.png" alt="Icon" />14 Audio</span>
                        <span><img src="/img/details/greenIcon4.png" alt="Icon" />14 Videos</span>
                    </p>
                </div>
                <div class="detailMainContentList3"><div class="listRtTime">5 minutes ago</div></div>-->
            
            <!--<div class="detailMainContentList">
            	<div class="detailMainContentList1"><img src="images/sampleImg1.png" alt="Image" /><p><b>Albert E</b><br/>Job Title Scientist</p></div>
                <div class="detailMainContentList2">
                	<p>
                    	<span><img src="/img/details/greenIcon1.png" alt="Icon" />10 Documents</span>
                        <span><img src="/img/details/greenIcon2.png" alt="Icon" />24 Pictures</span>
                        <span><img src="/img/details/greenIcon3.png" alt="Icon" />14 Audio</span>
                        <span><img src="/img/details/greenIcon4.png" alt="Icon" />14 Videos</span>
                    </p>
                </div>
                <div class="detailMainContentList3"><div class="listRtTime">5 minutes ago</div></div>
            </div>
            
            <div class="detailMainContentList">
            	<div class="detailMainContentList1"><img src="images/sampleImg1.png" alt="Image" /><p><b>Albert E</b><br/>Job Title Scientist</p></div>
                <div class="detailMainContentList2">
                	<p>
                    	<span><img src="/img/details/greenIcon1.png" alt="Icon" />10 Documents</span>
                        <span><img src="/img/details/greenIcon2.png" alt="Icon" />24 Pictures</span>
                        <span><img src="/img/details/greenIcon3.png" alt="Icon" />14 Audio</span>
                        <span><img src="/img/details/greenIcon4.png" alt="Icon" />14 Videos</span>
                    </p>
                </div>
                <div class="detailMainContentList3"><div class="listRtTime">5 minutes ago</div></div>
            </div>
            
            <div class="detailMainContentList">
            	<div class="detailMainContentList1"><img src="images/sampleImg1.png" alt="Image" /><p><b>Albert E</b><br/>Job Title Scientist</p></div>
                <div class="detailMainContentList2">
                	<p>
                    	<span><img src="/img/details/greenIcon1.png" alt="Icon" />10 Documents</span>
                        <span><img src="/img/details/greenIcon2.png" alt="Icon" />24 Pictures</span>
                        <span><img src="/img/details/greenIcon3.png" alt="Icon" />14 Audio</span>
                        <span><img src="/img/details/greenIcon4.png" alt="Icon" />14 Videos</span>
                    </p>
                </div>
                <div class="detailMainContentList3"><div class="listRtTime">5 minutes ago</div></div>
            </div>-->
         </div>
            <!--<div class="detailMainContentMainBtn">
            	<a href="#addAttachmentModal" role="button" data-toggle="modal"><img src="/img/details/btnAdd.png" alt="Add Files" /><span>Add Files</span></a>
				

				
				<?php // $this->renderPartial('//attachment/_list', array('project'=>$project)); ?> 
            	<!--
                <a href="javascript:void(0);"><img src="/img/details/btnMore.png" alt="More Files" /><span>More Files</span></a>
            	
            </div>-->
			<?php $this->renderPartial('//file/_list', array('project' => $project)); ?>				

        </div>
    </div>
</section>


