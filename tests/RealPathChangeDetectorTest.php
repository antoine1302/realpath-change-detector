<?php

namespace Totoro1302\RealpathChangeDetector\Tests;

use PHPUnit\Framework\TestCase;
use Totoro1302\RealpathChangeDetector\RealPathChangeDetector;

class RealPathChangeDetectorTest extends TestCase
{
    private const FIXTURES_PATH = __DIR__ . '/fixtures';
    private const SYMLINK_PATH = __DIR__ . '/fixtures/symlinkDir';
    private const DIR_BEFORE = __DIR__ . '/fixtures/dirBefore';
    private const DIR_AFTER = __DIR__ . '/fixtures/dirAfter';

    public function testItReturnTrueIfPathChanged(): void
    {
        $this->switchLinkTo(self::DIR_BEFORE);

        $detector = new RealPathChangeDetector(self::SYMLINK_PATH . DIRECTORY_SEPARATOR . 'Source');

        $this->assertFalse($detector->pathHasChanged());

        $this->switchLinkTo(self::DIR_AFTER);

        $this->assertTrue($detector->pathHasChanged());
    }

    public function testItThrowsExceptionIfOriginalPathDoesntExist(): void
    {
        $this->expectException(\RuntimeException::class);
        new RealPathChangeDetector(self::FIXTURES_PATH . DIRECTORY_SEPARATOR . 'notExistingPath');
    }

    public function setUp(): void
    {
        $this->deleteSymlinkIfExists();
    }

    public function tearDown(): void
    {
        $this->deleteSymlinkIfExists();
    }

    private function deleteSymlinkIfExists(): void
    {
        if (file_exists(self::SYMLINK_PATH)) {
            unlink(self::SYMLINK_PATH);
        }
    }

    private function switchLinkTo(string $path): void
    {
        $this->deleteSymlinkIfExists();
        symlink($path, self::SYMLINK_PATH);
    }
}
