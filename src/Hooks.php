<?php

namespace MediaWiki\Extension\HideMetadataSection;

use MediaWiki\Hook\OutputPageParserOutputHook;
use MediaWiki\Hook\ParserBeforeInternalParseHook;

class Hooks implements
	ParserBeforeInternalParseHook,
	OutputPageParserOutputHook
{
	private const METADATA_CONTENT = '<!-- Metadata -->';

	/**
	 * @inheritDoc
	 */
	public function onOutputPageParserOutput( $outputPage, $parserOutput ): void {
		// getRawText() throws on a metadata-only ParserOutput, so leave those alone
		if ( !$parserOutput->hasText() ) {
			return;
		}

		$text = preg_replace(
			'/\<li class="toclevel.*?#MetaData.*?\<\/li>\n/i', '', $parserOutput->getRawText()
		);
		$parserOutput->setRawText( $text );
	}

	/**
	 * @inheritDoc
	 */
	public function onParserBeforeInternalParse( $parser, &$text, $stripState ): void {
		if ( $parser->getTitle()->isSpecialPage() === true ) {
			return;
		}

		$pattern = '(={1,6})\s*metadata\s*\1';
		$text = preg_replace( "/$pattern/im", self::METADATA_CONTENT, $text );
	}
}
