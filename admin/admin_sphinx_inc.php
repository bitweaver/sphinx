<?php
/**
 * $Header: /cvsroot/bitweaver/_bit_sphinx/admin/admin_sphinx_inc.php,v 1.1 2009/07/24 19:42:49 spiderr Exp $
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

if( !empty( $_REQUEST["sphinx_save_index"] )) {
	if( $gSphinxSystem->saveIndex( $_REQUEST ) ) {
		$feedback['success' ] = tra( 'Index saved' );
	} else {
		$feedback['error' ] = $gSphinxSystem->mErrors;
	}
}

$gBitSmarty->assign( 'sphinxIndexes', $gSphinxSystem->getIndexList() );

$gBitSmarty->assign_by_ref( 'feedback', $feedback );
?>
