<?php

declare(strict_types=1);

namespace Pedros80\Build;

use Pedros80\Build\GeneratorFactory;
use Pedros80\Build\Writers\Writer;

final class Builder
{
    public function __construct(
        private GeneratorFactory $generatorFactory,
        private Writer $classWriter
    ) {
    }

    public function build(): array
    {
        $out = [];
        /** @var Generator $generator */
        foreach ($this->generatorFactory->make() as $generator) {
            $this->classWriter->write($generator->getFilename(), $generator->generate());
            $out[] = $generator->getFileName();
        }

        return $out;
    }
}
