<?php

namespace MediaWiki\Extension\HideMetadataSection\Tests\Unit;

use MediaWiki\Extension\HideMetadataSection\Hooks;
use MediaWiki\Parser\Parser;
use MediaWiki\Parser\StripState;
use MediaWiki\Title\Title;
use MediaWikiUnitTestCase;

/**
 * @covers \MediaWiki\Extension\HideMetadataSection\Hooks
 */
class HooksTest extends MediaWikiUnitTestCase {

	private function runHook( string $text, bool $isSpecialPage = false ): string {
		$title = $this->createMock( Title::class );
		$title->method( 'isSpecialPage' )->willReturn( $isSpecialPage );
		$parser = $this->createMock( Parser::class );
		$parser->method( 'getTitle' )->willReturn( $title );

		( new Hooks() )->onParserBeforeInternalParse(
			$parser,
			$text,
			$this->createMock( StripState::class )
		);

		return $text;
	}

	public static function provideMetadataHeadings() {
		return [
			'level 2' => [ "Intro\n== Metadata ==\nData", "Intro\n<!-- Metadata -->\nData" ],
			'any case, no spaces' => [ "Intro\n==METADATA==\nData", "Intro\n<!-- Metadata -->\nData" ],
			'level 3' => [ "Intro\n=== metadata ===\nData", "Intro\n<!-- Metadata -->\nData" ],
		];
	}

	/**
	 * @dataProvider provideMetadataHeadings
	 */
	public function testParserBeforeInternalParseHidesMetadataHeading( string $text, string $expected ) {
		$this->assertSame( $expected, $this->runHook( $text ) );
	}

	public function testParserBeforeInternalParseKeepsOtherHeadings() {
		$text = "== Rights ==\nText\n== Metadata in the news ==\nText";
		$this->assertSame( $text, $this->runHook( $text ) );
	}

	public function testParserBeforeInternalParseSkipsSpecialPages() {
		$text = "== Metadata ==\nData";
		$this->assertSame( $text, $this->runHook( $text, true ) );
	}
}
