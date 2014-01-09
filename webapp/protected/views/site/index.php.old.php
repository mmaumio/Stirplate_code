<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
  <title>Stirplate.io</title>
  <link rel="stylesheet" type="text/css" href="/css/home/stylesheet.css">
  <link rel="stylesheet" type="text/css" href="/css/layout.css">
  <script type="text/javascript">  
  (function(){if(!/*@cc_on!@*/0)return;var e = "abbr,article,aside,audio,bb,canvas,datagrid,datalist,details,dialog,eventsource,figure,footer,header,hgroup,mark,menu,meter,nav,output,progress,section,time,video".split(','),i=e.length;while(i--){document.createElement(e[i])}})()
  </script>
  <!--[if lt IE 9]>
  <script src="js/html5.js"></script>
  <![endif]-->
</head>

<body>
<!--Page 1 Start-->
<section class="homePage1">
  <div class="homePage1Main">
    <div class="wrapper">
      <!--Logo For Desktop-->
      <div><a href="javascript:void(0);" title="Stirlpate" class="logo" >&nbsp;</a></div>
      <!--Logo For Responsive-->
      <div class="logoRespo"><a href="javasccript:void(0);" title="Stirplate"><img src="/img/home/logoHomeRespo.jpg" alt="Logo" /></a></div>
      
      <div class="homeRt">
        <div class="signIn">
          <h3>Sign In to Stirplate.IO</h3>
          <div class="signInMain">
            <?php if (!empty($errorMsg)) { ?>
            <div class="alert alert-danger" style="color:#D00;"><?php echo $errorMsg ?></div>
            <?php } ?>
            <form action="/auth/login" method="post">
              <input type="text" value="" name="email" placeholder="Email" />
              <input type="password" value="" name="password" placeholder="Password" />
              <label class="floatRt"><a href="javascript:void(0);">Forgot your password.</a></label>
              <input type="submit" value="SIGN IN"/>
            </form>
          </div>
        </div>
        <div class="signUp">
          <h3>Sign Up for Our newsletters</h3>
          <div class="signUpMain">
            <input type="text" value="" name="" placeholder="Email Address" />
            <input type="submit" value="SIGNUP" name="" />
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--Page 1 End--> 

<!--Page 2 Start-->
<section class="page2">
  <div class="wrapper">
    <div class="page2Main">
      <h1>Welcome to Stirplate</h1>
      <h3>Centralized data storage, open data repository and effficency tools for life scientists.</h3>
      <img src="/img/home/textShadow.png" alt="Shadow" />
      <div class="homeBoxMain">
        <div class="homeBox"> <img src="/img/home/icon1.png" alt="Icon 1" />
          <h3>Data Management</h3>
          <p>One place for all of your datasets, protocols and documents. <br/>
            (Good bye USB hard drives)</p>
        </div>
        <div class="homeBox"> <img src="/img/home/icon2.png" alt="Icon 2" />
          <h3>Simple collaboration</h3>
          <p>Type in your colaberators name, and they now have access to the study, data and files. <br/>
            (No more waiting for a response while someone is "working from home")</p>
        </div>
        <div class="homeBox homeBoxLst"> <img src="/img/home/icon3.png" alt="Icon 3" />
          <h3>Centralized communication</h3>
          <p>Discuss, assign tasks, and view progress on your experiments in one centralized area. <br/>
            (You can still email if you like, we won't judge you)</p>
        </div>
      </div>
      <div class="homeBoxMain">
        <div class="homeBox"> <img src="/img/home/icon4.png" alt="Icon 4" />
          <h3>Data Management</h3>
          <p>One place for all of your datasets, protocols and documents. <br/>
            (Good bye USB hard drives)</p>
        </div>
        <div class="homeBox"> <img src="/img/home/icon5.png" alt="Icon 5" />
          <h3>Simple collaboration</h3>
          <p>Type in your colaberators name, and they now have access to the study, data and files. <br/>
            (No more waiting for a response while someone is "working from home")</p>
        </div>
        <div class="homeBox homeBoxLst"> <img src="/img/home/icon6.png" alt="Icon 6" />
          <h3>Centralized communication</h3>
          <p>Discuss, assign tasks, and view progress on your experiments in one centralized area. <br/>
            (You can still email if you like, we won't judge you)</p>
        </div>
      </div>
    </div>
  </div>
</section>
<!--Page 2 End--> 

<!--Page 3 Start-->
<section class="page3">
  <div class="wrapper">
    <div class="page3Main">
      <div class="page3MainLft"><img src="/img/home/video.png" alt="Video" /></div>
      <div class="page3MainRt">
        <div class="page3MainRtMain">
          <h3>Demo Video</h3>
          <p>Nam aliquam facilisis gravida. Curabitur mollis eros a felis mollis laoreet. Ut vitae risus cursus, interdum enim eu, consequat odio. In quis volutpat ligula, venenatis scelerisque dui.</p>
          <p>Aliquam sit amet metus faucibus, malesuada quam egestas, accumsan diam. Nunc mattis mi sed enim pretium imperdiet.</p>
          <p>Aenean dictum nunc risus, et rhoncus orci pretium sit amet. Sed eu sodales eros</p>
        </div>
      </div>
    </div>
  </div>
</section>
<!--Page 3 End--> 

<!--Page 4 Start-->
<section class="page4">
  <div class="wrapper">
    <div class="page4Main">
      <h2>About Us</h2>
      <h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit. </h3>
      <div class="page4MainLft"> <img src="/img/home/aboutImg1.jpg" alt="About Us" />
        <h3>Keith Gonzales</h3>
        <p>Keith is a former hacker turned neuroscientist. Holding positions at Columbia University and Cornell University, Keith tends to like the finer things in life, such as powdered donuts.</p>
        <div class="aboutSmLft"> <a href="javascript:void(0);" title="Facebook"><img src="/img/home/iconFb.png" alt="Facebook" /></a> <a href="javascript:void(0);" title="Linkedin"><img src="/img/home/iconIn.png" alt="Linkedin" /></a> <a href="javascript:void(0);" title="Twitter"><img src="/img/home/iconTwt.png" alt="Twitter" /></a> </div>
      </div>
      <div class="page4MainRt"> <img src="/img/home/aboutImg2.jpg" alt="About Us" />
        <h3>Sol Chea</h3>
        <p>Sol is a polyglot coder always looking for new and interesting technologies to apply to real-world challenges. Loves food (and even considers Taco Bell and McDonalds food despite how Keith feels).</p>
        <div class="aboutSmRt"> <a href="javascript:void(0);" title="Facebook"><img src="/img/home/iconFb.png" alt="Facebook" /></a> <a href="javascript:void(0);" title="Linkedin"><img src="/img/home/iconIn.png" alt="Linkedin" /></a> <a href="javascript:void(0);" title="Twitter"><img src="/img/home/iconTwt.png" alt="Twitter" /></a> </div>
      </div>
    </div>
  </div>
</section>
<!--Page 4 End--> 

<!--Page 5 Start-->
<section class="contact">
  <div class="wrapper">
    <div class="contactMain">
      <div class="contactMainHead">
        <div class="contactMainHeadBox">
          <h2>Contact Us</h2>
          <h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit. </h3>
        </div>
      </div>
      <div class="contactForm">
        <div class="contactFormMain">
          <div class="contactFormMainLft">
            <input type="text" value="" name="" placeholder="NAME" />
            <input type="text" value="" name="" placeholder="COMPANY" />
            <input type="text" value="" name="" placeholder="EMAIL" />
          </div>
          <div class="contactFormMainRt">
            <textarea></textarea>
            <input type="submit" value="SEND" name="" />
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--Page 5 End-->
</body>
</html>