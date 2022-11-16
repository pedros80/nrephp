<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use League\Flysystem\Filesystem;
use League\Flysystem\InMemory\InMemoryFilesystemAdapter;
use Pedros80\NREphp\Exceptions\CantReadMessagesFile;
use Pedros80\NREphp\Exceptions\NoMessagesFiles;
use Pedros80\NREphp\Exceptions\NoSnapShotFiles;
use Pedros80\NREphp\Services\PushPortFiles;
use PHPUnit\Framework\TestCase;

final class PushPortFilesTest extends TestCase
{
    public function testPushPortFilesCanBeInstantiated(): void
    {
        $pushPortFiles = new PushPortFiles(
            new Filesystem(
                new InMemoryFilesystemAdapter()
            )
        );

        $this->assertInstanceOf(PushPortFiles::class, $pushPortFiles);
    }

    public function testGetSnapshotWhenEmptyThrowsException(): void
    {
        $this->expectException(NoSnapShotFiles::class);

        $pushPortFiles = new PushPortFiles(
            new Filesystem(
                new InMemoryFilesystemAdapter()
            )
        );

        $pushPortFiles->getSnapshot();
    }

    public function testGetSnapshotReturnsMostRecentFile(): void
    {
        $fileSystem = new Filesystem(
            new InMemoryFilesystemAdapter()
        );

        $fileSystem->write('snapshot/1.csv', 'first file');
        $fileSystem->write('snapshot/2.csv', 'second file');
        $fileSystem->write('snapshot/3.csv', 'third file');

        $pushPortFiles = new PushPortFiles($fileSystem);

        $this->assertEquals('third file', $pushPortFiles->getSnapshot());
    }

    public function testGetMessagesEmptyThrowsException(): void
    {
        $this->expectException(NoMessagesFiles::class);

        $pushPortFiles = new PushPortFiles(
            new Filesystem(
                new InMemoryFilesystemAdapter()
            )
        );

        $pushPortFiles->listMessages();
    }

    public function testListMessagesReturnsArrayOfFilePaths(): void
    {
        $fileSystem = new Filesystem(
            new InMemoryFilesystemAdapter()
        );

        $fileSystem->write('pushport/1.csv', 'first file');
        $fileSystem->write('pushport/2.csv', 'second file');
        $fileSystem->write('pushport/3.csv', 'third file');

        $pushPortFiles = new PushPortFiles($fileSystem);

        $this->assertEquals([
            'pushport/1.csv',
            'pushport/2.csv',
            'pushport/3.csv',
        ], $pushPortFiles->listMessages());
    }

    public function testGetMessageReturnsCorrectContent(): void
    {
        $fileSystem = new Filesystem(
            new InMemoryFilesystemAdapter()
        );

        $fileSystem->write('pushport/1.csv', 'first file');
        $fileSystem->write('pushport/2.csv', 'second file');
        $fileSystem->write('pushport/3.csv', 'third file');

        $pushPortFiles = new PushPortFiles($fileSystem);

        $this->assertEquals('second file', $pushPortFiles->getMessage('pushport/2.csv'));
    }

    public function testGetInvalidMessageThrowsException(): void
    {
        $this->expectException(CantReadMessagesFile::class);
        $this->expectExceptionMessage('Can not open Messages file file_doesnt_exist.csv');

        $pushPortFiles = new PushPortFiles(
            new Filesystem(
                new InMemoryFilesystemAdapter()
            )
        );

        $pushPortFiles->getMessage('file_doesnt_exist.csv');
    }
}
