<?php

namespace MediaWiki\Extension\HideMetadataSection\Tests\Unit;

use MediaWiki\Extension\HideMetadataSection\Hooks;
use MediaWiki\Output\OutputPage;
use MediaWiki\Parser\ParserOutput;
use MediaWikiUnitTestCase;

/**
 * @covers \MediaWiki\Extension\HideMetadataSection\Hooks
 */
class HooksTest extends MediaWikiUnitTestCase {

	public function testOutputPageParserOutputLeavesTextlessOutputUntouched() {
		// A metadata-only ParserOutput: getRawText() would throw on it
		$parserOutput = new ParserOutput();
		$this->assertFalse( $parserOutput->hasText() );

		( new Hooks() )->onOutputPageParserOutput(
			$this->createMock( OutputPage::class ),
			$parserOutput
		);

		$this->assertFalse( $parserOutput->hasText() );
	}

	public function testOutputPageParserOutputRemovesMetadataTocEntry() {
		$html = "<ul>\n" .
			"<li class=\"toclevel-1 tocsection-1\"><a href=\"#Rights\">Rights</a></li>\n" .
			"<li class=\"toclevel-1 tocsection-2\"><a href=\"#MetaData\">MetaData</a></li>\n" .
			"<li class=\"toclevel-1 tocsection-3\"><a href=\"#Links\">Links</a></li>\n" .
			"</ul>";
		$parserOutput = new ParserOutput( $html );

		( new Hooks() )->onOutputPageParserOutput(
			$this->createMock( OutputPage::class ),
			$parserOutput
		);

		$this->assertSame(
			"<ul>\n" .
			"<li class=\"toclevel-1 tocsection-1\"><a href=\"#Rights\">Rights</a></li>\n" .
			"<li class=\"toclevel-1 tocsection-3\"><a href=\"#Links\">Links</a></li>\n" .
			"</ul>",
			$parserOutput->getRawText()
		);
	}
}
