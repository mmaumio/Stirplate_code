<div class="container-fluid-full">
		<div class="row-fluid">
					
			<div class="row-fluid">
				<div class="logo-login">
					<div class="logo">
						<img src="../images/logo.png">
					</div>
					<div class="logo-title">
						<h1>Omnisci</h1><b>Science in Real Time</b>
					</div>
				</div>
				<div class="clear"></div>
				<div class="login-box">
					<h2>Register your account</h2>
					<form class="form-horizontal" action="/collaboration/register?type=omnisci" method="post">

						<fieldset>
							
							<!-- <label class="span12">Email: <?php echo $email ?></label> -->
							<input class="input-large span12" type="text" readonly value="<?php echo $email ?>" />

							<input class="input-large span12" name="password" id="password" type="password" placeholder="type password" onkeyup="checkPasswordMatch()" />
							<input class="input-large span12" name="confirm_password" id="confirm_password" type="password" placeholder="confirm password" onkeyup="checkPasswordMatch()" />
							
							<div class="clearfix"></div>
							
							<button type="submit" id="registerButton" class="btn btn-primary span12">Register</button>
							<input type="hidden" name="guid" value="<?php echo $guid;?>">
						</fieldset>
					</form>
							
					<div style="text-align:center;">Or</div>

					<form action="/collaboration/register?type=facebook" method="post">
						<button type="submit" class="btn btn-primary btn-facebook span12">Register via Facebook</button>
						<input type="hidden" name="guid" value="<?php echo $guid;?>">
					</form>
						
					<hr>
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


	<style>
	body{background:url('../images/bg.png');}
	.logo-login{width:365px;margin:0 auto;}
	.logo img {float: left;margin-left: 5px;margin-top:10px;}
	.logo-title{margin-top:55px;float:left;width:265px;}
	.logo-title h1{float: left;margin: -10px 5px 0 0;color: white;}
	.logo-title b{color:black;}
	.clear{clear:both;}
	div.checker input, input[type="search"], input[type="search"]:active {-moz-appearance: none;-webkit-appearance: checkbox;opacity:1;}
	.btn-linkedin{background:#069;}
	input[type=text], input[type=password]{color:black!important;}
	#uniform-remember span input{float:left;width: 10%!important;}
	</style>

<!--
<div>
	<form class="form-horizontal" action="/collaboration/register?type=omnisci" method="post">
			Login email: <?php echo $email ?> 
			<br>
			Password:<input class="input-large" name="password" id="password" type="password" placeholder="type password" onkeyup="checkPasswordMatch()" >
			</br>
			Confirm: <input class="input-large" name="confirm_password" id="confirm_password" type="password" placeholder="confirm password" onkeyup="checkPasswordMatch()">
			</br>
			<div class="clearfix"></div>
			<button type="submit" class="btn btn-primary" disabled="disabled" id="registerButton" >Register</button>
			<input type="hidden" name="guid" value="<?php echo $guid;?>">
	</form>
</div>
<br/>
<br/>
<div>
	or
</div>
<br/><br/>
<div>
	<form class="form-horizontal" action="/collaboration/register?type=facebook" method="post">
		<button type="submit" class="btn btn-primary btn-facebook">Register via Facebook</button>
		<input type="hidden" name="guid" value="<?php echo $guid;?>">
	</form>
</div>
-->


<script>

function checkPasswordMatch(){
		if(document.getElementById('password').value && document.getElementById('password').value == document.getElementById('confirm_password').value)
		{
			document.getElementById('registerButton').disabled = false; 
		}
		else
		{
			document.getElementById('registerButton').disabled = true; 
		}
	}
</script>