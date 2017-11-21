<?php
if ( function_exists( 'wfLoadSkin' ) ) {
	wfLoadSkin( 'erudite' );
	// Keep i18n globals so mergeMessageFileList.php doesn't break
	$wgMessagesDirs['Erudite'] = __DIR__ . '/i18n';
	wfWarn(
		'Deprecated PHP entry point used for erudite skin. Please use wfLoadExtension instead, ' .
		'see https://www.mediawiki.org/wiki/Extension_registration for more details.'
	);
	return;
} else {
	die( 'This version of the erudite skin requires MediaWiki 1.25+' );
}
