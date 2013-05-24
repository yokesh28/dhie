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
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

		{if !$content_only}
				</div>

<!-- Right -->
				{*<div id="right_column">
					{$HOOK_RIGHT_COLUMN}
				</div>*}
				<div class="clear"></div>
			</div>

<!-- Footer -->
			<div id="footer" class="clearfix">
                <div class="wrapper">
                
				{$HOOK_FOOTER}
                
                <!-- Additional Copyright Text -->
                <div id="copyright">
                    <ul>
                        {if !$PS_CATALOG_MODE}<li class="first_item"><a href="{$link->getPageLink('prices-drop')}" title="{l s='Specials' mod='blockcms'}">{l s='Specials' mod='blockcms'}</a></li>{/if}
                        <li class="{if $PS_CATALOG_MODE}first_{/if}item"><a href="{$link->getPageLink('new-products')}" title="{l s='New products' mod='blockcms'}">{l s='New products' mod='blockcms'}</a></li>
                        {if !$PS_CATALOG_MODE}<li class="item"><a href="{$link->getPageLink('best-sales')}" title="{l s='Top sellers' mod='blockcms'}">{l s='Top sellers' mod='blockcms'}</a></li>{/if}
                        {if $display_stores_footer}<li class="item"><a href="{$link->getPageLink('stores')}" title="{l s='Our stores' mod='blockcms'}">{l s='Our stores' mod='blockcms'}</a></li>{/if}
                    </ul>
                    <p>Copyright &copy; 2012 <a href="{$base_dir}">{$shop_name|escape:'htmlall':'UTF-8'}</a> | {l s='FREE Prestashop Theme from'} <a href="http://dapurpixel.com">DapurPixel</a></p>
                </div>
                <!-- /Copyright -->
                
                <!-- Credit -->
                <div id="credit">
                    <p>{l s='Prestashop theme by:'}</p>
                    <a id="dapurpixel" title="DapurPixel" href="http://dapurpixel.com">DapurPixel</a>
                </div>    
                <!-- Credit -->
                
				{if $PS_ALLOW_MOBILE_DEVICE}
					<p class="center clearBoth"><a href="{$link->getPageLink('index', true)}?mobile_theme_ok">{l s='Browse the mobile site'}</a></p>
				{/if}
                </div>
			</div>
		</div>
	{/if}
	</body>
</html>
