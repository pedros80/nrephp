<?php

declare(strict_types=1);

namespace Tests\Darwin\Services;

use League\Flysystem\Filesystem;
use League\Flysystem\InMemory\InMemoryFilesystemAdapter;
use Pedros80\NREphp\Darwin\Exceptions\PushPort\CantReadTimetableFile;
use Pedros80\NREphp\Darwin\Exceptions\PushPort\NoTimetableFiles;
use Pedros80\NREphp\Darwin\Services\TimetableFiles;
use PHPUnit\Framework\TestCase;

final class TimetableFilesTest extends TestCase
{
    public function testTimetableFilesCanBeInstantiated(): void
    {
        $timetableFiles = new TimetableFiles(
            new Filesystem(
                new InMemoryFilesystemAdapter()
            )
        );

        $this->assertInstanceOf(TimetableFiles::class, $timetableFiles);
    }

    public function testListFilesReturnsArrayOfFilePaths(): void
    {
        $fileSystem = new Filesystem(new InMemoryFilesystemAdapter());
        $fileSystem->write('file1.csv', 'abc');
        $fileSystem->write('file2.csv', 'def');

        $timetableFiles = new TimetableFiles($fileSystem);
        $this->assertEquals(['file1.csv', 'file2.csv'], $timetableFiles->listFiles());
    }

    public function testGetFileReturnsCorrectContent(): void
    {
        $fileSystem = new Filesystem(new InMemoryFilesystemAdapter());
        $fileSystem->write('file1.csv', 'abc');
        $fileSystem->write('file2.csv', 'def');

        $timetableFiles = new TimetableFiles($fileSystem);

        $this->assertEquals('def', $timetableFiles->getFile('file2.csv'));
    }

    public function testNoTimetableFilesThrowsException(): void
    {
        $this->expectException(NoTimetableFiles::class);

        $timetableFiles = new TimetableFiles(
            new Filesystem(
                new InMemoryFilesystemAdapter()
            )
        );

        $timetableFiles->listFiles();
    }

    public function testLoadingNotFoundTimetableFilesThrowsException(): void
    {
        $this->expectException(CantReadTimetableFile::class);
        $this->expectExceptionMessage('Can not open Timetable file file_does_not_exist.csv');

        $timetableFiles = new TimetableFiles(
            new Filesystem(
                new InMemoryFilesystemAdapter()
            )
        );

        $timetableFiles->getFile('file_does_not_exist.csv');
    }
}
