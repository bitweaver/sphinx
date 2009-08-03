<?php
/**
 * $Header: /cvsroot/bitweaver/_bit_sphinx/SphinxSystem.php,v 1.9 2009/08/03 17:36:56 spiderr Exp $
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

		$this->mIndex = NULL;

		// Startup Sphinx
		parent::SphinxClient();
	}

	function Query ( $query, $pIndexMixed, $comment="" ) {
		if( is_numeric( $pIndexMixed ) ) {
			$searchIndex = $this->getIndex( $pIndexMixed );
		} elseif( is_string( $pIndexMixed ) ) {
			$searchIndex['index_name'] = $pIndexMixed;
		} elseif( is_array( $pIndexMixed ) ) {
			$searchIndex = &$pIndexMixed;
		}

	//	$this->SetMatchMode(SPH_MATCH_PHRASE);
		$this->SetServer( $searchIndex['host'], (int)$searchIndex['port'] );
		if( !empty( $searchIndex['index_options']['field_weights'] ) ) {
			$this->SetFieldWeights( $searchIndex['index_options']['field_weights'] );
		}
		if( !empty( $searchIndex['index_options']['index_weights'] ) ) {
			$this->SetIndexWeights( $searchIndex['index_options']['index_weights'] );
		}
		if( $ret = parent::Query ( $query, $searchIndex['index_name'], $comment ) ) {
			$ret['query'] = $query;
			$ret['index_name'] = $searchIndex['index_name'];
			if( !empty( $searchIndex['result_processor_function'] ) ) {
				$ret = $searchIndex['result_processor_function']( $ret );
			}
		}
		return $ret;
	}

	function getIndexList() {
		if( $ret =  $this->mDb->getAssoc( "SELECT index_id AS hash_key, spi.* FROM `".BIT_DB_PREFIX."sphinx_indexes` spi ORDER BY `pos` ASC, `index_title` ASC " ) ) {
			foreach( array_keys( $ret ) as $k ) {
				if( !empty( $ret[$k]['index_options'] ) ) {
					$ret[$k]['index_options'] = unserialize( $ret[$k]['index_options'] );
				}
			}
		}
		return $ret;
	}

	function getIndex( $pIndexId ) {
		$ret = $this->mDb->getRow( "SELECT spi.* FROM `".BIT_DB_PREFIX."sphinx_indexes` spi WHERE `index_id`=?", array( (int)$pIndexId ) );
		if( !empty( $ret['index_options'] ) ) {
			$ret['index_options'] = unserialize( $ret['index_options'] );
		}
		return $ret;
	}

	function verifyIndex( &$pParamHash ) {
		if( !empty( $pParamHash['index_title'] ) ) {
			$pParamHash['index_store']['index_title'] = $pParamHash['index_title']; 
		} else {
			$this->mErrors['store_title'] = tra( "Index title was not speficied." );
		}
		if( !empty( $pParamHash['index_name'] ) ) {
			$pParamHash['index_store']['index_name'] = $pParamHash['index_name']; 
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
		if( !empty( $pParamHash['result_display_tpl'] ) ) {
			$pParamHash['index_store']['result_display_tpl'] = $pParamHash['result_display_tpl']; 
		}
		$pParamHash['index_store']['pos'] = (!empty( $pParamHash['pos'] ) ? (int)$pParamHash['pos'] : NULL); 
		if( !empty( $pParamHash['result_processor_function'] ) ) {
			$pParamHash['index_store']['result_processor_function'] = $pParamHash['result_processor_function']; 
		}
		if( empty( $this->mErrors ) && empty( $pParamHash['index_id'] ) ) {
			if( $indexId = $this->mDb->GetOne( "SELECT `index_id` FROM `".BIT_DB_PREFIX."sphinx_indexes` WHERE `host`=? AND `port`=? AND `index_name`=?", array( $pParamHash['host'], $pParamHash['port'], $pParamHash['index_name'] ) ) ) {
				$this->mErrors['store_name'] = tra( "The index with this name, host and port has already been created." );
			}
		}
		$indexOptions = array();
		foreach( array( 'index_weights', 'field_weights' ) as $opt ) {
			if( !empty( $pParamHash[$opt] ) && is_string( $pParamHash[$opt] ) && strpos( $pParamHash[$opt], '=' ) ) {
				if( $lines = split( "\n", $pParamHash[$opt] ) ) {
					foreach( $lines as $l ) {
						if( $l = trim( $l ) ) {
							list( $key, $value )  = split( '=', $l );
							$indexOptions[$opt][$key] = (int)$value;
						}
					}
				}
			}
		}
		if( !empty( $indexOptions ) ) {
			$pParamHash['index_store']['index_options'] = serialize( $indexOptions );
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

	function expungeIndex( $pIndexId ) {
		$this->mDb->query( "DELETE FROM `".BIT_DB_PREFIX."sphinx_indexes` WHERE `index_id`=?", array( (int)$pIndexId ) );
	}

	function populateExcerpts( &$pResults, $pExcerptSources ) {
		$excerptOptions['before_match'] = '<strong class="searchmatch">';
		$excerptOptions['after_match'] = '</strong>';
		$excerpts = $this->BuildExcerpts( $pExcerptSources, $pResults['index_name'], $pResults['query'], $excerptOptions );
		$i = 0;
		foreach( array_keys( $pResults['matches'] ) as $k ) {
			$pResults['matches'][$k]['excerpt'] = $excerpts[$i++];
		}
	}
}
