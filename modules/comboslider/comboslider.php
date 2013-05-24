<?php

class ComboSlider extends Module
{
	private $_html = '';
	private $_postErrors = array();

	function __construct()
	{
		$this->name = 'comboslider';
		$this->tab = 'front_office_features';
		$this->version = '2.0';
		$this->author = 'DapurPixel';
		$this->need_instance = 0;

		parent::__construct();

		$this->page = basename(__FILE__, '.php');
		$this->displayName = $this->l('Combo Slider on the homepage');
		$this->description = $this->l('Displays Featured and New Products Carousel in Your Homepage');
	}

	function install()
	{
		if (!Configuration::updateValue('HOME_FEATURED_NBR', 8) OR !parent::install() OR !$this->registerHook('home') OR !$this->registerHook('header'))
    	return false;
		if (!Configuration::updateValue('HOME_NEW_NBR', 8))
			return false;
		if (!Configuration::updateValue('HOME_NEW_SORT', date_add))
			return false;
		if (!Configuration::updateValue('HOME_NEW_SORT_SENS', DESC))
			return false;
		return true;
	}


	public function uninstall()
	{
		return (parent::uninstall());
	}

	public function getContent()
	{
		$output = '<h2>'.$this->displayName.'</h2>';
		if (Tools::isSubmit('submitHomeFeatured'))
		{
			$nbr = intval(Tools::getValue('nbr'));
			if (!$nbr OR $nbr <= 0 OR !Validate::isInt($nbr))
				$errors[] = $this->l('Invalid number of products');
			else
				Configuration::updateValue('HOME_FEATURED_NBR', $nbr);
			if (isset($errors) AND sizeof($errors))
				$output .= $this->displayError(implode('<br />', $errors));
			else
				$output .= $this->displayConfirmation($this->l('Settings updated'));
		}

		if (Tools::isSubmit('submitHomeNew'))
		{
			$nbr = intval(Tools::getValue('nbr'));
			
			if (!$nbr OR $nbr <= 0 OR !Validate::isInt($nbr))
				$errors[] = $this->l('Invalid number of product');
			else
				Configuration::updateValue('HOME_NEW_NBR', $nbr);

			if (isset($errors) AND sizeof($errors))
				$output .= $this->displayError(implode('<br />', $errors));
			else
				$output .= $this->displayConfirmation($this->l('Settings updated'));
		}

		return $output.$this->displayForm();
	}

	public function displayForm()
	{
		$output = '
	   	<form action="'.$_SERVER['REQUEST_URI'].'" method="post">
			<fieldset><legend><img src="'.$this->_path.'logo.gif" alt="" title="" />'.$this->l('Featured products settings').'</legend>
				<p>'.$this->l('In order to add products to your homepage, just add them to the "home" category.').'</p><br />
				<label style="text-align:left; width:500px;">'.$this->l('The number of featured products displayed on homepage (default: 8)').'</label>
				<div class="margin-form">
					<input type="text" size="5" name="nbr" value="'.(Configuration::get('HOME_FEATURED_NBR')).'" />	
				</div>
				<center><input type="submit" name="submitHomeFeatured" value="'.$this->l('Save').'" class="button" /></center>
			</fieldset>
      </form>
    

	<form action="'.$_SERVER['REQUEST_URI'].'" method="post">
    	<fieldset>
				<legend><img src="'.$this->_path.'logo.gif" alt="" title="" />'.$this->l('New products settings').'</legend>
				<label style="text-align:left; width:500px;">'.$this->l('The number of new products displayed on homepage (default: 8)').'</label>
				<div class="margin-form">
					<input type="text" size="5" name="nbr" value="'.(Configuration::get('HOME_NEW_NBR')).'" />	
				</div>

				<center><input type="submit" name="submitHomeNew" value="'.$this->l('Save').'" class="button" /></center>
		</fieldset> 
	</form>
';

		return $output;
	}

	function hookHome($params)
	{
		global $smarty;

		$smarty->assign(array(
			'displayfeatured' =>Configuration::updateValue('HOME_FEATURED_ACTIVATE', 1),
			'displaynew' =>	Configuration::updateValue('HOME_NEW_ACTIVATE', 1),
			'defaulttab' =>	Configuration::updateValue('HOME_DEFAULT_TAB', 0)
		));
		

  if (Configuration::updateValue('HOME_FEATURED_ACTIVATE', 1))
  {
		$category = new Category(Context::getContext()->shop->getCategory(), (int)Context::getContext()->language->id);
		$nb = intval(Configuration::get('HOME_FEATURED_NBR'));
		$sort = intval(Configuration::updateValue('HOME_FEATURED_SORT', 0));

		switch ($sort) {
		    case '0':
			$HomeFeaturedProducts = $category->getProducts((int)Context::getContext()->language->id, 1, ($nb ? $nb : 10));
			break;
		    default:
			$HomeFeaturedProducts = $category->getProducts((int)Context::getContext()->language->id, 1, ($nb ? $nb : 10));
			break;
		}		
  
		$smarty->assign(array(
			'featuredProducts' => $HomeFeaturedProducts,
			'featuredDisplayprice' => Configuration::updateValue('HOME_FEATURED_DISPLAY_PRICE', 1),
			'featuredAddcart' => Configuration::updateValue('HOME_FEATURED_ADD_CART', 1),
			'featuredView' => Configuration::updateValue('HOME_FEATURED_VIEW', 1),
			'featuredStyle' =>	Configuration::get('HOME_FEATURED_STYLE_LIST')
		));
  }


  if (Configuration::get('HOME_NEW_ACTIVATE'))
  {
    $smarty->assign(array(
	   'newProducts' => Product::getNewProducts(intval($params['cookie']->id_lang), '0', intval(Configuration::get('HOME_NEW_NBR')), false, Configuration::get('HOME_NEW_SORT'), Configuration::get('HOME_NEW_SORT_SENS')),
		 'newDisplayprice' => Configuration::updateValue('HOME_NEW_DISPLAY_PRICE', 1),
		 'newAddcart' => Configuration::updateValue('HOME_NEW_ADD_CART', 1),
		 'newView' => Configuration::updateValue('HOME_NEW_VIEW', 1),
		 'newStyle' => Configuration::get('HOME_NEW_STYLE_LIST')
     ));
  }
  
    $smarty->assign('featured_list', _PS_MODULE_DIR_.'comboslider/featured-list.tpl');
		return $this->display(__FILE__, 'comboslider.tpl');
	}

	function hookHeader($params)
	{
		Tools::addJS($this->_path.'jquery/jquery.idTabs.modified.js');
		Tools::addCSS($this->_path.'jcarousel/skins/tango/skin.css', 'all');
		Tools::addCSS($this->_path.'css/comboslider.css', 'all');
	}

}