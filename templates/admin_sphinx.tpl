{strip}
{if $editIndex}
	{assign var=editTabTitle value="Edit Index"}
{else}
	{assign var=editTabTitle value="Create Index"}
{/if}
{formfeedback hash=$feedback}
{form}
	<input type="hidden" name="page" value="{$page}" />
	{jstabs}
		{jstab title="Sphinx Search Indexes"}
			<div class="row">
				{formhelp note="These are unique indexes that have been configured "}
			</div>

			<ul>
			{foreach from=$sphinxIndexes key=indexId item=index}
				<li>
					<h2>{$index.index_title}</h2>
					<div<em>{$index.index_name} @ {$index.host}:{$index.port}</em></div>
				</li>
			{foreachelse}
				<li>{tr}No indexes have been created.{/tr}</li>
			{/foreach}
		{/jstab}
		{jstab title=$editTabTitle}
			<h2></h2>
			<input type="hidden" name="index_id" value="{$editIndex.index_id}" />
			<div class="row">
				{formlabel label="Index Name"}
				{forminput}
					<input name="index_title" type="text" value="{$editIndex.name|default:$smarty.request.index_name}" />
					{formhelp note="This title will be displayed to users, it should be nice and human readable."}
				{/forminput}
			</div>
			<div class="row">
				{formlabel label="Index Name"}
				{forminput}
					<input name="index_name" type="text" value="{$editIndex.name|default:$smarty.request.index_name}" />
					{formhelp note="This must be the name of the index as specified in your sphinx.conf on the sphinx host"}
				{/forminput}
			</div>
			<div class="row">
				{formlabel label="Sphinx Host"}
				{forminput}
					<input name="host" type="text" value="{$editIndex.host|default:$smarty.request.host}" />
					{formhelp note="The Internet host address running the search daemon with the above index."}
				{/forminput}
			</div>
			<div class="row">
				{formlabel label="Sphinx Port"}
				{forminput}
					<input name="port" type="text" value="{$editIndex.port|default:$smarty.request.port|default:'3312'}" style="width:3em" />
					{formhelp note="The port on which the sphinx daemon is running, default is 3312"}
				{/forminput}
			</div>
			<div class="row submit">
				<input type="submit" name="sphinx_save_index" value="{tr}Save Index{/tr}" />
			</div>
		{/jstab}
	{/jstabs}
{/form}

{/strip}
