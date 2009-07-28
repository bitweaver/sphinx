<?
/**
 * $Header: /cvsroot/bitweaver/_bit_sphinx/bit_setup_inc.php,v 1.2 2009/07/28 00:25:37 spiderr Exp $
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

	function sphinx_liberty_results( $pResults ) {
		global $gSphinxSystem, $gBitUser;
		if( !empty( $pResults['matches'] ) ) {
			$contentIds = array();

			if( $gSphinxSystem->_arrayresult ) {	
				for( $i = 0; $i < count( $pResults['matches'] ); $i++ ) {
					$contentIds[] = $pResults['matches'][$i]['id'];
				}
			} else {
				$contentIds = array_keys( $pResults['matches'] );
			}

			$listHash = array( 'content_id_list' => $contentIds );
			$listHash['hash_key'] = 'lc.content_id';
			$listHash['include_data'] = TRUE;
			if( $conList = $gBitUser->getContentList( $listHash ) ) {
				if( $gSphinxSystem->_arrayresult ) {	
					for( $i = 0; $i < count( $pResults['matches'] ); $i++ ) {
						$pResults['matches'][$i] = array_merge( $pResults['matches'][$i], $conList[$pResults['matches'][$i]['id']] );
					}
				} else {
					reset( $contentIds );
					foreach( $contentIds as $conId ) {
						$conList[$conId]['stripped_data'] = strip_tags( $gBitUser->parseData( $conList[$conId]['data'], $conList[$conId]['format_guid'] ) );
						$pResults['matches'][$conId] = array_merge( $pResults['matches'][$conId], $conList[$conId] );
						$excerptSources[] = $conList[$conId]['stripped_data'];
					}
					$excerpts = $gSphinxSystem->BuildExcerpts( $excerptSources, $pResults['index'], $pResults['query'] );
					$i = 0;
					foreach( $contentIds as $conId ) {
						$pResults['matches'][$conId]['excerpt'] = $excerpts[$i++];
					}
				}
			}
		}

		return $pResults;
	}
}
?>
