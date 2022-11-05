<?php

declare(strict_types=1);

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
        $this->fileSystem->write('Darwin\Params\StationCode.php', $content);
    }
}
