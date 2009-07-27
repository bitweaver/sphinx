<?php
/**
 * $Header: /cvsroot/bitweaver/_bit_sphinx/admin/search.php,v 1.4 2009/07/27 16:19:09 spiderr Exp $
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

require_once( '../../bit_setup_inc.php' );
require_once( SPHINX_PKG_PATH.'sphinx_setup_inc.php' );
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
	$gSphinxSystem->SetServer( $indexes[$_REQUEST['sidx']]['host'],  (int)$indexes[$_REQUEST['sidx']]['port'] );
	$gSphinxSystem->SetMatchMode(SPH_MATCH_PHRASE);
	$gSphinxSystem->SetArrayResult( TRUE );

	$res = $gSphinxSystem->Query( $_REQUEST['ssearch'], $indexes[$_REQUEST['sidx']]['index_name'] );
	if ($res === false) {
	    $feedback['error'] = "Search Failure: ".$gSphinxSystem->GetLastError() ;
	}
}

$gBitSmarty->assign( 'indexOptions', $indexOptions );

$gBitSmarty->assign_by_ref( 'feedback', $feedback );

$gBitSystem->display('bitpackage:sphinx/admin_sphinx_search.tpl','Sphinx Admin Search');
?>
