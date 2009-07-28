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

		{if $sphinxResults}
			{formfeedback hash=$feedback}

			<div class="searchresults">

			<p class="resultsheader"><strong style="float:left">{$searchIndex.index_title}</strong>{tr}Results{/tr} <strong>{$smarty.request.start+1} - {$sphinxResults.matches|@count}</strong> {tr}of exactly{/tr} <strong>{$sphinxResults.total}</strong> {tr}for{/tr} <strong>{$smarty.request.ssearch|escape}</strong> ({$sphinxResults.time|round:2} {tr}seconds{/tr})</p>

			<ol>
				{foreach from=$sphinxResults.matches item=result}
					<li>
						<h3><a href="{$smarty.const.BIT_ROOT_URL}index.php?content_id={$result.content_id}{if $result.content_type_guid != 'bitcomment'}&amp;highlight={$smarty.request.find|escape:url}{/if}">{if $result.title}{$result.title|escape}{else}[ no title ]{/if}</a></h3>
						<p>{$result.excerpt}</p>
						<div class="date">{tr}{$result.content_description}{/tr}, {tr}Last Modified{/tr} {$result.last_modified|bit_long_datetime}, {$result.data|strlen|display_bytes}</small></div>
					</li>
				{foreachelse}
					<div class="norecords">{tr}No pages matched the search criteria{/tr}</div>
				{/foreach}
			</ol>

			{pagination highlight=$smarty.request.highlight join=$smarty.request.join contentTypes=$smarty.request.contentTypes}

			</div>
		{/if}
	</div><!-- end .body -->

</div> {* end .admin *}
