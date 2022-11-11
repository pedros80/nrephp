<?php

declare(strict_types=1);

namespace Pedros80\Build\Writers;

use League\Flysystem\Filesystem;

final class FileWriter implements Writer
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
