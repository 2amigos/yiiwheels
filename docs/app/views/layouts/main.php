<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="yii framework, yii application, yii application development, php framework, yiistrap, yiiwheels, yii framework tutorial, yii php framework, yii bootstrap, yii wheels"/>
	<meta name="language" content="en" />
	<link rel="stylesheet" type="text/css" href="<?php echo bu('/css/print.css');?>" media="print"/>
	<link href="<?php echo baseUrl('/js/google-code-prettify/prettify.css');?>" rel="stylesheet">
	<script src="<?php echo bu('/js/google-code-prettify/prettify.js');?>"></script>
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo bu('/css/ie.css');?>" media="screen, projection"/>
	<![endif]-->
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<link href="<?php echo bu('/css/styles.css');?>" rel="stylesheet" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <?php Yii::app()->bootstrap->register(); ?>

	<?php Yii::app()->less->register(); ?>
</head>

<body>
	<?php $this->widget('bootstrap.widgets.TbNavbar',array(
        'style'=>'inverse',
		'collapse'=>true,
        'items'=>array(
			array(
				'class'=>'bootstrap.widgets.TbNav',
				'items'=>array(
					array('label'=>'Home','url'=>array('/site/index')),
					array('label'=>'Link','url'=>'#'),
					array('label'=>'Link','url'=>'#'),
					array('label'=>'Dropdown','items'=>array(
						array('label'=>'Heading'),
						array('label'=>'Action','url'=>'#'),
						array('label'=>'Another action','url'=>'#'),
						array('label'=>'Something else here','url'=>'#'),
						TbHtml::menuDivider(),
						array('label'=>'Separate link','url'=>'#'),
					)),
				),
			),
	        TbHtml::navbarSearchForm('#'),
	        array(
		        'class'=>'bootstrap.widgets.TbNav',
		        'htmlOptions'=>array('class'=>'pull-right'),
		        'items'=>array(
			        array('label'=>'Link','url'=>'#'),
			        array('label'=>'Dropdown','items'=>array(
				        array('label'=>'Heading'),
				        array('label'=>'Action','url'=>'#'),
				        array('label'=>'Another action','url'=>'#'),
				        array('label'=>'Something else here','url'=>'#'),
						TbHtml::menuDivider(),
				        array('label'=>'Separate link','url'=>'#'),
			        )),
		        ),
	        ),
		),
	)); ?>

	<div id="page"><div class="container">

	    <?php echo $content; ?>

		<hr />

		<div id="footer" style="padding-bottom: 20px;">
			<div class="row">
				<div class="span6">
					&copy; Yiiwheels <?php echo date('Y'); ?><br/>
				</div>
				<div class="span6" style="text-align: right;">
					<?php echo Yii::powered(); ?>
				</div>
			</div>
		</div>

    </div></div>
</body>
</html>
