<?php if (isset($errorMsg)) { ?>
<div class="alert alert-danger">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <?php echo $errorMsg ?>
</div>
<?php } ?>

<div class="container-fluid-full">
		<div class="row-fluid">
					
			<div class="row-fluid">
				<div class="logo-login">
					<div class="logo">
						<img src="/images/logo.png">
					</div>
					<div class="logo-title">
						<h1>OmniScience</h1><div style="margin-top:-17px;"><b>Science in Real Time</b></div>
					</div>
				</div>
				<div class="clear"></div>
				<div class="login-box">
					<h2>Login to your account</h2>
					<form class="form-horizontal" action="/auth/omnisci" method="post">
						<?php if (!empty($retUrl)) { ?>
						<input type="hidden" name="retUrl" value="<?php echo $retUrl ?>">
						<?php } ?>
						<fieldset>
							
							<input class="input-xlarge" name="email" id="email" type="text" placeholder="type email"/>

							<input class="input-xlarge" name="password" id="password" type="password" placeholder="type password"/>

							<div class="clearfix"></div>
							
							<!--
							<label class="remember" for="remember"><div class="checker" id="uniform-remember"><span><input type="checkbox" id="remember"></span></div> Remember me</label>
							-->

							<div class="clearfix"></div>
							
							<button type="submit" class="btn btn-primary">Login</button>
						</fieldset>
					</form>

					<h2>Sign up for the OmniScience Beta</h2>

					<button type="button" class="btn get-started scroll-link" data-toggle="modal" data-target="#signUpModal">Sign up</button>
					
					<!--		
					<div style="text-align:center;">Or</div>

					<form action="/auth/facebook">
						<button type="submit" class="btn btn-primary btn-linkedin span12">Login via Facebook</button>
					</form>
					
					<hr>
					-->

					<!--
					<h3>Forgot Password?</h3>
					<p>
						No problem, <a href=" #">click here</a> to get a new password.
					</p>
					-->	
				</div><!--/span-->
			</div><!--/row-->
			
				</div><!--/fluid-row-->
				
	</div><!--/.fluid-container-->

  <div id="signUpModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="background:none;border:2px solid #fff;">
    <div class="modal-body" style="height:450px;overflow:hidden;padding:0;background:#000;">
      <!-- Begin LaunchRock Widget -->
      <div id="lr-widget" rel="H43SI452" style="background:none;margin-top:-50px;"></div>
      <script type="text/javascript" src="//ignition.launchrock.com/ignition-current.min.js"></script>
      <!-- End LaunchRock Widget -->
    </div>
  </div>

	<style>
	.container-fluid-full #lr-widget #content {
		margin:0 0 0 10px;
	}

	body{background:url('/images/bg.png');}
	.logo-login{width:365px;margin:0 auto;}
	.logo img {float: left;margin-left: 5px;margin-top:10px;}
	.logo-title{margin-top:55px;float:left;width:265px;}
	.logo-title h1{float: left;margin: -10px 5px 0 0;color: white;}
	.logo-title b{color:black;}
	.clear{clear:both;}
	div.checker input, input[type="search"], input[type="search"]:active {-moz-appearance: none;-webkit-appearance: checkbox;opacity:1;}
	.btn-linkedin{background:#069;}
	input[type=text], input[type=password]{color:black!important;}	
	#uniform-remember span input{float:left;margin-right:5px;}
	::-webkit-input-placeholder { color:#f00; }
	::-moz-placeholder { color:#000; } /* firefox 19+ */
	:-ms-input-placeholder { color:#f00; } /* ie */
	input:-moz-placeholder { color:#f00; }
	</style>