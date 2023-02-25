<?php

declare(strict_types=1);

namespace Pedros80\Build\Commands;

use Pedros80\Build\Writers\Writer;
use Pedros80\Build\Writers\WriterFactory;
use Pedros80\NREphp\Factories\ServicesFactory;
use Pedros80\NREphp\Services\KnowledgeBase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class GetStationData extends Command
{
    protected static $defaultName = 'build:getStationData';

    protected static $defaultDescription = 'Get the current data on Stations';

    private string $token;
    private bool $dry;

    private string $filename = 'stations.xml.gz';

    private Writer $writer;
    private KnowledgeBase $kb;

    public function configure(): void
    {
        $this->addArgument('token', InputArgument::REQUIRED, 'Your token');
        $this->addOption('dry-run');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $serviceFactory = new ServicesFactory();

        $this->token  = $input->getArgument('token');
        $this->dry    = $input->getOption('dry-run');
        $this->kb     = $serviceFactory->makeKnowledgeBase();
        $this->writer = $this->getWriter();

        $success = $this->writeStationsFile();
        $message = $success ? 'Stations file updated' : 'Stations file NOT updated';
        $output->writeln($message);

        return $success ? Command::SUCCESS : Command::FAILURE;
    }

    private function writeStationsFile(): bool
    {
        $data = $this->kb->stations($this->token);
        $data = gzencode($data);

        return $this->writer->write($this->filename, $data);
    }

    private function getWriter(): Writer
    {
        $writerFactory = new WriterFactory();

        return $this->dry ? $writerFactory->makeConsoleWriter() : $writerFactory->makeFileWriter('data');
    }
}
