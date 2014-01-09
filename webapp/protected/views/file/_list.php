<div class="detailMainContentMain">
         <a id="files"></a>
         <h3>
         	Files
         	
         	<span class="floatRt">
	         	<input type="text" value="" name="" placeholder="Filter File Type" class="inputFilter" />
	         	<input type="text" value="" name="" placeholder="Search File" class="inputSearch" /> 
         	</span>
         	
     	</h3>
         <div class="detailMainContentListBor">
            
         <?php
         // Getting project's file data 
         $proid=$project->id;
         $uid=Yii::app()->session['uid'];

         $file = File::model()->findAllByAttributes(array('userId'=>$uid,'projectId'=>$proid));        
         
         foreach($file as $d):

           $user = ucfirst($d->user->firstName).' '.ucfirst($d->user->lastName);   
           $lab_title = ucfirst($d->user->labTitle);
           $time = GeneralFunctions::getPrettyTime($d->created);          
           
           $file_name = $d->name;
           $file_id = $d->id;
//           $fp_url= $d['fpUrl'];      
//           
//           $fp_url_elements = explode('/', $fp_url);
//           $fp_url_elements = array_reverse($fp_url_elements);
           
           //$thumbnail = "images/sampleImg1.png";
           $type = explode('/', $d->mimetype);           
           switch ($type[0]){
               case 'text':
                   $details_icon = '/img/details/greenIcon1.png';
                   break;
               case 'image':
                   $details_icon = '/img/details/greenIcon2.png';
                   //$thumbnail = $fp_url.'/convert?w=80&h=80&dl=false';
                   break;
               
               case 'audio':
                   $details_icon = '/img/details/greenIcon3.png';
                   break;
               
               case 'video':
                   $details_icon = '/img/details/greenIcon4.png';
                   break;               
               
               default:
                   $details_icon = '/img/details/greenIcon1.png';
                   break;                   
                   
           }
              


               
         ?>            
            <div class="detailMainContentList">
            	<div class="detailMainContentList1">
<!--                    <img src="<?php // echo $thumbnail;?>" alt="Image" />-->
                    <p><b><?php echo $user; ?></b><br/><?php echo $lab_title;?></p>
                </div>
                <div class="detailMainContentList2" >
                	<p>   
                            <span style="padding-left: 25px;width:100%"><a href="<?php echo $this->createUrl('file/download',array('file'=>$file_id)) ;?>" target="_blank"><img src="<?php echo $details_icon;?>" alt="Icon" /><?php echo $file_name;?></a></span>
                        </p>
                </div>
                <div class="detailMainContentList3"><div class="listRtTime"><?php echo $time; ?></div></div>
            </div>
         <?php
         endforeach;
         ?>    
         </div>
        		
</div>

	<div class="span12 discussions pull-left" style="margin-left:0">
		<div class="experiments-add">
		</div>

		<div class="clear">&nbsp;</div>
                
                <?php 
                $store_path = $project->title.'/'.GeneralFunctions::getUsername().'/'.date("Y-m-d").'/'; 
                
                $policy = base64_encode(json_encode(array('expiry'=>strtotime("+5 minutes"), 'call'=>array('pick','store'))));
                $signature = hash_hmac('sha256', $policy, Yii::app()->params['filepicker']['app_secret']);
                ?>
                
		<input type="filepicker" 
                data-fp-policy="<?php echo $policy ?>"       
                data-fp-signature ="<?php echo $signature; ?>"       
                data-fp-store-container="filepicker_elance"       
		data-fp-apikey="<?php echo Yii::app()->params['filepicker']['api_key'] ?>" 
		data-fp-mimetypes="*/*" 
		data-fp-container="modal"
		data-fp-multiple="true" 
		data-fp-services="COMPUTER,BOX,DROPBOX"
		data-fp-button-text="Add Files" 
                data-fp-store-location="S3"
                data-fp-store-path="<?php echo $store_path?>"                    
		onchange="processFpResponse(event);"
		class="btn btn-success fpaddfiles" >

	</div>

<script>

var processFpResponse = function(event) {
	 console.log(event);

	// file uploaded successfully

	// save record to DB

	var data = {},
		length = event.fpfiles.length,
		attachments = [],
		file,
		i = -1;

	while (++i < length)
	{
		file = event.fpfiles[i];

		attachments.push({
			filename : file.filename,
			mimetype : file.mimetype,
			url : file.url,
			projectId : <?php echo $project->id ?>
		});
	}

	// console.log("attachments", attachments);

	data['attachments'] = attachments;

	//console.log(data);
	var jsonText = JSON.stringify(data['attachments']);

	$.ajax({
            type: "POST",
            url : "<?php echo Yii::app()->createUrl('file/ajaxcreate') ;?>",        
            data: data,
            dataType: "json",
            success: function (result) {
		location.reload();
	    },
            error:function (e){
                    //alert(JSON.stringify(e));
                    location.reload();
                }
            });
                        
}


</script>
		<style>

		.replyForm {
			display:none;
		}

		.discussions ul li ul.discussion-replies {
			margin:0 0 0 50px;
		}

		.discussions ul li ul.discussion-replies .message {
			margin:15px -10px 0 50px;
		}

		.experiments {
			height:350px;
		}
		.collaborators, .experiments-add{
		box-sizing: border-box;
		}
		.attachments, .tasks {
			float:right;
			background: white;
			padding: 1%;
			box-sizing: border-box;
			box-shadow: 1px 1px 1px gray;
			border-radius: 2px;
			-webkit-box-shadow: 0 1px 0 1px #e4e6eb;
			-moz-box-shadow: 0 1px 0 1px #e4e6eb;
			box-shadow: 0 1px 0 1px #e4e6eb;
			margin-bottom:3%;
		}
		.discussions a{
		color:#08c;
		}
		.discussions ul li {
		list-style: none;
		position:relative;
		-webkit-border-radius:2px;
		-moz-border-radius:2px;
		border-radius:2px;
		-webkit-box-shadow:0 1px 0 1px #e4e6eb;
		-moz-box-shadow:0 1px 0 1px #e4e6eb;
		box-shadow:0 1px 0 1px #e4e6eb;
		background:#fff;
		-webkit-box-sizing:border-box;
		-moz-box-sizing:border-box;
		box-sizing:border-box;
		margin-top:20px;
		margin-bottom:20px;
		/*margin-right:40px;*/
		padding:10px 0 10px 10px;
		}

		.discussions ul li:before {
		content:'';
		width:20px;
		height:20px;
		top:15px;
		left:-20px;
		position:absolute;
		}

		.discussions ul li .author {
		z-index:1;
		margin-right:1%;
		float:left;
		top:0;
		}

		.discussions ul li .author img {
		height:50px;
		-webkit-border-radius:50em;
		-moz-border-radius:50em;
		border-radius:50em;
		-webkit-box-shadow:0 1px 0 1px #e4e6eb;
		-moz-box-shadow:0 1px 0 1px #e4e6eb;
		box-shadow:0 1px 0 1px #e4e6eb;
		}

		.discussion ul li .actvity-content {
			margin-left:50px;
		}

		.discussions ul li .name {
		-webkit-border-radius:2px 0 0 2px;
		-moz-border-radius:2px 0 0 2px;
		border-radius:2px 0 0 2px;
		padding:0 10px;
		}

		.discussions ul li .date {
		position:absolute;
		top:10px;
		right:0;
		z-index:1;
		background:#f3f4f6;
		font-size:.7em;
		-webkit-border-radius:2px 0 0 2px;
		-moz-border-radius:2px 0 0 2px;
		border-radius:2px 0 0 2px;
		padding:5px 50px 5px 10px;
		}

		.discussions ul li .delete {
		position:absolute;
		-webkit-border-radius:0 2px 2px 0;
		-moz-border-radius:0 2px 2px 0;
		border-radius:0 2px 2px 0;
		background:#e4e6eb;
		top:10px;
		right:0;
		display:inline-block;
		cursor:pointer;
		padding:5px 10px;
		z-index:999;
		}

		.discussions ul li .message {
		margin:15px -10px 0 60px;
		padding:0px;
		}

		.discussions ul.children{
		padding-left:10px;
		}

		.discussions ul li ul {
		overflow:hidden;
		}

		.discussions ul li ul li{
		-webkit-box-shadow:none;
		-moz-box-shadow:none;
		box-shadow:none;
		border-bottom:1px solid #e4e6eb;
		margin:0;
		}
		.discussions ul.children li {
		/*border-top:1px solid #e4e6eb;*/
		}

		.discussions ul li ul li .author {
		top:10px;
		left:10px;
		}

		.discussions ul li ul li .author img {
		height:40px;
		-webkit-border-radius:50em;
		-moz-border-radius:50em;
		border-radius:50em;
		-webkit-box-shadow:0 1px 0 1px #e4e6eb;
		-moz-box-shadow:0 1px 0 1px #e4e6eb;
		box-shadow:0 1px 0 1px #e4e6eb;
		}

		.discussions ul li ul li .name {
		left:70px;
		}

		/*
		.discussions ul li ul li .date {
		background:transparent;
		right:30px;
		}
		*/

		.discussions ul li ul li textarea {
		border:0;
		background:rgba(199, 203, 213, 0.15);
		-webkit-box-shadow:none;
		-moz-box-shadow:none;
		box-shadow:none;
		width:100%;
		padding:5px;
		}
		.discussions ul li ul li textarea::-webkit-input-placeholder {
		color:gray!important;
		font-size:.7em;
		}
		.discussions ul li ul li textarea:-moz-placeholder { /* Firefox 18- */
		color:gray!important;
		}

		.discussions ul li ul li textarea::-moz-placeholder {  /* Firefox 19+ */
		color:gray!important;  
		}

		.discussions ul li ul li textarea:-ms-input-placeholder {  
		color:gray!important;
		}
		.discussions .attachment{
		margin-top:10px;
		font-size:.85em;
		}
		.discussions ul{
		margin-left:0px;
		}
		.discussions .attachment li{
		border: none;
		padding: 0 10px;
		}
		.discussions .attachment i{
		margin-right:1%;
		}
		.discussions .attachment a{
		cursor: pointer;
		}
		.discussions .reply-footer a{
		float:right;
		}
	</style>
	<!-- start: JavaScript-->

	<!--<script type="text/javascript" src="/js/custom.min.js"></script>-->	
	<!-- js usages -->
	<!--<script type="text/javascript" src="/js/core.min.js"></script>	
	<script type="text/javascript" src="/js/jquery.transit.min.js"></script>-->

	
	<!-- end: JavaScript-->

	
  	
	<!-- webengage feedback tab -->
	<!--<script id="_webengage_script_tag" type="text/javascript">
	  var _weq = _weq || {};
	  _weq['webengage.licenseCode'] = "~99198d06";
	  _weq['webengage.widgetVersion'] = "4.0";
	  //_weq['webengage.feedback.alignment'] = 'left';
	  
	  (function(d){
	    var _we = d.createElement('script');
	    _we.type = 'text/javascript';
	    _we.async = true;
	    _we.src = (d.location.protocol == 'https:' ? "https://ssl.widgets.webengage.com" : "http://cdn.widgets.webengage.com") + "/js/widget/webengage-min-v-4.0.js";
	    var _sNode = d.getElementById('_webengage_script_tag');
	    _sNode.parentNode.insertBefore(_we, _sNode);
	  })(document);
	</script>

	<script type="text/javascript" src="/js/clickheat.js"></script><noscript><p><a href="http://www.dugwood.com/index.html">Open Source Sofware</a></p></noscript>-->

<script src="//api.filepicker.io/v1/filepicker.js" type="text/javascript"></script>