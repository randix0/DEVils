{include file=$_tpl.header}
<body class="{if isset($_partition) && $_partition}{$_partition}{/if}">
<div class="w990px">
{include file=$_tpl.pageTop}
{*
{if isset($_tpl.leftColumn)}<aside class="leftColumn">{include file=$_tpl.leftColumn}</aside>{/if}
{if isset($_tpl.rightColumn)}<aside class="rightColumn">{include file=$_tpl.rightColumn}</aside>{/if}
*}
{if isset($_tpl.content)}<section class="mainContent {if isset($_tpl.leftColumn) && isset($_tpl.rightColumn)}brick{/if}">{include file=$_tpl.content}</section>{/if}
{include file=$_tpl.pageBottom}
</div>
</body>
{include file=$_tpl.footer}