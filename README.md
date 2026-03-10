# Alt Text Checker

TYPO3 extension that adds a warning overlay icon to files in the File List module when the file is missing alternative text.

## Requirements

- TYPO3 13.4+

## Installation

```bash
composer require leuchtfeuer/alt-text-checker
```

## What it does

Hooks into the TYPO3 file icon rendering and adds an `overlay-warning` icon to any file in the File List module when:

- the file itself has no alternative text set in `sys_file_metadata`
- any of its file references has no alternative text set in `sys_file_reference`

This helps editors identify images that are missing alt text for accessibility compliance.

## License

GPL-2.0-or-later
