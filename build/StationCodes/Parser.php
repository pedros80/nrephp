<?php

declare(strict_types=1);

namespace Pedros80\Build\StationCodes;

use Pedros80\Build\Parser as BuildParser;
use SimpleXMLElement;
use XMLReader;

final class Parser implements BuildParser
{
    public function parse(): array
    {
        $filename = getcwd() .'/data/xml/kb/stations.xml';

        if (!file_exists($filename)) {
            die("{$filename} - try running build:updateXmlFiles");
        }

        $xml = new XMLReader();
        $xml->open($filename);

        $codes = [];

        while ($xml->read() && $xml->name !== 'Station') {
            continue;
        }

        while ($xml->name === 'Station') {
            $element                           = new SimpleXMLElement($xml->readOuterXML());
            $codes[(string) $element->CrsCode] = (string) $element->Name;
            $xml->next('Station');
            unset($element);
        }

        asort($codes);
        $codes['???'] = 'Unknown';

        return $codes;
    }
}
