<?
/**
 * $Header: /cvsroot/bitweaver/_bit_sphinx/bit_setup_inc.php,v 1.1 2009/07/24 19:42:49 spiderr Exp $
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

$registerHash = array(
	'package_name' => 'sphinx',
	'package_path' => dirname( __FILE__ ).'/',
);
$gBitSystem->registerPackage( $registerHash );

if( $gBitSystem->isPackageActive( 'sphinx' )) {
	if( $gBitUser->hasPermission( 'p_sphinx_search' )) {
		$menuHash = array(
			'package_name'       => SPHINX_PKG_NAME,
			'index_url'          => SPHINX_PKG_URL.'index.php',
			'menu_template'      => 'bitpackage:sphinx/menu_sphinx.tpl',
			'admin_comments_url' => KERNEL_PKG_URL.'admin/index.php?page=sphinx',
		);
		$gBitSystem->registerAppMenu( $menuHash );
	}
}
?>
