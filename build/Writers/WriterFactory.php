<?php

declare(strict_types=1);

namespace Pedros80\Build\Writers;

use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;
use Pedros80\Build\Writers\ConsoleWriter;
use Pedros80\Build\Writers\FileWriter;

final class WriterFactory
{
    public function makeFileWriter(string $root): FileWriter
    {
        return new FileWriter(
            new Filesystem(
                new LocalFilesystemAdapter($root)
            )
        );
    }

    public function makeConsoleWriter(): ConsoleWriter
    {
        return new ConsoleWriter();
    }
}
