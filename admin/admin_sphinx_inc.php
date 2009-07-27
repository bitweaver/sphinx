<?php
/**
 * $Header: /cvsroot/bitweaver/_bit_sphinx/admin/admin_sphinx_inc.php,v 1.2 2009/07/27 14:03:54 spiderr Exp $
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

require_once( SPHINX_PKG_PATH.'sphinx_setup_inc.php' );
global $gSphinxSystem;

$feedback = array();

if( !empty( $_REQUEST['feedback'] ) ) {
	$feedback = $_REQUEST['feedback'];
}

if( !empty( $_REQUEST["sphinx_save_index"] )) {
	if( $gSphinxSystem->saveIndex( $_REQUEST ) ) {
		bit_redirect( KERNEL_PKG_URL.'admin/index.php?page='.SPHINX_PKG_NAME.'&feedback[success]='.urlencode( tra( 'Index Saved' ) ) );
	} else {
		$feedback['error' ] = $gSphinxSystem->mErrors;
	}
} elseif( !empty( $_REQUEST["delete_sidx"] )) {
	$gBitUser->verifyTicket();
	$gSphinxSystem->expungeIndex( $_REQUEST["delete_sidx"] );
} elseif( !empty( $_REQUEST["edit_sidx"] )) {
	$gBitSmarty->assign( 'editIndex', $gSphinxSystem->getIndex( $_REQUEST["edit_sidx"] ) );
}

$gBitSmarty->assign( 'sphinxIndexes', $gSphinxSystem->getIndexList() );

$gBitSmarty->assign_by_ref( 'feedback', $feedback );
?>
