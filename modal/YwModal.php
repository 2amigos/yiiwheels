<?php
/**
 * YwModal class file.
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @copyright Copyright &copy; 2amigos.us 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package yiiwheels.widgets
 */

/**
 * Bootstrap modal + modal manager wrapper in order to use the modalmanager and easy the task of rendering a modal
 * template.
 *
 * @see http://jschr.github.com/bootstrap-modal/
 */
class YwModal extends TbModal
{

	/**
	 * Widget's initialization
	 */
	public function init()
	{
		parent::init();
		$this->attachBehavior('ywplugin', new YwPlugin());
	}

	/**
	 * Widget's run method
	 */
	public function run()
	{
		parent::run();

		$this->registerPluginFiles();
	}

	/**
	 * Registers required plugins files (js|img|css)
	 */
	public function registerPluginFiles()
	{
		/* publish assets dir */
		$path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
		$assetsUrl = $this->getAssetsUrl($path);

		/* @var $cs CClientScript */
		$cs = Yii::app()->getClientScript();

		$cs->registerCssFile($assetsUrl . '/css/bootstrap-modal.css');
		$cs->registerScriptFile($assetsUrl . '/js/bootstrap-modal.js');
		$cs->registerScriptFile($assetsUrl . '/js/bootstrap-modalmanager.js');
	}

}