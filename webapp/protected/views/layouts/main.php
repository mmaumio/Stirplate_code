<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<link rel="stylesheet" type="text/css" href="/css/layout.css">
    <link href='http://fonts.googleapis.com/css?family=Exo+2:400,300' rel='stylesheet' type='text/css'>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
        <?php 
                $controller = Yii::app()->getController();
                $isHome = $controller->getId() === 'site' && $controller->getAction()->getId() === 'index' || $controller->getAction()->getId() === 'newsletter';
                if($isHome){
        ?>
        <link rel="stylesheet" type="text/css" href="/css/home/stylesheet.css">
        <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
        <?php }else{ ?>
	<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
    
        <link rel="stylesheet" type="text/css" href="/css/bootstrap-theme.min.css">
        <link rel="stylesheet" type="text/css" href="/css/stylesheet.css">
        <link rel="stylesheet" type="text/css" href="/css/select2.css">
        <?php } ?>

        <script type="text/javascript" src="/css/select2.min.js"></script>
        <script type="text/javascript" src="/css/jquery.textcomplete.min.js"></script>
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">

	<script type="text/javascript">  
            function downloadFile(path){
                    //alert(path);

                    var a = $("<a>").attr("href", path).attr("download", "").appendTo("body");
                    a[0].click();
                    a.remove();
            }
            
        </script>	

</head> 
<body>

<?php $this->widget('ext.AnalyticsTrackingWidget');?>
<?php echo $content; ?>
<script type="text/javascript" src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>  
</body>
</html>
