<?php

declare(strict_types=1);

namespace Pedros80\Build;

use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;
use Pedros80\Build\Printer;
use Pedros80\Build\StationCodes\Generator as StationCodesGenerator;
use Pedros80\Build\StationCodes\Parser as StationCodesParser;
use Pedros80\Build\TOCs\Generator as TOCsGenerator;
use Pedros80\Build\TOCs\Parser as TOCsParser;

final class GeneratorFactory
{
    private Printer $printer;
    private Filesystem $localFiles;

    public function __construct()
    {
        $this->printer    = new Printer();
        $this->localFiles = new Filesystem(new LocalFilesystemAdapter('data'));
    }

    public function make(): array
    {
        return [
            new StationCodesGenerator(
                new StationCodesParser($this->localFiles),
                $this->printer
            ),
            new TOCsGenerator(
                new TOCsParser($this->localFiles),
                $this->printer
            ),
        ];
    }
}
