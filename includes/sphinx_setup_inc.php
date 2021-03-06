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

if( $gBitSystem->isPackageActive( 'sphinx' ) ) {
	$gBitSystem->verifyPermission( 'p_sphinx_search' );
	require_once( SPHINX_PKG_CLASS_PATH.'SphinxSystem.php' );
	global $gSphinxSystem;
	$gSphinxSystem = new SphinxSystem();
	$gBitThemes->loadCss( SPHINX_PKG_PATH.'css/search.css' );
}
?>
