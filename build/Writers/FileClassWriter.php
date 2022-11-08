<?php

declare(strict_types=1);

namespace Pedros80\Build\Writers;

use League\Flysystem\Filesystem;
use Pedros80\Build\Writers\ClassWriter;

final class FileClassWriter implements ClassWriter
{
    public function __construct(
        private Filesystem $fileSystem
    ) {
    }

    public function write(string $path, string $content): void
    {
        $this->fileSystem->write($path, $content);
    }
}
