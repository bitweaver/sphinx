{strip}
{if $editIndex}
	{assign var=editTabTitle value="Edit Index: `$editIndex.index_title`"}
{else}
	{assign var=editTabTitle value="Create Index"}
{/if}
{formfeedback hash=$feedback}
{form}
	<input type="hidden" name="page" value="{$page}" />
	{jstabs}
		{jstab title="Sphinx Search Indexes"}
			<div class="control-group">
				{formhelp note="These are unique indexes that have been configured "}
			</div>

			<ul>
			{foreach from=$sphinxIndexes key=indexId item=index}
				<li>
					<div class="floaticon">
						<a href="{$smarty.const.KERNEL_PKG_URL}admin/index.php?page={$smarty.const.SPHINX_PKG_NAME}&amp;edit_sidx={$indexId}">{biticon iname="accessories-text-editor"}</a>
						<a href="{$smarty.const.KERNEL_PKG_URL}admin/index.php?page={$smarty.const.SPHINX_PKG_NAME}&amp;delete_sidx={$indexId}&amp;tk={$gBitUser->mTicket}">{booticon iname="icon-trash"}</a>
					</div>
					<h2>{$index.index_title}</h2>
					<div><em>{$index.index_name} @ {$index.host}:{$index.port} {if $index.result_processor_function || $index.result_display_tpl}[{$index.result_processor_function}{if $index.result_display_tpl} -> {$index.result_display_tpl}{/if}]{/if}</em></div>
				</li>
			{foreachelse}
				<li>{tr}No indexes have been created.{/tr}</li>
			{/foreach}
		{/jstab}
		{jstab title=$editTabTitle}
			<h2></h2>
			<input type="hidden" name="index_id" value="{$editIndex.index_id}" />
			<div class="control-group">
				{formlabel label="Index Name"}
				{forminput}
					<input name="index_title" type="text" value="{$editIndex.index_title|default:$smarty.request.index_title}" />
					{formhelp note="This title will be displayed to users, it should be nice and human readable."}
				{/forminput}
			</div>
			<div class="control-group">
				{formlabel label="Index Name"}
				{forminput}
					<input name="index_name" type="text" value="{$editIndex.index_name|default:$smarty.request.index_name}" />
					{formhelp note="This must be the name of the index as specified in your sphinx.conf on the sphinx host"}
				{/forminput}
			</div>
			<div class="control-group">
				{formlabel label="Sphinx Host"}
				{forminput}
					<input name="host" type="text" value="{$editIndex.host|default:$smarty.request.host}" />
					{formhelp note="The Internet host address running the search daemon with the above index."}
				{/forminput}
			</div>
			<div class="control-group">
				{formlabel label="Sphinx Port"}
				{forminput}
					<input name="port" type="text" value="{$editIndex.port|default:$smarty.request.port|default:'3312'}" style="width:3em" />
					{formhelp note="The port on which the sphinx daemon is running, default is 3312"}
				{/forminput}
			</div>
			<div class="control-group">
				{formlabel label="Listing Order"}
				{forminput}
					<input name="pos" type="text" value="{$editIndex.pos|default:$smarty.request.pos}" style="width:3em" />
					{formhelp note="OPTIONAL - Position the index will appear in menus or choices"}
				{/forminput}
			</div>
			<div class="control-group">
				{formlabel label="Custom Results Processor"}
				{forminput}
					<input name="result_processor_function" type="text" value="{$editIndex.result_processor_function|default:$smarty.request.result_processor_function}" />
					{formhelp note="OPTIONAL - This is the name of a custom PHP function used to process the results that will be displayed to the user. If no value is entered, the default process assumes the Sphinx documentID is a content_id."}
				{/forminput}
			</div>
			<div class="control-group">
				{formlabel label="Custom Results Template"}
				{forminput}
					<input name="result_display_tpl" type="text" value="{$editIndex.result_display_tpl|default:$smarty.request.result_display_tpl}" />
					{formhelp note="OPTIONAL - This is the name of a custom smarty template used to display results the user. You may use enter a full path or a bitweaver standard tpl include, ala: bitpackage:foo/search_bar.tpl . If no value is entered, the default process assumes the Sphinx documentID is a content_id, and general content information will be displayed (title, creator, date, etc.)"}
				{/forminput}
			</div>
			<div class="control-group">
				{formlabel label="Field Weighting"}
				{forminput}
					<textarea name="field_weights" style="height:6em;">{$editIndex.field_weights_txt|default:$smarty.request.field_weights}</textarea>
					{formhelp note="OPTIONAL - Enter field weights above, 1 per line, in the format of '<fieldname>=<weight>'. Individual fields in the index (typically columns from your database) can be weighted differently. For example, enter a line above with 'title=5.5' to give a match in the title a weight of 5.5 The default weight for all fields is 1"}
				{/forminput}
			</div>
			<div class="control-group">
				{formlabel label="Index Source Weighting"}
				{forminput}
					<textarea name="index_weights" style="height:6em;">{$editIndex.index_weights_txt|default:$smarty.request.index_weights}</textarea>
					{formhelp note="OPTIONAL - Enter index source weights above, 1 per line, in the format of '<sourcename>=<weight>'. If your index has multiple sources, you can weight results from the sources differently. For example, you may have a source 'wikipages=3.0' and 'wikicomments=1.5' to weight hits from pages higher than hits in comments. The default weight is 1."}
				{/forminput}
			</div>
			<div class="control-group submit">
				<input type="submit" class="btn btn-default" name="sphinx_save_index" value="{tr}Save Index{/tr}" />
			</div>
		{/jstab}
	{/jstabs}
{/form}

{/strip}
