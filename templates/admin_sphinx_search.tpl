<div class="floaticon">{bithelp}</div>

<div class="admin sphinx">
	<div class="header">
		<h1>{tr}Sphinx Admin Search{/tr}</h1>
	</div>

	<div class="body">

		{formfeedback hash=$feedback}
		{form}
			<div class="row">
				{formlabel label="Search Terms"}
				{forminput}
					<input type="text" name="ssearch" value="{$smarty.request.ssearch|escape}" />
				{/forminput}
			<div>

			<div class="row">
				{formlabel label="Index"}
				{forminput}
					{html_options name="sidx" options=$indexOptions selected=$smarty.request.sidx}
				{/forminput}
			<div>

			<div class="row submit">
				<input type="submit" name="search" value="search" />
			</div>
		{/form}

		{formfeedback hash=$feedback}

		{include file="bitpackage:sphinx/sphinx_results_inc.tpl"}

	</div><!-- end .body -->

</div> {* end .admin *}
