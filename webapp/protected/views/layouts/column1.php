<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<header>
  <div class="wrapper">
      <?php if(Yii::app()->user->isGuest){ ?>
      <div class="logo"><a href="/" title="Stirplate"><img src="/img/nav/logo.png" alt="Stirplate" /></a></div>
       <?php }else{ ?>
       <div class="logo"><a href="<?php echo Yii::app()->createUrl('project/dashboard') ?>" title="Stirplate"><img src="/img/nav/logo.png" alt="Stirplate" /></a></div>
       <?php } ?>
      <div class="headerNav">
        <?php if(!Yii::app()->user->isGuest){ ?>
          <div class="btn-group">
              <a  class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                  <img src="/img/nav/iconNav3.png" alt="icon" />
                  <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                  <li><a href="<?php echo $this->createUrl('user/profile') ?>" title="profile" >My Profile</a></li>
                  <li><a href="#help" title="help" >Help</a></li>
                  <li><a href="<?php echo $this->createUrl('auth/logout') ?>" title="Logout">Logout</a></li>
              </ul>
          </div>
        <?php } ?>
      </div>
  </div>
</header>
	<?php echo $content; ?>
<?php $this->endContent(); ?>