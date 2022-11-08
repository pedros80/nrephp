<?php

declare(strict_types=1);

namespace Pedros80\Build\Writers;

use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;
use Pedros80\Build\Writers\ConsoleClassWriter;
use Pedros80\Build\Writers\FileClassWriter;

final class WriterFactory
{
    public function make(bool $console): ClassWriter
    {
        return $console ? $this->makeConsoleWriter() : $this->makeFileWriter();
    }

    private function makeConsoleWriter(): ConsoleClassWriter
    {
        return new ConsoleClassWriter();
    }

    private function makeFileWriter(): FileClassWriter
    {
        return new FileClassWriter(
            new Filesystem(
                new LocalFilesystemAdapter('src')
            )
        );
    }
}
