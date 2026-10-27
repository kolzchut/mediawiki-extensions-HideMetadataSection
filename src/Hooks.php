<?php

namespace MediaWiki\Extension\HideMetadataSection;

use MediaWiki\Hook\ParserBeforeInternalParseHook;

class Hooks implements ParserBeforeInternalParseHook {
	private const METADATA_CONTENT = '<!-- Metadata -->';

	/**
	 * Replace a "Metadata" heading with an HTML comment before the parser
	 * sees it. With no heading left there is no section to show and no
	 * table-of-contents entry for it.
	 *
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
