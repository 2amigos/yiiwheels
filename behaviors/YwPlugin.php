<?php
/**
 * YwPlugin class file.
 * Extends the plugins with common shared methods.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @copyright Copyright &copy; Antonio Ramirez 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package yiiwheels.widgets
 */
class YwPlugin extends CBehavior
{
	protected $_assetsUrl;

	protected static $_api;

	/**
	 * Returns
	 * @param $path
	 * @return mixed
	 */
	public function getAssetsUrl($path)
	{
		if (isset($this->_assetsUrl))
			return $this->_assetsUrl;
		else
		{
			$forceCopyAssets = $this->getApi()->forceCopyAssets;

			$assetsUrl = Yii::app()->assetManager->publish($path, false, -1, $forceCopyAssets);

			return $this->_assetsUrl = $assetsUrl;
		}
	}

	/**
	 * @return TbApi
	 */
	public function getApi()
	{
		if(self::$_api === null)
		{
			self::$_api = Yii::app()->getComponent('yiiwheels')->getApi();
		}
		return self::$_api;
	}
}