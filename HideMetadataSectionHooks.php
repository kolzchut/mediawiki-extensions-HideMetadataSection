<?php

class HideMetadataSectionHooks {
	const METADATA_CONTENT = '<!-- Metadata -->';
	
	public static function onOutputPageParserOutput( OutputPage &$out, ParserOutput $parserOutput ) {
		$parserOutput->mText = preg_replace(
			'/\<li class="toclevel.*?#MetaData.*?\<\/li>\n/i', '', $parserOutput->mText
		);

		return true;
	}


	public static function onParserSectionCreate( Parser $parser, $section, &$sectionContent, $showEditLinks ) {
		if ( $parser->getTitle()->isSpecialPage() === true ) {
			return true;
		};

		if ( stripos( $sectionContent, 'id="metadata"' ) !== false ) {
			$sectionContent = self::METADATA_CONTENT;
		}

		return true;
	}

}
