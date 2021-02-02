<?php
/**
 * $Header$
 * @package sphinx
 **/

// +----------------------------------------------------------------------+
// | Copyright (c) 2009, bitweaver.org
// +----------------------------------------------------------------------+
// | All Rights Reserved. See copyright.txt for details and a complete list of authors.
// | Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details
// |
// | For comments, please use phpdocu.sourceforge.net documentation standards!!!
// | -> see http://phpdocu.sourceforge.net/
// +----------------------------------------------------------------------+
// | Authors: spider <spider@steelsun.com>
// +----------------------------------------------------------------------+

require_once( '../../kernel/setup_inc.php' );
require_once( SPHINX_PKG_INCLUDE_PATH.'sphinx_setup_inc.php' );
global $gSphinxSystem;

$feedback = array();

if( !empty( $_REQUEST["sphinx_save_index"] )) {
	if( $gSphinxSystem->saveIndex( $_REQUEST ) ) {
		$feedback['success' ] = tra( 'Index saved' );
	} else {
		$feedback['error' ] = $gSphinxSystem->mErrors;
	}
}

foreach( $indexes = $gSphinxSystem->getIndexList() as $i=>$index ) {
	$indexOptions[$i] = "$index[index_title] ($index[index_name] @ $index[host]:$index[port] $index[result_processor_function])";
}

if( !empty( $_REQUEST['ssearch'] ) ) {
	$gBitSmarty->assign( 'searchIndex', $indexes[$_REQUEST['sidx']] );
//	$gSphinxSystem->SetMatchMode(SPH_MATCH_PHRASE);
	$gSphinxSystem->SetServer( $indexes[$_REQUEST['sidx']]['host'],  (int)$indexes[$_REQUEST['sidx']]['port'] );

	$res = $gSphinxSystem->Query( $_REQUEST['ssearch'], $indexes[$_REQUEST['sidx']]['index_name'], "",  $indexes[$_REQUEST['sidx']]['result_processor_function'] );
	if ($res === false) {
	    $feedback['error'] = "Search Failure: ".$gSphinxSystem->GetLastError() ;
	} else {
		$gBitSmarty->assign_by_ref( "sphinxResults", $res );
	}
}

$gBitSmarty->assign( 'indexOptions', $indexOptions );

$gBitSmarty->assign_by_ref( 'feedback', $feedback );

$gBitSystem->display('bitpackage:sphinx/admin_sphinx_search.tpl','Sphinx Admin Search');
?>
