<?php

namespace Totoro1302\RealpathChangeDetector\Tests;

use PHPUnit\Framework\TestCase;
use Totoro1302\RealpathChangeDetector\RealPathChangeDetector;

class RealPathChangeDetectorTest extends TestCase
{
    private const REAL_PATH_01 = __DIR__ . '/some/realPath01';
    private const REAL_PATH_02 = __DIR__ . '/some/realPath02';
    private const SYMLINK_PATH = __DIR__ . '/some/symlinkPath';

    public function testItReturnTrueIfPathChanged(): void
    {
        mkdir(self::REAL_PATH_01, recursive: true);
        symlink(self::REAL_PATH_01, self::SYMLINK_PATH);

        $detector = new RealPathChangeDetector(self::SYMLINK_PATH);
        $this->assertFalse($detector->pathHasChanged());

        unlink(self::SYMLINK_PATH);
        mkdir(self::REAL_PATH_02, recursive: true);
        symlink(self::REAL_PATH_02, self::SYMLINK_PATH);

        $this->assertTrue($detector->pathHasChanged());

        unlink(self::SYMLINK_PATH);
        rmdir(self::REAL_PATH_01);
        rmdir(self::REAL_PATH_02);

        exec('rm -r ' . __DIR__ . '/some');
    }
}
