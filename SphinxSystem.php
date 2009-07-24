<?php
/**
 * $Header: /cvsroot/bitweaver/_bit_sphinx/SphinxSystem.php,v 1.1 2009/07/24 19:42:49 spiderr Exp $
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

require_once( SPHINX_PKG_PATH.'sphinxapi.php' );

class SphinxSystem extends SphinxClient {

	function __construct() {
		// No inheritance nor interfaces yet, so roll our own BitBase constructor
		global $gBitDb;
		$this->mDb = &$gBitDb;
		$this->mErrors = array();
		$this->mInfo = array();

		// Startup Sphinx
		parent::SphinxClient();
	}

	function getIndexList() {
		return $this->mDb->getAssoc( "SELECT index_id AS hash_key, spi.* FROM `".BIT_DB_PREFIX."sphinx_indexes` spi " );
	}

	function verifyIndex( &$pParamHash ) {
		if( !empty( $pParamHash['name'] ) ) {
			$pParamHash['index_store']['name'] = $pParamHash['name']; 
		} else {
			$this->mErrors['store_name'] = tra( "Index name was not speficied." );
		}
		if( !empty( $pParamHash['host'] ) ) {
			$pParamHash['index_store']['host'] = $pParamHash['host']; 
		} else {
			$this->mErrors['store_host'] = tra( "Sphinx server host name was not speficied." );
		}
		if( !empty( $pParamHash['port'] ) && BitBase::verifyId( $pParamHash['port'] ) ) {
			$pParamHash['index_store']['port'] = $pParamHash['port']; 
		} else {
			$this->mErrors['store_port'] = tra( "Sphinx server port number was not speficied." );
		}
		return( count( $this->mErrors ) === 0 );
	}

	function saveIndex( $pParamHash ) {
		if( $this->verifyIndex( $pParamHash ) ) {
			if( BitBase::verifyId( $pParamHash['index_id'] ) ) {
				$this->mDb->associateUpdate( 'sphinx_indexes', $pParamHash['index_store'], array( 'index_id' => $pParamHash['index_id'] ) );
			} else {
				$pParamHash['index_store']['index_id'] = $this->mDb->GenID( 'sphinx_index' );
				$this->mDb->associateInsert( 'sphinx_indexes', $pParamHash['index_store'] );
			}
		}
		return( count( $this->mErrors ) === 0 );
	}
}
