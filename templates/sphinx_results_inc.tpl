{if $sphinxResults}
<div class="searchresults">


	<p class="resultsheader"><strong style="float:left">{$searchIndex.index_title}</strong>&nbsp;
		{if !empty($sphinxResults.total)}
			{tr}Results{/tr} <strong>{$smarty.request.start+1} - {$sphinxResults.matches|@count}</strong> {tr}of exactly{/tr} <strong>{$sphinxResults.total}</strong> {tr}for{/tr} <strong>{$smarty.request.ssearch|escape}</strong> ({$sphinxResults.time|round:2} {tr}seconds{/tr})
		{/if}
	</p>

	<ol>
		{foreach from=$sphinxResults.matches item=result}
			<li>
				<h3><a href="{$smarty.const.BIT_ROOT_URL}index.php?content_id={$result.content_id}{if $result.content_type_guid != 'bitcomment'}&amp;highlight={$smarty.request.ssearch|escape:url}{/if}">{if $result.title}{$result.title|escape}{else}[ no title ]{/if}</a></h3>
				<p>{$result.excerpt}</p>
				<div class="date">[{tr}Relevance{/tr}: {$result.weight}] {tr}{$result.content_description}{/tr}, {tr}Last Modified{/tr} {$result.last_modified|bit_long_datetime}</small></div>
			</li>
		{foreachelse}
			<li class="norecords">
				<p>{tr}No pages matched your search terms{/tr} <strong>"{$smarty.request.ssearch|escape}"</strong></p>

				<div>{tr}Suggestions{/tr}:
					<ul>
						<li>{tr}Check the spelling of your search terms.{/tr}</li>
						<li>{tr}Try simpler search terms.{/tr}</li>
						<li>{tr}Try fewer search terms.{/tr}</li>
					</ul>
				</div>

			</li>
		{/foreach}
	</ol>

	{pagination highlight=$smarty.request.highlight join=$smarty.request.join contentTypes=$smarty.request.contentTypes}

</div>
{/if}
