<?php
/**
 * WhFileUpload widget class
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @copyright Copyright &copy; 2amigos.us 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package YiiWheels.widgets
 * @uses YiiWheels.helpers.WhHtml
 */
Yii::import('yiiwheels.helpers.WhHtml');
Yii::import('zii.widgets.jui.CJuiInputWidget');

class WhFileUpload extends CJuiInputWidget
{
	/**
	 * the url to the upload handler
	 * @var string
	 */
	public $url;

	/**
	 * set to true to use multiple file upload
	 * @var boolean
	 */
	public $multiple = false;

	/**
	 * The upload template id to display files available for upload
	 * defaults to null, meaning using the built-in template
	 */
	public $uploadTemplate;

	/**
	 * The template id to display files available for download
	 * defaults to null, meaning using the built-in template
	 */
	public $downloadTemplate;

	/**
	 * Wheter or not to preview image files before upload
	 */
	public $previewImages = true;

	/**
	 * Wheter or not to add the image processing pluing
	 */
	public $imageProcessing = true;

	/**
	 * @var string name of the form view to be rendered
	 */
	public $formView = 'yiiwheels.fileupload.views.fileupload.form';

	/**
	 * @var string name of the upload view to be rendered
	 */
	public $uploadView = 'yiiwheels.fileupload.views.fileupload.upload';

	/**
	 * @var string name of the download view to be rendered
	 */
	public $downloadView = 'yiiwheels.fileupload.views.fileupload.download';

	/**
	 * @var string name of the view to display images at bootstrap-slideshow
	 */
	public $previewImagesView = 'yiiwheels.fileupload.views.gallery.preview';

	/**
	 * Widget initialization
	 */
	public function init()
	{
		$this->attachBehavior('ywplugin', array('class' => 'yiiwheels.behaviors.WhPlugin'));

		if ($this->uploadTemplate === null)
		{
			$this->uploadTemplate = "#template-upload";
		}

		if ($this->downloadTemplate === null)
		{
			$this->downloadTemplate = "#template-download";
		}

		if (!isset($this->htmlOptions['enctype']))
		{
			$this->htmlOptions['enctype'] = 'multipart/form-data';
		}
		parent::init();
	}

	/**
	 * Generates the required HTML and Javascript
	 */
	public function run()
	{

		list($name, $id) = $this->resolveNameID();

		$this->htmlOptions['id'] = ($this->hasModel()? get_class($this->model): 'fileupload') . '-form';

		$this->options['url'] = $this->url;

		$htmlOptions = array();

		if ($this->multiple)
		{
			$htmlOptions["multiple"] = true;
		}

		$this->render($this->uploadView);
		$this->render($this->downloadView);
		$this->render($this->formView, compact('htmlOptions'));

		if ($this->previewImages || $this->imageProcessing)
		{
			$this->render($this->previewImagesView);
		}

		$this->registerClientScript();
	}

	/**
	 * Registers and publishes required scripts
	 */
	public function registerClientScript()
	{

		/* publish assets dir */
		$path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
		$assetsUrl = $this->getAssetsUrl($path);

		/* @var $cs CClientScript */
		$cs = Yii::app()->getClientScript();

		$cs->registerCssFile($assetsUrl . '/css/jquery.fileupload-ui.css');

		// Upgrade widget factory
		// @todo remove when jquery.ui 1.9+ is fully integrated into stable Yii versions
		$cs->registerScriptFile($assetsUrl . '/js/vendor/jquery.ui.widget.js');

		//The Templates plugin is included to render the upload/download listings
		$cs->registerScriptFile($assetsUrl . '/js/tmpl.min.js', CClientScript::POS_END);

		if ($this->previewImages || $this->imageProcessing)
		{
			$cs->registerScriptFile($assetsUrl . '/js/load-image.min.js', CClientScript::POS_END);
			$cs->registerScriptFile($assetsUrl . '/js/canvas-to-blob.min.js', CClientScript::POS_END);
			// gallery :)
			$this->getApi()->registerAssetCss("bootstrap-image-gallery.min.css");
			$this->getApi()->registerAssetJs("bootstrap-image-gallery.min.js", CClientScript::POS_END);
		}
		//The Iframe Transport is required for browsers without support for XHR file uploads
		Yii::app()->bootstrap->registerAssetJs('fileupload/jquery.iframe-transport.js');
		Yii::app()->bootstrap->registerAssetJs('fileupload/jquery.fileupload.js');

		// The File Upload image processing plugin
		if ($this->imageProcessing)
		{
			$cs->registerScriptFile($assetsUrl . '/js/jquery.fileupload-ip.js');
		}
		// The File Upload file processing plugin
		if($this->previewImages)
		{
			$cs->registerScriptFile($assetsUrl . '/js/jquery.fileupload-fp.js');
		}
		// locale
		$cs->registerScriptFile($assetsUrl . '/js/jquery.fileupload-locale.js');

		//The File Upload user interface plugin
		$cs->registerScriptFile($assetsUrl . '/js/jquery.fileupload-ui.js');

		/* initialize plugin */
		$selector = '#' . WhHtml::getOption('id', $this->htmlOptions, $this->getId());

		$this->getYiiWheels()->registerPlugin('fileupload', $selector, $this->options );
	}

}