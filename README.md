# HideMetadataSection

A MediaWiki extension that automatically hides sections titled "Metadata" from page content and table of contents.

## Installation

1. Place the extension in `extensions/HideMetadataSection/`
2. Add to `LocalSettings.php`:
   ```php
   wfLoadExtension( 'HideMetadataSection' );
   ```

## Usage

Any section with a heading named "Metadata" (case-insensitive) will be automatically hidden from:
- Page content (replaced with an HTML comment)
- Table of contents
