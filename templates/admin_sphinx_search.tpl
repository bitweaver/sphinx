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
					<input type="text" name="ssearch" value="{$smarty.request.ssearch}" />
				{/forminput}
			<div>

			<div class="row">
				{formlabel label="Index"}
				{forminput}
					{html_options name="sidx" options=$indexOptions}
				{/forminput}
			<div>

			<div class="row submit">
				<input type="submit" name="search" value="search" />
			</div>
		{/form}

		{if $sphinxResults}
			<ol>
			{foreach from=$sphinxResults index=$contentId item=result}
				<li>{$contentId} : {$result.full_name}</li>
			{/foreach}
			</ol>
		{/if}
	</div><!-- end .body -->

</div> {* end .admin *}
