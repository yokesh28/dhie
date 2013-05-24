<div class="block products_block featured-products-combo">
	<div class="block_content">
		<ul style="width:3000px!important; height:150px;" class="mycarousel bullet-slider {$idul}">
			{foreach from=$products item=product name=homeFeaturedProducts}
				{assign var='productLink' value=$link->getProductLink($product.id_product, $product.link_rewrite)}
				<li class="ajax_block_product">
					<a href="{$productLink}" title="{$product.name|escape:html:'UTF-8'}" class="slide-animate"><img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'combo_slider')}" alt="{$product.name|escape:html:'UTF-8'}"/></a>
					<div class="wrapper_product">
						<div class="wrapper_name_product">
							<a href="{$productLink}" title="{$product.name}">{$product.name|truncate:32:'...'|escape:'htmlall':'UTF-8'}</a>
							{if $displayprice}
								{if !$priceDisplay || $priceDisplay == 2}
                                	<p class="price_container">
                                    	<span class="price">{convertPrice price=$product.price}</span>{if $priceDisplay == 2} {l s='Tax inc.' mod='comboslider'}{/if}
									</p>
								{/if}
		     					{if $priceDisplay}
                            		<p class="price_container"><span class="price">{convertPrice price=$product.price_tax_exc}</span>{if $priceDisplay == 2} {l s='Tax exc.' mod='comboslider'}{/if}
                                    </p>
								{/if}
							{/if}
						</div>
						<div class="wrapper_button">
							{if $view}
  							<a class="button" href="{$product.link}" title="{l s='Detail' mod='comboslider'}">{l s='Detail' mod='comboslider'}</a>
							{/if}
							{if $addcart}
								{if ($product.quantity > 0 OR $product.allow_oosp) AND $product.customizable != 2}
  									<a class="exclusive" rel="ajax_id_product_{$product.id_product}" href="{$link->getPageLink('cart.php')}?qty=1&amp;id_product={$product.id_product}&amp;token={$static_token}&amp;add" title="{l s='Add to cart' mod='comboslider'}">{l s='Add to cart' mod='comboslider'}</a>
  								{else}
  									<span class="exclusive">{l s='Add to cart' mod='comboslider'}</span>
  								{/if}
							{/if}
						</div>
					</div>
				</li>
			{/foreach}
		</ul>
	</div>
</div>