# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

- `Added` for new features.
- `Changed` for changes in existing functionality.
- `Deprecated` for soon-to-be removed features.
- `Removed` for now removed features.
- `Fixed` for any bug fixes.
- `Security` in case of vulnerabilities

## [2.0.3] - 2024.12.26

### Fixed

- Fixed bug in `send` method resetting response

## [2.0.2] - 2024.12.23

### Added

- Tested up to PHP v8.4.
- Updated GitHub issue templates

## [2.0.1] - 2023.02.03

### Fixed

- Fixed uninitialized typed property for `getBody` method

## [2.0.0] - 2023.01.23

### Added

- Added support for PHP 8

## [1.4.0] - 2022.01.23

### Changed

- Updated `sendJson` method to return `Content-Type` of `application/json`
- Miscellaneous code cleanup

## [1.3.0] - 2021.04.21

### Added

- Added support for additional status codes.

## [1.2.1] - 2021.02.28

### Fixed

- Fixed bug in `send` method where unnecessary `exit()` was causing destructors not to be called.

## [1.2.0] - 2020.11.27

### Added

- Added `removeHeaders` method.

## [1.1.1] - 2020.11.23

### Fixed

- Fixed bug in `send` method where `$_SERVER` may not be set.

## [1.1.0] - 2020.10.20

### Added

- Added `reset` method.

## [1.0.0] - 2020.08.10

### Added

- Initial release.