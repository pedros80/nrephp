<?php

declare(strict_types=1);

namespace Pedros80\Build\Commands;

use Pedros80\Build\Builder;
use Pedros80\Build\GeneratorFactory;
use Pedros80\Build\Writers\WriterFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class BuildClasses extends Command
{
    protected static $defaultName = 'build:classes';

    protected static $defaultDescription = 'Generate and write to file any classes to be built';

    public function configure(): void
    {
        $this->addOption('dry-run');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $builder = $this->getBuilder($input->getOption('dry-run'));

        $this->results($builder->build(), $output);

        return Command::SUCCESS;
    }

    private function getBuilder(bool $dry): Builder
    {
        $writerFactory = new WriterFactory();

        $writer = $dry ? $writerFactory->makeConsoleWriter() : $writerFactory->makeFileWriter('src');

        return new Builder(new GeneratorFactory(), $writer);
    }

    private function results(array $files, OutputInterface $output): void
    {
        if (count($files) === 0) {
            $output->writeln('No classes built.');
        }

        $s     = count($files) === 1 ? '' : 's';
        $files = implode(', ', $files);
        $output->writeln("Built the following file{$s}: {$files}");
    }
}
