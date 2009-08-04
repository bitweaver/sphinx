<div class="floaticon">{bithelp}</div>

<div class="admin sphinx">
	<div class="body">

		 {form method="get"}
			<div class="row" style="margin:auto;width:none;">
				{formlabel label="Search" style="font-size:16pt;display:inline;width:10%"}
				{forminput style="display:inline;width:70%;"}
					{html_options name="sidx" options=$indexOptions selected=$smarty.request.sidx} for 
					<input type="text" name="ssearch" value="{$smarty.request.ssearch|escape}" id="ssearchinput" />
					<input type="submit" name="search" value="search" />
					{formhelp note="Enter search terms in the entry field above."}
				{/forminput}
			<div>

		{/form}

		{formfeedback hash=$feedback}

		{include file=$searchIndex.result_display_tpl|default:"bitpackage:sphinx/sphinx_results_inc.tpl"}

	</div><!-- end .body -->

</div> {* end .admin *}

