<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Darwin\Services;

use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemException;
use League\Flysystem\StorageAttributes;
use League\Flysystem\UnableToReadFile;
use Pedros80\NREphp\Darwin\Exceptions\PushPort\CantReadSnapShotFile;
use Pedros80\NREphp\Darwin\Exceptions\PushPort\NoMessagesFiles;
use Pedros80\NREphp\Darwin\Exceptions\PushPort\NoSnapShotFiles;

final class PushPortFtp
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
            $file = $this->filesystem->read($files[0]->path());

            return $file;
        } catch (FilesystemException | UnableToReadFile) {
            throw CantReadSnapShotFile::fromPath($files[0]->path());
        }
    }

    public function getMessagesListing(): array
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
            throw CantReadSnapShotFile::fromPath($path);
        }
    }
}
