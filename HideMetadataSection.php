<?php


$wgExtensionCredits['other'][] = [
	'path' => __FILE__,
	'name' => 'Hide Metadata Section',
	'author' => 'Dror S. [FFS] ([http://www.kolzchut.org.il Kol-Zchut])',
	'version' => '0.1.0',
	'update' => '2017-06-20',
	'url' => 'https://github.com/kolzchut/mediawiki-extensions-HideMetadataSection',
	'license-name'   => 'GPL-2.0+',
	'description' => 'Hide a section named "Metadata". This is useful to hide the last section on the page',
];

$wgHooks['ParserSectionCreate'][] = 'onParserSectionCreate';
$wgHooks['OutputPageParserOutput'][] = 'onOutputPageParserOutput';


function onOutputPageParserOutput( OutputPage &$out, ParserOutput $parserOutput ) {
	$parserOutput->mText = preg_replace( '/\<li class="toclevel.*?#MetaData.*?\<\/li>\n/i', '', $parserOutput->mText );
	return true;
}


function onParserSectionCreate( Parser $parser, $section, &$sectionContent, $showEditLinks ) {
	if ( $parser->getTitle()->isSpecialPage() === true ) {
		return true;
	};

	if ( stripos( $sectionContent, 'id="metadata"' ) !== false ) {
		$sectionContent = '';
		return false;
	}

	return true;
}


