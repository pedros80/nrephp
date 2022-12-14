<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Services;

use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemException;
use League\Flysystem\StorageAttributes;
use League\Flysystem\UnableToReadFile;
use Pedros80\NREphp\Exceptions\CantReadMessagesFile;
use Pedros80\NREphp\Exceptions\CantReadSnapShotFile;
use Pedros80\NREphp\Exceptions\NoMessagesFiles;
use Pedros80\NREphp\Exceptions\NoSnapShotFiles;

final class PushPortFiles
{
    public function __construct(
        private Filesystem $filesystem
    ) {
    }

    public function getSnapshot(): string
    {
        $files = $this->filesystem->listContents('snapshot', true)
                    ->sortByPath()
                    ->filter(fn (StorageAttributes $attributes) => $attributes->isFile())
                    ->toArray();

        if (!count($files)) {
            throw new NoSnapShotFiles();
        }

        try {
            $file = $this->filesystem->read($files[count($files) - 1]->path());

            return $file;
        } catch (FilesystemException | UnableToReadFile) {
            throw CantReadSnapShotFile::fromPath($files[count($files) - 1]->path());
        }
    }

    public function listMessages(): array
    {
        $files = $this->filesystem->listContents('pushport', true)
            ->sortByPath()
            ->filter(fn (StorageAttributes $attributes) => $attributes->isFile())
            ->map(fn (StorageAttributes $attributes) => $attributes->path())
            ->toArray();

        if (!count($files)) {
            throw new NoMessagesFiles();
        }

        return $files;
    }

    public function getMessage(string $path): string
    {
        try {
            $file = $this->filesystem->read($path);

            return $file;
        } catch (FilesystemException | UnableToReadFile) {
            throw CantReadMessagesFile::fromPath($path);
        }
    }
}
