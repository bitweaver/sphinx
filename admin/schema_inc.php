<?php

global $gBitInstaller;

$tables = array(
	// name and value are reserved database names and should be changed for something else
	'sphinx_indexes' => "
		index_id I4 NOTNULL PRIMARY,
		index_title C(250) NOTNULL,
		index_name C(250) NOTNULL,
		host C(250) NOTNULL,
		port I4 NOTNULL,
		result_processor_function C(250),
		result_display_tpl C(250),
		index_options X,
		pos F
	"
);

global $gBitInstaller;

foreach( array_keys( $tables ) AS $tableName ) {
	$gBitInstaller->registerSchemaTable( SPHINX_PKG_NAME, $tableName, $tables[$tableName] );
}

$gBitInstaller->registerPackageInfo( SPHINX_PKG_NAME, array(
	'description' => "Sphinx Search Engine.",
	'license' => '<a href="http://www.gnu.org/licenses/licenses.html#LGPL">LGPL</a>',
) );

// ### Default UserPermissions
$gBitInstaller->registerUserPermissions( SPHINX_PKG_NAME, array(
	array( 'p_sphinx_admin' , 'Can admin sphinx'  , 'admin'  , SPHINX_PKG_NAME ),
	array( 'p_sphinx_search'  , 'Can search'   , 'basic'  , SPHINX_PKG_NAME ),
) );

?>
