<?php

declare(strict_types=1);

namespace Pedros80\Build;

use Pedros80\Build\GeneratorFactory;
use Pedros80\Build\Writers\ClassWriter;
use Pedros80\Build\Writers\WriterFactory;

require __DIR__ . '/../vendor/autoload.php';

final class Builder
{
    public function __construct(
        private GeneratorFactory $generatorFactory,
        private ClassWriter $classWriter
    ) {
    }

    public function build(): void
    {
        /** @var Generator $generator */
        foreach ($this->generatorFactory->make() as $generator) {
            $this->classWriter->write($generator->getFilename(), $generator->generate());
        }
    }
}

$writerFactory = new WriterFactory();

$builder = new Builder(
    new GeneratorFactory(),
    $writerFactory->make(isset($argv[1]) && $argv[1] === 'dry-run')
);

$builder->build();
