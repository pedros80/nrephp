<?php

declare(strict_types=1);

namespace Pedros80\Build\StationCodes;

use League\Flysystem\Filesystem;
use Pedros80\Build\Parser as BuildParser;

final class Parser implements BuildParser
{
    public function __construct(
        private Filesystem $filesystem
    ) {
    }

    public function parse(): array
    {
        $data = array_reduce(
            explode("\n", $this->filesystem->read('stations.csv')),
            function (array $codes, string $line) {
                $line = str_getcsv($line);
                for ($i = 0; $i <= 6; $i += 2) {
                    $name = $i;
                    $code = $i + 1;
                    if (
                        isset($line[$name]) &&
                        strlen($line[$name]) &&
                        isset($line[$code]) &&
                        strlen($line[$code])
                    ) {
                        $codes[$line[$code]] = $line[$name];
                    }
                }

                return $codes;
            },
            []
        );

        asort($data);

        $data['???'] = 'Unknown';

        return $data;
    }
}
