<?php

namespace Pedros80\Build;

use League\Flysystem\Filesystem;
use Pedros80\Build\ClassWriter;

final class FileClassWriter implements ClassWriter
{
    public function __construct(
        private Filesystem $fileSystem
    ) {
    }

    public function write(string $content): void
    {
        $this->fileSystem->write('Darwin\StationCode.php', $content);
    }
}