<?php

class HideMetadataSectionHooks {
	const METADATA_CONTENT = '<!-- Metadata -->';

	public static function onOutputPageParserOutput( OutputPage &$out, ParserOutput $parserOutput ) {
		$parserOutput->mText = preg_replace(
			'/\<li class="toclevel.*?#MetaData.*?\<\/li>\n/i', '', $parserOutput->mText
		);

		return true;
	}

	/*
	 * This hook is called at the beginning of Parser::internalParse().
	 *
	 * @param Parser $parser
	 * @param string &$text Text to parse
	 * @param StripState $stripState StripState instance being used
	 */
	public static function onParserBeforeInternalParse( $parser, &$text, $stripState ) {
		if ( $parser->getTitle()->isSpecialPage() === true ) {
			return true;
		};

		//$text = "1ello! action is: $action";
		$pattern = '(={1,6})\s*metadata\s*\1' ;
		$text = preg_replace( "/$pattern/im", self::METADATA_CONTENT, $text );
	}

}
