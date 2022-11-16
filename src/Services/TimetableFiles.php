<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Services;

use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemException;
use League\Flysystem\StorageAttributes;
use League\Flysystem\UnableToReadFile;
use Pedros80\NREphp\Exceptions\CantReadTimetableFile;
use Pedros80\NREphp\Exceptions\NoTimetableFiles;

final class TimetableFiles
{
    public function __construct(
        private Filesystem $filesystem
    ) {
    }

    public function listFiles(): array
    {
        $files = $this->filesystem->listContents('')
            ->filter(fn (StorageAttributes $storageAttributes) => $storageAttributes->isFile())
            ->map(fn (StorageAttributes $storageAttributes) => $storageAttributes->path())
            ->toArray();

        if (!$files) {
            throw new NoTimetableFiles();
        }

        return $files;
    }

    public function getFile(string $path): string
    {
        try {
            $file = $this->filesystem->read($path);

            return $file;
        } catch (FilesystemException | UnableToReadFile) {
            throw CantReadTimetableFile::fromPath($path);
        }
    }
}
