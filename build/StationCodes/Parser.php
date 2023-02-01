<?php

declare(strict_types=1);

namespace Pedros80\Build\StationCodes;

use Pedros80\Build\Parser as BuildParser;
use SimpleXMLElement;
use XMLReader;

final class Parser implements BuildParser
{
    private const ELEMENT = 'Station';

    private string $filename;

    public function __construct()
    {
        $this->filename = getcwd() . '/data/stations.xml.gz';

        if (!file_exists($this->filename)) {
            die("{$this->filename} - try running build:updateXmlFiles" . PHP_EOL);
        }
    }

    public function parse(): array
    {
        $codes = [];

        $xml = $this->getXMLReader();

        while ($xml->read() && $xml->name !== self::ELEMENT) {
            continue;
        }

        while ($xml->name === self::ELEMENT) {
            $element = new SimpleXMLElement($xml->readOuterXML());

            $code = (string) $element->CrsCode;
            $name = (string) $element->Name;

            $codes[$code] = $name;
            $xml->next(self::ELEMENT);
            unset($element);
        }

        asort($codes);
        $codes['???'] = 'Unknown';

        return $codes;
    }

    private function getXMLReader(): XMLReader
    {
        $xml = new XMLReader();
        $xml->open("compress.zlib://{$this->filename}");

        return $xml;
    }
}
