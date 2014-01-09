<script type='text/javascript'>
    $(document).ready(function() {
        $('.close').click(function(){
            $(this).parent('.alert').fadeOut(1000);
        });
        $('#LoginForm_password').val("");
        $('#login-form-ajaxcall').submit(function(e){
            if(parseInt("<?php if(isset(Yii::app()->request->cookies['user_trails'])){echo Yii::app()->request->cookies['user_trails']->value;}else{echo 0;} ?>") > parseInt("2")){
                 e.preventDefault();
                 <?php if(isset(Yii::app()->request->cookies['user_trails']) && (Yii::app()->request->cookies['user_trails']->value > 2 )){unset(Yii::app()->request->cookies['user_trails']);} ?>
                 $("#forgot-popup").click();
            }
        })
        $("#forgot-modal .close, #forgot-modal #forgot-close").click(function(){
           location.reload(); 
        });
    })
</script>

<!-- Button trigger modal -->
<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#forgot-modal" id="forgot-popup" style="">
  Launch 
</button>

<!-- Modal -->
<div class="modal fade" id="forgot-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body">
       Would you like to reset your password? Click <a href="site/ForgotPassword">here</a> to reset.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" id="forgot-close">Cancel</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="signup-dialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!--<div class="modal-header">
      </div>
      -->
      <div class="modal-header"><div class="bootstrap-dialog-header">SIGN UP TO STIREPLATE    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
   </div></div>
      <div class="modal-body">
           <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'signup-form-ajaxcall',
                    //'action'=> $this->createUrl('site/index')
            )); ?>
                   <table class="signInMain">
                   <!--<tr><td class="form-label" style="vertical-align:middle;">First Name</td>
                       <td>
                            <div class="control-group">
                        <div class="controls">
                            <?php //echo $form->textField($userModel,'firstName',array('placeholder'=>'First Name')); ?>
                             <?php //echo $form->error($userModel,'firstName'); ?>
                              <p class="errorMessage" id="firstnameerror"></p>
                        </div>
                    </div>
                       </td>
                   </tr>
                  <tr><td class="form-label" style="vertical-align:middle;">Last Name</td>
                       <td>
                            <div class="control-group">
                        <div class="controls">
                            <?php //echo $form->textField($userModel,'lastName',array('placeholder'=>'Last Name')); ?>
                            <?php //echo $form->error($userModel,'lastName'); ?>
                             <p class="errorMessage" id="lastnameerror"></p>
                        </div>
                    </div>
                       </td>
                   </tr>-->
                   <tr><td class="form-label" style="vertical-align:middle;">Email</td>
                       <td>
                            <div class="control-group">
                        <div class="controls">
                            <?php echo $form->textField($userModel,'email',array('placeholder'=>'eg : example@site.edu')); ?>
                          <?php //echo $form->error($userModel,'email'); ?>
                         <!-- <p class="labelclass2">Only email address with .edu valid</p>-->
                           <p class="errorMessage" id="emailerror"></p>
                        </div>
                    </div>
                       </td>
                   </tr>
                  <!-- <tr><td class="form-label" style="vertical-align:middle;">Gender</td>
                       <td>
                            <div class="control-group">
                        <div class="controls">
                        <?php //echo CHtml::activeDropDownList($userModel, 'gender',CHtml::listData(,'id'), array('option selected'=>'M')); ?>
                       <select name="User[gender]" class="select-btn">
                           <option value="M">Male</option>
                           <option value="F">Female</option>
                       </select>
                        </div>
                    </div>
                       </td>
                   </tr>-->
                   <tr><td class="form-label" style="vertical-align:middle;">Password</td>
                       <td>
                            <div class="control-group">
                        <div class="controls">
                            <?php echo $form->passwordField($userModel,'password',array('placeholder'=>'Password')); ?>
                           <?php //echo $form->error($userModel,'password'); ?>
                          <p class="errorMessage" id="passworderror"></p>
                        </div>
                    </div>
                       </td>
                   </tr>
                   <tr><td class="form-label" style="vertical-align:middle;">Confirm Password</td>
                       <td>
                            <div class="control-group">
                        <div class="controls">
                            <?php echo $form->passwordField($userModel,'confirmpassword',array('placeholder'=>'Confirm Password')); ?>
                            <p class="errorMessage" id="confirmpassworderror"></p>
                     
                        </div>
                    </div>
                       </td>
                   </tr>
                   <?php echo CHtml::hiddenField('confirmemail'); ?>)
         
                   </table>
               <?php $this->endWidget();?> 
               <div class="clearBoth"></div>
      </div>
      <br />    
        <p class="alert alert-success msg">An email verification link sent on your email , Please check your email</p>  
    
      <div class="modal-footer">
      <img class="load-image" style="display: none;" src="<?php echo Yii::app()->createUrl('/');?>/img/home/loading.gif"/>
        <button class="btn btn-primary" id="sign-up-btn"> Submit </button>
        <button type="button" class="btn btn-danger" data-dismiss="modal" id="forgot-close">Cancel</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
	
 
<script>
        $(document).ready(function(){
            
            
            
            $('#sign-up-btn').click(function(){
               /* if($('#User_firstName').val()=="")
                {
                    $('#firstnameerror').text("Please fill first name");
                    return false;
                }
                else
                {
                     $('#firstnameerror').text("");
                }
                if($('#User_lastName').val()=="")
                {
                    $('#lastnameerror').text("Please fill last name");
                    return false;
                }
                else
                {
                        $('#lastnameerror').text("");
               
                }*/
                if($('#User_email').val()=="")
                {
                    $('#emailerror').text("Please fill email");
                    return false;
                }
                else
                {
                         $('#emailerror').text("");
               
                }
                if($('#User_password').val()=="")
                {
                    $('#passworderror').text("Please fill password field");
                    return false;
                }
                else
                {
                          $('#passworderror').text("");
              
                }
                if($('#User_confirmpassword').val()=="")
                {
                    $('#confirmpassworderror').text("Please fill confirm password field");
                    return false;
                }
                else
                {
                            $('#confirmpassworderror').text("");
            
                }
                
                if($('#User_password').val()!=$('#User_confirmpassword').val())
                {
                    $('#confirmpassworderror').text("Confirm password not matched !");
                
                    return false;
                }
                $.ajax({
                    type:'post',
                    url:'<?php echo Yii::app()->createUrl('site/signup');?>',
                    data:$('#signup-form-ajaxcall').serialize(),
                    beforeSend:function(){
                        $('#sign-up-btn').attr('disabled','disabled');
                        $('.load-image').show();
                    },
                    success:function(response){
                        
                        if(response=='exits')
                        {
                            $('#emailerror').text("Email already registered !");
                        }
                        else if(response=='invalid1')
                        {
                            $('#emailerror').text("Email not valid");
                        }
                        else if(response=='invalid')
                        {
                            $('#emailerror').text("Email should be end with .edu !");
                        }
                        else if(response=='success')
                        {
                           
                           $('.msg').fadeIn(100,function(){
                                      $('.msg').fadeOut(2000,function(){
                                             
                                      });
                                      $('#forgot-close').click();
                           });
                            
                        }
                             $('#sign-up-btn').removeAttr('disabled');
                              $('.load-image').hide();
                  
                    },
                    complete:function(){},
                    
                });
                
            });
            
            
            /**-------------------------------*/
            
           /* $('#User_firstName').focus(function(){
                $('#firstnameerror').text("");
            });
            
            $('#User_firstName').blur(function(){
                if($('#User_firstName').val()=="")
                {
                    $('#firstnameerror').text("Please fill first name");
                    return false;
                }
                else
                {
                     $('#firstnameerror').text("");
                }
            });
            
            $('#User_lastName').focus(function(){
                $('#lastnameerror').text("");
            });
             $('#User_lastName').blur(function(){
           
            if($('#User_lastName').val()=="")
                {
                    $('#lastnameerror').text("Please fill last name");
                    return false;
                }
                else
                {
                        $('#lastnameerror').text("");
               
                }
            });
            */
            
             $('#User_email').focus(function(){
                $('#emailerror').text("");
            });
            
            
             $('#User_email').blur(function(){
           
            
            if($('#User_email').val()=="")
                {
                    $('#emailerror').text("Please fill email");
                    return false;
                }
                else
                {
                         $('#emailerror').text("");
               
                }
               }); 
               
               
               $('#User_password').focus(function(){
                $('#passworderror').text("");
            });
             $('#User_password').blur(function(){
           
            if($('#User_password').val()=="")
                {
                    $('#passworderror').text("Please fill password field");
                    return false;
                }
                else
                {
                          $('#passworderror').text("");
              
                }
            });
            
              $('#User_confirmpassword').focus(function(){
                $('#confirmpassworderror').text("");
            });
             $('#User_confirmpassword').blur(function(){
           
            if($('#User_confirmpassword').val()=="")
                {
                    $('#confirmpassworderror').text("Please fill confirm password field");
                    return false;
                }
                else
                {
                            $('#confirmpassworderror').text("");
            
                }
            });
            
            
            //*------------------------------*
        });
</script>
<!--Page 1 Start-->
<?php if(Yii::app()->user->hasFlash('success')){?>
<div class="alert alert-warning" style="width:90%;position:fixed;height:50px;left:5%;top:2%;">
                        <a href="#" class="close" data-dismiss="alert">x
                        </a>
               <strong>Thanks!</strong>         <?php echo Yii::app()->user->getFlash('success'); ?>
</div>
<?php } ?>
<?php if(Yii::app()->user->hasFlash('error')){?>
<div class="alert alert-warning" style="width:90%;position:fixed;height:50px;left:5%;top:2%;">
                        <a href="#" class="close" data-dismiss="alert">x
                        </a>
               <strong>Error ! </strong>         <?php echo Yii::app()->user->getFlash('error'); ?>
</div>
<?php } ?>
<section class="homePage1">
  <div class="homePage1Main">
    <div class="wrapper">
      <!--Logo For Desktop-->
       <?php if(Yii::app()->user->isGuest){ ?>
      <div><a href="/" title="Stirlpate" class="logo" >&nbsp;</a></div>
       <?php }else{ ?>
       <div><a href="<?php echo $this->createUrl('dashboard') ?>" title="Stirlpate" class="logo" >&nbsp;</a></div>
       <?php } ?>
      
      <!--Logo For Responsive-->
      <div class="logoRespo"><a href="javasccript:void(0);" title="Stirplate"><img src="/img/home/logoHomeRespo.jpg" alt="Logo" /></a></div>
      
      <div class="homeRt">
        <div class="signIn">
          <h3>Sign In to stirplate</h3>
          <div class="signInMain">
            <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'login-form-ajaxcall',
                    'action'=> $this->createUrl('site/index')
            )); ?>
                     <?php echo $form->error($model,'email'); ?>
                     <?php echo $form->error($model,'password'); ?>
                    <div class="control-group">
                        <div class="controls">
                            <?php echo $form->textField($model,'email',array('placeholder'=>'Email')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                             <div class="controls">
                            <?php echo $form->passwordField($model,'password',array('placeholder'=>'Password')); ?>
                            </div>
                    </div>
                    
                    <div class="clearBoth"></div>
                    <label class="floatLft">
                             <?php 
                             echo $form->checkBox($model,'remember');
                             ?> Remember me
                    </label>
                    <label class="floatRt">
                             <?php echo CHtml::link('Forgot your passssword?', '/site/ForgotPassword') ?>
                    </label>
                    <div class="control-group buttons">
                         <div class="controls">
                            <?php echo CHtml::submitButton('SIGN IN',array('class'=>'btn-submit')); ?>
                            <a class="btn-signup" data-toggle="modal" data-target="#signup-dialog" style="font-family:'HelveticaNeueLT Pro';font-size: 20px;">SIGN UP</a>
                         </div>
                    </div>
                    <?php echo CHtml::hiddenField('confirm-password'); ?>
            <?php $this->endWidget(); ?>
          </div>
        </div>
      <!-- <div class="signUp">
            <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'newsletter-form',
                    'action'=> $this->createUrl('site/newsletter'),
                )); ?>
          <h3 align = "center">Stirplate Newsletter</h3>
          <h4 align ="center"> Sign up for updates!</h4>
          <div class="signUpMain">
              <?php echo $form->error($newsLetterModel,'email'); ?>
              <?php echo Yii::app()->user->getFlash('success'); ?>
              <?php echo $form->textField($newsLetterModel, 'email', array('placeholder' => 'Email Address')); ?>
               <?php echo CHtml::hiddenField('confirmemail'); ?>
         
              <?php echo CHtml::submitButton('Subscribe'); ?>
          </div>
            <?php $this->endWidget(); ?>
        </div>-->
      </div>
    </div>
  </div>
</section>
<!--Page 1 End--> 

<!--Page 2 Start-->
<section class="page2">
  <div class="wrapper">
    <div class="page2Main">
      <h1>Welcome to Stirplate </h1>
 <h3>Simplify your lab</h3>
       <img src="/img/home/textShadow.png" alt="Shadow" />
      <div class="homeBoxMain">
        <div class="homeBox"> <img src="/img/home/icon1.png" alt="Icon 1" />
          <h3>Data Management</h3>
          <p>Access your data anywhere at anytime </p>
        </div>
        <div class="homeBox"> <img src="/img/home/icon2.png" alt="Icon 2" />
          <h3>Simple collaboration</h3>
            <p>Share years of research data in seconds </p>
        </div>
        <div class="homeBox homeBoxLst"> <img src="/img/home/icon3.png" alt="Icon 3" />
          <h3>Centralized communication</h3>
          <p>Discuss, assign tasks, and view progress in one centralized area</p>
        </div>
      </div>
      <div class="homeBoxMain">
        <div class="homeBox"> <img src="/img/home/icon4.png" alt="Icon 4" />
          <h3>Automated data analysis</h3>
          <p>Go from excel to beautiful graphs in seconds, not hours</p>
        </div>
        <div class="homeBox"> <img src="/img/home/icon5.png" alt="Icon 5" />
          <h3>Experiment management</h3>
          <p>View your entire lab's progress, easily </p>
        </div>
        <div class="homeBox homeBoxLst"> <img src="/img/home/icon6.png" alt="Icon 6" />
          <h3>Safe and secure</h3>
          <p>Never worry about lost or corrupt files</p>
        </div>
      </div>
    </div>
  </div>
</section>
<!--Page 2 End--> 

<!--Page 3 Start-->
<section class="page3">
  <div class="wrapper">
      <div class="video-head">
          <h2 >Watch this video to see what Stirplate.io can do for your lab</h2>
      </div>
   <div class="page3Main">
                  <iframe src="//player.vimeo.com/video/75926086?title=0&amp;byline=0&amp;portrait=0" width="1020" height="640" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
  
   </div>
   </div>
</section>
<!--Page 3 End--> 

<!--Page 4 Start-->
<!--<section class="page4">
  <div class="wrapper">
    <div class="page4Main">
      <h2>About Us</h2>
      <div class="page4MainLft"> <img src="/img/home/aboutImg1.jpg" alt="About Us" />
        <h3>Keith Gonzales PhD</h3>
        <p>A former hacker turned neuroscientist, Keith has worked professionally in IT for 4 years and has been in science for over 8 years. Holding positions at Columbia University and Weill Cornell Medical College, Keith tends to like the finer things in life, such as powdered donuts.</p>
        <div class="aboutSmLft"> <a href="javascript:void(0);" title="Facebook"><img src="/img/home/iconFb.png" alt="Facebook" /></a> <a href="javascript:void(0);" title="Linkedin"><img src="/img/home/iconIn.png" alt="Linkedin" /></a> <a href="javascript:void(0);" title="Twitter"><img src="/img/home/iconTwt.png" alt="Twitter" /></a> </div>
      </div>
      <div class="page3MainRt">
        <div class="page3MainRtMain">
          <h1> Science is hard </h1>
          <ul> We don't believe it should be. Stirplate was founded as an answer to the following questions that I frequently asked myself in the lab: </ul>
            <br>
                <li> "Isn't there a faster way to do this?" 
                  <li> "Isn't there a better way to share files?" 
                      <li> "I can't open that file, I'm on a (Mac or PC)
                        <li> " I can't find that attachment!" </li>
          </ul>
        </br>
<h4>We've all been there and it's frustrating. The current tools to fix these problems tend to be difficult to use. So we made something that is easy, simple, and address the needs of scientists.</h4>
        </div>
    </div>                  
	<dsds></dsdsd>
  </div>
</section>-->
<!--Page 4 End--> 

<!--Page 5 Start-->

  <section class="homePage1">
        <div class="signUp">
            <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'newsletter-form',
                    'action'=> $this->createUrl('site/newsletter'),
                )); ?>
          <h3 align = "center" class="newsletter-head">Stirplate Newsletter, sign up for updates.</h3>
            <div class="newsletter-holder">
                <div class="signUpMain">
                    <?php echo $form->error($newsLetterModel, 'email'); ?>
                    <?php echo Yii::app()->user->getFlash('success'); ?>
                    <?php echo $form->textField(
                        $newsLetterModel,
                        'email',
                        array('placeholder' => 'Enter email address')
                    ); ?>
                    <?php echo CHtml::hiddenField('confirmemail'); ?>
                </div>
                <?php echo CHtml::submitButton('Subscribe'); ?>
            </div>
            <?php $this->endWidget(); ?>
        </div>
  </section>
  <!--Footer section-->
<section class="contact">
  <div class="wrapper">
    <div class="contactMain">
      <div class="contactMainHead">
        <div class="contactMainHeadBox">
		  <p class="homelinks">
			<span><a href="<?php echo $this->createUrl('site/aboutus'); ?>">About us</a></span>
			<span><a href="<?php echo $this->createUrl('site/privacy'); ?>">Privacy and terms of service</a></span>
			<span><a href="<?php echo $this->createUrl('site/faq'); ?>">FAQ</a></span>
			<span><a href="mailto:info@stirplate.io">Contact us</a></span>
			<span><a href="<?php echo $this->createUrl('site/blog'); ?>">Blog</a></span>
			     <a target="_blank" href="https://www.Facebook.com/stirplate" class="middle-content"><i class="facebook-class"></i></a> 
				<a target="_blank;" href="https://www.twitter.com/stirplate" class="middle-content"><i class="twitter-class"></i></a>
		<p>
      </div>
      </div>
     
    </div>
  </div>
</section>
