<!-- jCarousel library -->
<script type="text/javascript" src="{$base_dir}modules/comboslider/jcarousel/lib/jquery.jcarousel.pack.js"></script>
<script type="text/javascript" src="{$base_dir}modules/comboslider/homecarousel.js"></script>

	<script type="text/javascript">
		var carousel_autoplay = 0;
		var carousel_items_visible = 4;
		var carousel_scroll = 1;
	</script>

<div id="combo-slidehow" class="HomeTabs"> 

    <ul id="more_info_tabs" class="idTabs idTabsShort">

    {if $displayfeatured}
    	<li><a href="#featured" {if $defaulttab=="1"} class="selected"{/if}>{l s='Featured products' mod='comboslider'}</a></li> 
    {/if}
    {if $displaynew}
    	<li><a href="#new" {if $defaulttab=="0"} class="selected"{/if}>{l s='New products' mod='comboslider'}</a></li> 
    {/if}
	</ul> 
 
	{if $displayfeatured}
	<div id="featured" class="container">
        {assign var='products' value=$featuredProducts}
        {assign var='idul' value=jcarousel-skin-tango}
        {assign var='displayprice' value=$featuredDisplayprice}
        {assign var='addcart' value=$featuredAddcart}
        {assign var='view' value=$featuredView}
        {if $products}
            {if $featuredStyle=="0"}
                {include file="$featured_list"}                      
            {else}
                <p class="warning">{l s='No featured products.' mod='comboslider'}</p>
            {/if}
        {/if}
	</div>
	{/if}
 
	{if $displaynew}
  	<div id="new" class="container">
        {assign var='products' value=$newProducts}
        {assign var='idul' value=jcarousel-skin-ie7}
        {assign var='displayprice' value=$newDisplayprice}
        {assign var='addcart' value=$newAddcart}
        {assign var='view' value=$newView}
		{if $products}
            {if $newStyle=="0"}
                {include file="$featured_list"}             
            {else}
                <p class="warning">{l s='No new products.' mod='comboslider'}</p>
            {/if}
    	{/if}
	</div>
	{/if}
</div>