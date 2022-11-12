<?php

declare(strict_types=1);

namespace Pedros80\Build\Writers;

use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemException;
use League\Flysystem\UnableToWriteFile;

final class FileWriter implements Writer
{
    public function __construct(
        private Filesystem $fileSystem
    ) {
    }

    public function write(string $path, string $content): bool
    {
        try {
            $this->fileSystem->write($path, $content);
        } catch (FilesystemException | UnableToWriteFile) {
            return false;
        }

        return true;
    }
}
