{*
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
*  @version  Release: $Revision: 14973 $
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<!-- Module BlockBanner -->
{if isset($blockbanner_banner)}
<div id="blockbanner">
{foreach from=$blockbanner_banner item=bannerblock}
	{if $bannerblock.active}
		<a href="{$bannerblock.url}" title="{$bannerblock.description}"><img src="{$smarty.const._MODULE_DIR_}/blockbanner/images/{$bannerblock.image}" alt="{$bannerblock.legend}" title="{$bannerblock.description}"  /></a>
	{/if}
{/foreach}
</div>
{/if}
<!-- /Module BlockBanner -->
