<?php
/*
* 2007-2011 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
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
*  @copyright  2007-2011 PrestaShop SA
*  @version  Release: $Revision: 1.4 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class FrontController extends FrontControllerCore
{


	public function initContent()
	{
		$this->process();
		if (!isset($this->context->cart))
			$this->context->cart = new Cart();
		if ($this->context->getMobileDevice() == false)
		{
			// These hooks aren't used for the mobile theme.
			// Needed hooks are called in the tpl files.
			if (!isset($this->context->cart))
				$this->context->cart = new Cart();
			$this->context->smarty->assign(array(
				'HOOK_HEADER' => Hook::exec('displayHeader'),
				'HOOK_TOP' => Hook::exec('displayTop'),
				'HOOK_LEFT_COLUMN' => ($this->display_column_left ? Hook::exec('displayLeftColumn') : ''),
				'HOOK_RIGHT_COLUMN' => ($this->display_column_right ? Hook::exec('displayRightColumn', array('cart' => $this->context->cart)) : ''),
				'HOOK_EXTRABANNER' => Hook::exec('extrabanner'),
			));
		}
		else
		{
			$this->context->smarty->assign(array(
				'HOOK_MOBILE_HEADER' => Hook::exec('displayMobileHeader'),
			));
		}
	}

}

