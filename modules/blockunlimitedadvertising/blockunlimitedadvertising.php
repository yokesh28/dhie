<?php
/*
* 2007-2012 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2012 PrestaShop SA
*  @version  Release: $Revision: 17616 $
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

/**
 * @since 1.5.0
 * @version 1.2 (2012-03-14)
 */

if (!defined('_PS_VERSION_'))
	exit;

include_once(_PS_MODULE_DIR_.'blockunlimitedadvertising/HomeAdvert.php');

class BlockUnlimitedadvertising extends Module
{
	private $_html = '';

	public function __construct()
	{
		$this->name = 'blockunlimitedadvertising';
		$this->tab = 'front_office_features';
		$this->version = '2.0';
		$this->author = 'Dapurpixel';
		$this->need_instance = 0;
		$this->secure_key = Tools::encrypt($this->name);

		parent::__construct();

		$this->displayName = $this->l('Block Unlimited Advertising');
		$this->description = $this->l('Display ads or banner in homepage.');
	}

	/**
	 * @see Module::install()
	 */
	public function install()
	{
		/* Adds Module */
		if (parent::install() && $this->registerHook('displayHome') && $this->registerHook('header') && $this->registerHook('actionShopDataDuplication'))
		{
			@copy(_PS_MODULE_DIR_ . $this->name . '/advertising_custom1.jpg', _PS_MODULE_DIR_ . $this->name . '/images/advertising_custom1.jpg');
			@copy(_PS_MODULE_DIR_ . $this->name . '/advertising_custom2.jpg', _PS_MODULE_DIR_ . $this->name . '/images/advertising_custom2.jpg');
			/* Creates tables */
			$res &= $this->createTables();

		
			return $res;
		}
		return false;
	}


	/**
	 * @see Module::uninstall()
	 */
	public function uninstall()
	{
		/* Deletes Module */
		if (parent::uninstall())
		{
			/* Deletes tables */
			$res = $this->deleteTables();
			/* Unsets configuration */
			return $res;
		}
		return false;
	}

	/**
	 * Creates tables
	 */
	protected function createTables()
	{
		/* Slides */
		$res = (bool)Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'blockunlimitedadvertising` (
				`id_blockunlimitedadvertising_advert` int(10) unsigned NOT NULL AUTO_INCREMENT,
				`id_shop` int(10) unsigned NOT NULL,
				PRIMARY KEY (`id_blockunlimitedadvertising_advert`, `id_shop`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
				INSERT INTO `'._DB_PREFIX_.'blockunlimitedadvertising` (
				`id_blockunlimitedadvertising_advert`,
				`id_shop`) VALUES (1,1),(2,1); 
		');

		/* Slides configuration */
		$res &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'blockunlimitedadvertising_advert` (
			  `id_blockunlimitedadvertising_advert` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `position` int(10) unsigned NOT NULL DEFAULT \'0\',
			  `active` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
			  PRIMARY KEY (`id_blockunlimitedadvertising_advert`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
			
				INSERT INTO `'._DB_PREFIX_.'blockunlimitedadvertising_advert` (
				`id_blockunlimitedadvertising_advert`,
				`position`,
				`active`
				) VALUES (1,1,1),(2,1,1); 
		');

		/* Slides lang configuration */
		$res &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'blockunlimitedadvertising_advert_lang` (
			  `id_blockunlimitedadvertising_advert` int(10) unsigned NOT NULL,
			  `id_lang` int(10) unsigned NOT NULL,
			  `title` varchar(255) NOT NULL,
			  `description` text NOT NULL,
			  `legend` varchar(255) NOT NULL,
			  `url` varchar(255) NOT NULL,
			  `image` varchar(255) NOT NULL,
			  PRIMARY KEY (`id_blockunlimitedadvertising_advert`,`id_lang`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
			
		INSERT INTO `'._DB_PREFIX_.'blockunlimitedadvertising_advert_lang` (
				`id_blockunlimitedadvertising_advert`,
				`id_lang`,
				`title`,
				`description`,
				`legend`,
				`url`,
				`image`
				) VALUES 
				(1,1,"sample title1","sample desc1","sample image1","http://www.dapurpixel.com","advertising_custom1.jpg"),
				(1,2,"sample title1","sample desc1","sample image1","http://www.dapurpixel.com","advertising_custom1.jpg"),
				(1,3,"sample title1","sample desc1","sample image1","http://www.dapurpixel.com","advertising_custom1.jpg"),
				(1,4,"sample title1","sample desc1","sample image1","http://www.dapurpixel.com","advertising_custom1.jpg"),
				(1,5,"sample title1","sample desc1","sample image1","http://www.dapurpixel.com","advertising_custom1.jpg"),
				(1,6,"sample title1","sample desc1","sample image1","http://www.dapurpixel.com","advertising_custom1.jpg"),
				(2,1,"sample title2","sample desc2","sample image2","http://www.dapurpixel.com","advertising_custom2.jpg"),
				(2,2,"sample title2","sample desc2","sample image2","http://www.dapurpixel.com","advertising_custom2.jpg"),
				(2,3,"sample title2","sample desc2","sample image2","http://www.dapurpixel.com","advertising_custom2.jpg"),
				(2,4,"sample title2","sample desc2","sample image2","http://www.dapurpixel.com","advertising_custom2.jpg"),
				(2,5,"sample title2","sample desc2","sample image2","http://www.dapurpixel.com","advertising_custom2.jpg"),
				(2,6,"sample title2","sample desc2","sample image2","http://www.dapurpixel.com","advertising_custom2.jpg")
				; 

		');

		return $res;
	}
	/**
	 * deletes tables
	 */
	protected function deleteTables()
	{
		$advert = $this->getSlides();
		foreach ($advert as $advertblock)
		{
			$to_del = new HomeAdvert($advertblock['id_advertblock']);
			$to_del->delete();
		}
		return Db::getInstance()->execute('
			DROP TABLE IF EXISTS `'._DB_PREFIX_.'blockunlimitedadvertising`, `'._DB_PREFIX_.'blockunlimitedadvertising_advert`, `'._DB_PREFIX_.'blockunlimitedadvertising_advert_lang`;
		');
	}

	public function getContent()
	{
		$this->_html .= $this->headerHTML();
		$this->_html .= '<h2>'.$this->displayName.'.</h2>';

		/* Validate & process */
		if (Tools::isSubmit('submitAdvertBlock') || Tools::isSubmit('delete_id_advertblock') ||
			Tools::isSubmit('submitAdvertBlockr') ||
			Tools::isSubmit('changeStatus'))
		{
			if ($this->_postValidation())
				$this->_postProcess();
			$this->_displayForm();
		}
		elseif (Tools::isSubmit('addSlide') || (Tools::isSubmit('id_advertblock') && $this->advertblockExists((int)Tools::getValue('id_advertblock'))))
			$this->_displayAddForm();
		else
			$this->_displayForm();

		return $this->_html;
	}

	private function _displayForm()
	{
		/* Gets Slides */
		$advert = $this->getSlides();

		/* Begin fieldset advert */
		$this->_html .= '
		<fieldset>
			<legend><img src="'._PS_BASE_URL_.__PS_BASE_URI__.'modules/'.$this->name.'/logo.gif" alt="" /> '.$this->l('Advertising configuration').'</legend>
			<strong>
				<a href="'.AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&addSlide">
					<img src="'._PS_ADMIN_IMG_.'add.gif" alt="" /> '.$this->l('Add new advert').'
				</a>
			</strong>';

		/* Display notice if there are no advert yet */
		if (!$advert)
			$this->_html .= '<p style="margin-left: 40px;">'.$this->l('You have not added any advert yet.').'</p>';
		else /* Display advert */
		{
			$this->_html .= '
			<div id="advertContent" style="width: 400px; margin-top: 30px;">
				<ul id="advert">';

			foreach ($advert as $advertblock)
			{
				$this->_html .= '
					<li id="advert_'.$advertblock['id_advertblock'].'">
						<strong>#'.$advertblock['id_advertblock'].'</strong> '.$advertblock['title'].'
						<p style="float: right">'.
							$this->displayStatus($advertblock['id_advertblock'], $advertblock['active']).'
							<a href="'.AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&id_advertblock='.(int)($advertblock['id_advertblock']).'" title="'.$this->l('Edit').'"><img src="'._PS_ADMIN_IMG_.'edit.gif" alt="" /></a>
							<a href="'.AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&delete_id_advertblock='.(int)($advertblock['id_advertblock']).'" title="'.$this->l('Delete').'"><img src="'._PS_ADMIN_IMG_.'delete.gif" alt="" /></a>
						</p>
					</li>';
			}
			$this->_html .= '</ul></div>';
		}
		// End fieldset
		$this->_html .= '</fieldset>';
	}

	private function _displayAddForm()
	{
		/* Sets Slide : depends if edited or added */
		$advertblock = null;
		if (Tools::isSubmit('id_advertblock') && $this->advertblockExists((int)Tools::getValue('id_advertblock')))
			$advertblock = new HomeAdvert((int)Tools::getValue('id_advertblock'));
		/* Checks if directory is writable */
		if (!is_writable('.'))
			$this->adminDisplayWarning(sprintf($this->l('modules %s must be writable (CHMOD 755 / 777)'), $this->name));

		/* Gets languages and sets which div requires translations */
		$id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');
		$languages = Language::getLanguages(false);
		$divLangName = 'image¤title¤url¤legend¤description';
		$this->_html .= '<script type="text/javascript">id_language = Number('.$id_lang_default.');</script>';

		/* Form */
		$this->_html .= '<form action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'" method="post" enctype="multipart/form-data">';

		/* Fieldset Upload */
		$this->_html .= '
		<fieldset class="width3">
			<br />
			<legend><img src="'._PS_ADMIN_IMG_.'add.gif" alt="" />1 - '.$this->l('Upload your image').'</legend>';
		/* Image */
		$this->_html .= '<label>'.$this->l('Select a file:').' * </label><div class="margin-form">';
		foreach ($languages as $language)
		{
			$this->_html .= '<div id="image_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $id_lang_default ? 'block' : 'none').';float: left;">';
			$this->_html .= '<input type="file" name="image_'.$language['id_lang'].'" id="image_'.$language['id_lang'].'" size="30" value="'.(isset($advertblock->image[$language['id_lang']]) ? $advertblock->image[$language['id_lang']] : '').'"/>';
			/* Sets image as hidden in case it does not change */
			if ($advertblock && $advertblock->image[$language['id_lang']])
				$this->_html .= '<input type="hidden" name="image_old_'.$language['id_lang'].'" value="'.($advertblock->image[$language['id_lang']]).'" id="image_old_'.$language['id_lang'].'" />';
			/* Display image */
			if ($advertblock && $advertblock->image[$language['id_lang']])
				$this->_html .= '<input type="hidden" name="has_picture" value="1" /><img src="'.__PS_BASE_URI__.'modules/'.$this->name.'/images/'.$advertblock->image[$language['id_lang']].'" width="'.(Configuration::get('BLOCKBANNER_WIDTH')/2).'" height="'.(Configuration::get('BLOCKBANNER_HEIGHT')/2).'" alt=""/>';
			$this->_html .= '</div>';
		}
		$this->_html .= $this->displayFlags($languages, $id_lang_default, $divLangName, 'image', true);
		/* End Fieldset Upload */
		$this->_html .= '</fieldset><br /><br />';

		/* Fieldset edit/add */
		$this->_html .= '<fieldset class="width3">';
		if (Tools::isSubmit('addSlide')) /* Configure legend */
			$this->_html .= '<legend><img src="'._PS_ADMIN_IMG_.'add.gif" alt="" /> 2 - '.$this->l('Configure your advertblock').'</legend>';
		elseif (Tools::isSubmit('id_advertblock')) /* Edit legend */
			$this->_html .= '<legend><img src="'._PS_BASE_URL_.__PS_BASE_URI__.'modules/'.$this->name.'/logo.gif" alt="" /> 2 - '.$this->l('Edit your image description').'</legend>';
		/* Sets id advertblock as hidden */
		if ($advertblock && Tools::getValue('id_advertblock'))
			$this->_html .= '<input type="hidden" name="id_advertblock" value="'.$advertblock->id.'" id="id_advertblock" />';
		/* Sets position as hidden */
		$this->_html .= '<input type="hidden" name="position" value="'.(($advertblock != null) ? ($advertblock->position) : ($this->getNextPosition())).'" id="position" />';

		/* Form content */
		/* Title */
		$this->_html .= '<br /><label>'.$this->l('Title:').' * </label><div class="margin-form">';
		foreach ($languages as $language)
		{
			$this->_html .= '
					<div id="title_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $id_lang_default ? 'block' : 'none').';float: left;">
						<input type="text" name="title_'.$language['id_lang'].'" id="title_'.$language['id_lang'].'" size="30" value="'.(isset($advertblock->title[$language['id_lang']]) ? $advertblock->title[$language['id_lang']] : '').'"/>
					</div>';
		}
		$this->_html .= $this->displayFlags($languages, $id_lang_default, $divLangName, 'title', true);
		$this->_html .= '</div><br /><br />';

		/* URL */
		$this->_html .= '<label>'.$this->l('URL:').' * </label><div class="margin-form">';
		foreach ($languages as $language)
		{
			$this->_html .= '
					<div id="url_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $id_lang_default ? 'block' : 'none').';float: left;">
						<input type="text" name="url_'.$language['id_lang'].'" id="url_'.$language['id_lang'].'" size="30" value="'.(isset($advertblock->url[$language['id_lang']]) ? $advertblock->url[$language['id_lang']] : '').'"/>
					</div>';
		}
		$this->_html .= $this->displayFlags($languages, $id_lang_default, $divLangName, 'url', true);
		$this->_html .= '</div><br /><br />';

		/* Legend */
		$this->_html .= '<label>'.$this->l('Alternative Text:').' * </label><div class="margin-form">';
		foreach ($languages as $language)
		{
			$this->_html .= '
					<div id="legend_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $id_lang_default ? 'block' : 'none').';float: left;">
						<input type="text" name="legend_'.$language['id_lang'].'" id="legend_'.$language['id_lang'].'" size="30" value="'.(isset($advertblock->legend[$language['id_lang']]) ? $advertblock->legend[$language['id_lang']] : '').'"/>
					</div>';
		}
		$this->_html .= $this->displayFlags($languages, $id_lang_default, $divLangName, 'legend', true);
		$this->_html .= '</div><br /><br />';

		/* Description */
		$this->_html .= '
		<label>'.$this->l('Description:').' </label>
		<div class="margin-form">';
		foreach ($languages as $language)
		{
			$this->_html .= '<div id="description_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $id_lang_default ? 'block' : 'none').';float: left;">
				<textarea name="description_'.$language['id_lang'].'" rows="10" cols="29">'.(isset($advertblock->description[$language['id_lang']]) ? $advertblock->description[$language['id_lang']] : '').'</textarea>
			</div>';
		}
		$this->_html .= $this->displayFlags($languages, $id_lang_default, $divLangName, 'description', true);
		$this->_html .= '</div><div class="clear"></div><br />';

		/* Active */
		$this->_html .= '
		<label for="active_on">'.$this->l('Active:').'</label>
		<div class="margin-form">
			<img src="../img/admin/enabled.gif" alt="Yes" title="Yes" />
			<input type="radio" name="active_advertblock" id="active_on" '.(($advertblock && (isset($advertblock->active) && (int)$advertblock->active == 0)) ? '' : 'checked="checked" ').' value="1" />
			<label class="t" for="active_on">'.$this->l('Yes').'</label>
			<img src="../img/admin/disabled.gif" alt="No" title="No" style="margin-left: 10px;" />
			<input type="radio" name="active_advertblock" id="active_off" '.(($advertblock && (isset($advertblock->active) && (int)$advertblock->active == 0)) ? 'checked="checked" ' : '').' value="0" />
			<label class="t" for="active_off">'.$this->l('No').'</label>
		</div>';

		/* Save */
		$this->_html .= '
		<p class="center">
			<input type="submit" class="button" name="submitAdvertBlock" value="'.$this->l('Save').'" />
			<a class="button" style="position:relative; padding:3px 3px 4px 3px; top:1px" href="'.AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'">'.$this->l('Cancel').'</a>
		</p>';

		/* End of fieldset & form */
		$this->_html .= '
			<p>*'.$this->l('Required fields').'</p>
			</fieldset>
		</form>';
	}

	private function _postValidation()
	{
		$errors = array();

		/* Validation for Slider configuration */
		if (Tools::isSubmit('submitAdvertBlockr'))
		{

			if (!Validate::isInt(Tools::getValue('BLOCKBANNER_SPEED')) || !Validate::isInt(Tools::getValue('BLOCKBANNER_PAUSE')) ||
				!Validate::isInt(Tools::getValue('BLOCKBANNER_WIDTH')) || !Validate::isInt(Tools::getValue('BLOCKBANNER_HEIGHT')))
					$errors[] = $this->l('Invalid values');
		} /* Validation for status */
		elseif (Tools::isSubmit('changeStatus'))
		{
			if (!Validate::isInt(Tools::getValue('id_advertblock')))
				$errors[] = $this->l('Invalid advertblock');
		}
		/* Validation for Slide */
		elseif (Tools::isSubmit('submitAdvertBlock'))
		{
			/* Checks state (active) */
			if (!Validate::isInt(Tools::getValue('active_advertblock')) || (Tools::getValue('active_advertblock') != 0 && Tools::getValue('active_advertblock') != 1))
				$errors[] = $this->l('Invalid advertblock state');
			/* Checks position */
			if (!Validate::isInt(Tools::getValue('position')) || (Tools::getValue('position') < 0))
				$errors[] = $this->l('Invalid advertblock position');
			/* If edit : checks id_advertblock */
			if (Tools::isSubmit('id_advertblock'))
			{
				if (!Validate::isInt(Tools::getValue('id_advertblock')) && !$this->advertblockExists(Tools::getValue('id_advertblock')))
					$errors[] = $this->l('Invalid id_advertblock');
			}
			/* Checks title/url/legend/description/image */
			$languages = Language::getLanguages(false);
			foreach ($languages as $language)
			{
				if (strlen(Tools::getValue('title_'.$language['id_lang'])) > 40)
					$errors[] = $this->l('Title is too long');
				if (strlen(Tools::getValue('legend_'.$language['id_lang'])) > 40)
					$errors[] = $this->l('Legend is too long');
				if (strlen(Tools::getValue('url_'.$language['id_lang'])) > 200)
					$errors[] = $this->l('URL is too long');
				if (strlen(Tools::getValue('description_'.$language['id_lang'])) > 400)
					$errors[] = $this->l('Description is too long');
				if (strlen(Tools::getValue('url_'.$language['id_lang'])) > 0 && !Validate::isUrl(Tools::getValue('url_'.$language['id_lang'])))
					$errors[] = $this->l('URL format is not correct');
				if (Tools::getValue('image_'.$language['id_lang']) != null && !Validate::isFileName(Tools::getValue('image_'.$language['id_lang'])))
					$errors[] = $this->l('Invalid filename');
				if (Tools::getValue('image_old_'.$language['id_lang']) != null && !Validate::isFileName(Tools::getValue('image_old_'.$language['id_lang'])))
					$errors[] = $this->l('Invalid filename');
			}

			/* Checks title/url/legend/description for default lang */
			$id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');
			if (strlen(Tools::getValue('title_'.$id_lang_default)) == 0)
				$errors[] = $this->l('Title is not set');
			if (strlen(Tools::getValue('legend_'.$id_lang_default)) == 0)
				$errors[] = $this->l('Legend is not set');
			if (strlen(Tools::getValue('url_'.$id_lang_default)) == 0)
				$errors[] = $this->l('URL is not set');
			if (!Tools::isSubmit('has_picture') && (!isset($_FILES['image_'.$id_lang_default]) || empty($_FILES['image_'.$id_lang_default]['tmp_name'])))
				$errors[] = $this->l('Image is not set');
			if (Tools::getValue('image_old_'.$id_lang_default) && !Validate::isFileName(Tools::getValue('image_old_'.$id_lang_default)))
				$errors[] = $this->l('Image is not set');
		} /* Validation for deletion */
		elseif (Tools::isSubmit('delete_id_advertblock') && (!Validate::isInt(Tools::getValue('delete_id_advertblock')) || !$this->advertblockExists((int)Tools::getValue('delete_id_advertblock'))))
			$errors[] = $this->l('Invalid id_advertblock');

		/* Display errors if needed */
		if (count($errors))
		{
			$this->_html .= $this->displayError(implode('<br />', $errors));
			return false;
		}

		/* Returns if validation is ok */
		return true;
	}

	private function _postProcess()
	{
		$errors = array();

		/* Processes Slider */
		if (Tools::isSubmit('submitAdvertBlockr'))
		{
			$res = Configuration::updateValue('BLOCKBANNER_WIDTH', (int)Tools::getValue('BLOCKBANNER_WIDTH'));
			$res &= Configuration::updateValue('BLOCKBANNER_HEIGHT', (int)Tools::getValue('BLOCKBANNER_HEIGHT'));
			$res &= Configuration::updateValue('BLOCKBANNER_SPEED', (int)Tools::getValue('BLOCKBANNER_SPEED'));
			$res &= Configuration::updateValue('BLOCKBANNER_PAUSE', (int)Tools::getValue('BLOCKBANNER_PAUSE'));
			$res &= Configuration::updateValue('BLOCKBANNER_LOOP', (int)Tools::getValue('BLOCKBANNER_LOOP'));
			if (!$res)
				$errors[] = $this->displayError($this->l('Configuration could not be updated'));
			$this->_html .= $this->displayConfirmation($this->l('Configuration updated'));
		} /* Process Slide status */
		elseif (Tools::isSubmit('changeStatus') && Tools::isSubmit('id_advertblock'))
		{
			$advertblock = new HomeAdvert((int)Tools::getValue('id_advertblock'));
			if ($advertblock->active == 0)
				$advertblock->active = 1;
			else
				$advertblock->active = 0;
			$res = $advertblock->update();
			$this->_html .= ($res ? $this->displayConfirmation($this->l('Configuration updated')) : $this->displayError($this->l('Configuration could not be updated')));
		}
		/* Processes Slide */
		elseif (Tools::isSubmit('submitAdvertBlock'))
		{
			/* Sets ID if needed */
			if (Tools::getValue('id_advertblock'))
			{
				$advertblock = new HomeAdvert((int)Tools::getValue('id_advertblock'));
				if (!Validate::isLoadedObject($advertblock))
				{
					$this->_html .= $this->displayError($this->l('Invalid id_advertblock'));
					return;
				}
			}
			else
				$advertblock = new HomeAdvert();
			/* Sets position */
			$advertblock->position = (int)Tools::getValue('position');
			/* Sets active */
			$advertblock->active = (int)Tools::getValue('active_advertblock');

			/* Sets each langue fields */
			$languages = Language::getLanguages(false);
			foreach ($languages as $language)
			{
				if (Tools::getValue('title_'.$language['id_lang']) != '')
					$advertblock->title[$language['id_lang']] = pSQL(Tools::getValue('title_'.$language['id_lang']));
				if (Tools::getValue('url_'.$language['id_lang']) != '')
					$advertblock->url[$language['id_lang']] = pSQL(Tools::getValue('url_'.$language['id_lang']));
				if (Tools::getValue('legend_'.$language['id_lang']) != '')
					$advertblock->legend[$language['id_lang']] = pSQL(Tools::getValue('legend_'.$language['id_lang']));
				if (Tools::getValue('description_'.$language['id_lang']) != '')
					$advertblock->description[$language['id_lang']] = pSQL(Tools::getValue('description_'.$language['id_lang']));
				/* Uploads image and sets advertblock */
				$type = strtolower(substr(strrchr($_FILES['image_'.$language['id_lang']]['name'], '.'), 1));
				$imagesize = array();
				$imagesize = @getimagesize($_FILES['image_'.$language['id_lang']]['tmp_name']);
				if (isset($_FILES['image_'.$language['id_lang']]) &&
					isset($_FILES['image_'.$language['id_lang']]['tmp_name']) &&
					!empty($_FILES['image_'.$language['id_lang']]['tmp_name']) &&
					!empty($imagesize) &&
					in_array(strtolower(substr(strrchr($imagesize['mime'], '/'), 1)), array('jpg', 'gif', 'jpeg', 'png')) &&
					in_array($type, array('jpg', 'gif', 'jpeg', 'png')))
				{
					$temp_name = tempnam(_PS_TMP_IMG_DIR_, 'PS');
					$salt = sha1(microtime());
					if ($error = ImageManager::validateUpload($_FILES['image_'.$language['id_lang']]))
						$errors[] = $error;
					elseif (!$temp_name || !move_uploaded_file($_FILES['image_'.$language['id_lang']]['tmp_name'], $temp_name))
						return false;
					elseif (!ImageManager::resize($temp_name, dirname(__FILE__).'/images/'.Tools::encrypt($_FILES['image_'.$language['id_lang']]['name'].$salt).'.'.$type))
						$errors[] = $this->displayError($this->l('An error occurred during the image upload.'));
					if (isset($temp_name))
						@unlink($temp_name);
					$advertblock->image[$language['id_lang']] = pSQL(Tools::encrypt($_FILES['image_'.($language['id_lang'])]['name'].$salt).'.'.$type);
				}
				elseif (Tools::getValue('image_old_'.$language['id_lang']) != '')
					$advertblock->image[$language['id_lang']] = pSQL(Tools::getValue('image_old_'.$language['id_lang']));
			}

			/* Processes if no errors  */
			if (!$errors)
			{
				/* Adds */
				if (!Tools::getValue('id_advertblock'))
				{
					if (!$advertblock->add())
						$errors[] = $this->displayError($this->l('Slide could not be added'));
				} /* Update */
				elseif (!$advertblock->update())
					$errors[] = $this->displayError($this->l('Slide could not be updated'));
			}
		} /* Deletes */
		elseif (Tools::isSubmit('delete_id_advertblock'))
		{
			$advertblock = new HomeAdvert((int)Tools::getValue('delete_id_advertblock'));
			$res = $advertblock->delete();
			if (!$res)
				$this->_html .= $this->displayError('Could not delete');
			else
				$this->_html .= $this->displayConfirmation($this->l('Slide deleted'));
		}

		/* Display errors if needed */
		if (count($errors))
			$this->_html .= $this->displayError(implode('<br />', $errors));
		elseif (Tools::isSubmit('submitAdvertBlock') && Tools::getValue('id_advertblock'))
			$this->_html .= $this->displayConfirmation($this->l('Slide updated'));
		elseif (Tools::isSubmit('submitAdvertBlock'))
			$this->_html .= $this->displayConfirmation($this->l('Slide added'));
	}

	private function _prepareHook()
	{
		$advertblockr = array(
			'width' => Configuration::get('BLOCKBANNER_WIDTH'),
			'height' => Configuration::get('BLOCKBANNER_HEIGHT'),
			'speed' => Configuration::get('BLOCKBANNER_SPEED'),
			'pause' => Configuration::get('BLOCKBANNER_PAUSE'),
			'loop' => Configuration::get('BLOCKBANNER_LOOP'),
		);

		$advert = $this->getSlides(true);
		if (!$advert)
			return false;

		$this->smarty->assign('blockunlimitedadvertising_advert', $advert);
		$this->smarty->assign('blockunlimitedadvertising', $advertblockr);
		return true;
	}

	public function hookDisplayHome()
	{
		if(!$this->_prepareHook())
			return;

		// Check if not a mobile theme
		if ($this->context->getMobileDevice() != false)
			return false;

		return $this->display(__FILE__, 'blockunlimitedadvertising.tpl');
	}

	public function hookActionShopDataDuplication($params)
	{
		Db::getInstance()->execute('
		INSERT IGNORE INTO '._DB_PREFIX_.'blockunlimitedadvertising (id_blockunlimitedadvertising_advert, id_shop)
		SELECT id_blockunlimitedadvertising_advert, '.(int)$params['new_id_shop'].'
		FROM '._DB_PREFIX_.'blockunlimitedadvertising
		WHERE id_shop = '.(int)$params['old_id_shop']);
	}

	public function headerHTML()
	{
		if (Tools::getValue('controller') != 'AdminModules' && Tools::getValue('configure') != $this->name)
			return;

		$this->context->controller->addJqueryUI('ui.sortable');
		/* Style & js for fieldset 'advert configuration' */
		$html = '
		<style>
		#advert li {
			list-style: none;
			margin: 0 0 4px 0;
			padding: 10px;
			background-color: #F4E6C9;
			border: #CCCCCC solid 1px;
			color:#000;
		}
		</style>
		<script type="text/javascript" src="'.__PS_BASE_URI__.'js/jquery/jquery-ui.will.be.removed.in.1.6.js"></script>
		<script type="text/javascript">
			$(function() {
				var $mySlides = $("#advert");
				$mySlides.sortable({
					opacity: 0.6,
					cursor: "move",
					update: function() {
						var order = $(this).sortable("serialize") + "&action=updateSlidesPosition";
						$.post("'._PS_BASE_URL_.__PS_BASE_URI__.'modules/'.$this->name.'/ajax_'.$this->name.'.php?secure_key='.$this->secure_key.'", order);
						}
					});
				$mySlides.hover(function() {
					$(this).css("cursor","move");
					},
					function() {
					$(this).css("cursor","auto");
				});
			});
		</script>';

		return $html;
	}

	public function getNextPosition()
	{
		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
				SELECT MAX(hss.`position`) AS `next_position`
				FROM `'._DB_PREFIX_.'blockunlimitedadvertising_advert` hss, `'._DB_PREFIX_.'blockunlimitedadvertising` hs
				WHERE hss.`id_blockunlimitedadvertising_advert` = hs.`id_blockunlimitedadvertising_advert` AND hs.`id_shop` = '.(int)$this->context->shop->id
		);

		return (++$row['next_position']);
	}

	public function getSlides($active = null)
	{
		$this->context = Context::getContext();
		$id_shop = $this->context->shop->id;
		$id_lang = $this->context->language->id;

		return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT hs.`id_blockunlimitedadvertising_advert` as id_advertblock,
					   hssl.`image`,
					   hss.`position`,
					   hss.`active`,
					   hssl.`title`,
					   hssl.`url`,
					   hssl.`legend`,
					   hssl.`description`
			FROM '._DB_PREFIX_.'blockunlimitedadvertising hs
			LEFT JOIN '._DB_PREFIX_.'blockunlimitedadvertising_advert hss ON (hs.id_blockunlimitedadvertising_advert = hss.id_blockunlimitedadvertising_advert)
			LEFT JOIN '._DB_PREFIX_.'blockunlimitedadvertising_advert_lang hssl ON (hss.id_blockunlimitedadvertising_advert = hssl.id_blockunlimitedadvertising_advert)
			WHERE (id_shop = '.(int)$id_shop.')
			AND hssl.id_lang = '.(int)$id_lang.
			($active ? ' AND hss.`active` = 1' : ' ').'
			ORDER BY hss.position');
	}

	public function displayStatus($id_advertblock, $active)
	{
		$title = ((int)$active == 0 ? $this->l('Disabled') : $this->l('Enabled'));
		$img = ((int)$active == 0 ? 'disabled.gif' : 'enabled.gif');
		$html = '<a href="'.AdminController::$currentIndex.
				'&configure='.$this->name.'
				&token='.Tools::getAdminTokenLite('AdminModules').'
				&changeStatus&id_advertblock='.(int)$id_advertblock.'" title="'.$title.'"><img src="'._PS_ADMIN_IMG_.''.$img.'" alt="" /></a>';
		return $html;
	}

	public function advertblockExists($id_advertblock)
	{
		$req = 'SELECT hs.`id_blockunlimitedadvertising_advert` as id_advertblock
				FROM `'._DB_PREFIX_.'blockunlimitedadvertising` hs
				WHERE hs.`id_blockunlimitedadvertising_advert` = '.(int)$id_advertblock;
		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($req);
		return ($row);
	}
	
		public function hookHeader($params)
	{
		$this->context->controller->addCSS(($this->_path).'blockunlimitedadvertising.css', 'all');
	}

	
	
}
