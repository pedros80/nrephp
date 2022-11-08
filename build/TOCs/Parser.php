<?php

declare(strict_types=1);

namespace Pedros80\Build\TOCs;

use DOMDocument;
use DOMElement;
use League\Flysystem\Filesystem;

final class Parser
{
    public function __construct(
        private Filesystem $filesystem
    ) {
    }

    public function parse(): array
    {
        $out  = [];
        $html = $this->filesystem->read('tocs.html');
        $doc  = new DOMDocument();
        $doc->loadHTML($html);

        $table = $doc->getElementById('tablesort');

        $rows = $table->getElementsByTagName('tr');
        foreach ($rows as $row) {
            [$code, $name, $date] = $this->parseRow($row);
            if ($code) {
                $out[] = [
                    'code' => $code,
                    'name' => $name,
                    'date' => $date,
                ];
            }
        }

        return $out;
    }

    private function parseRow(DOMElement $row): array
    {
        $cells = $row->getElementsByTagName('td');

        $code = $cells->item(0)?->textContent;
        $name = $cells->item(1)?->firstElementChild?->textContent;
        $date = $cells->item(2)?->textContent;

        return [$code, $name, $date];
    }
}
