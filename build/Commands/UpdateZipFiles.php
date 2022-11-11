<?php

namespace Pedros80\Build\Commands;

use Pedros80\Build\Writers\Writer;
use Pedros80\Build\Writers\WriterFactory;
use Pedros80\NREphp\OpenData\DTD\DTD;
use Pedros80\NREphp\OpenData\Factories\HttpClientFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class UpdateZipFiles extends Command
{
    protected static $defaultName = 'build:updateZipFiles';

    protected static $defaultDescription = 'Grab all the zip files';

    private string $token;
    private ?string $single;
    private bool $dry;

    private Writer $writer;
    private DTD $dtd;

    private const FEEDS = [
        'fares',
        'routeing',
        'timetable',
    ];

    public function configure(): void
    {
        $this->addArgument('token', InputArgument::REQUIRED, 'Your token');
        $this->addArgument('feed', InputArgument::OPTIONAL, 'Limit to a particular feed?');
        $this->addOption('dry-run');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->token  = $input->getArgument('token');
        $this->single = $input->getArgument('feed');
        $this->dry    = $input->getOption('dry-run');
        $this->dtd    = $this->getService();
        $this->writer = $this->getWriter();

        $this->results($this->doFeeds(), $output);

        return Command::SUCCESS;
    }

    private function doFeeds(): array
    {
        $processed = [];

        foreach (self::FEEDS as $feed) {
            if (!$this->single || $this->single === $feed) {
                $data = $this->dtd->$feed($this->token);
                $this->writer->write("{$feed}.zip", $data);
                $processed[] = $feed;
            }
        }

        return $processed;
    }

    private function results(array $processed, OutputInterface $output): void
    {
        if (count($processed) === 0) {
            $output->writeln('No feeds processed');

            return;
        }

        $s         = count($processed) === 1 ? '' : 's';
        $processed = implode(', ', $processed);
        $output->writeln("Processed the feed{$s} {$processed}");
    }

    private function getService(): DTD
    {
        $clientFactory = new HttpClientFactory();
        $client        = $clientFactory->makeClient();

        return new DTD($client);
    }

    private function getWriter(): Writer
    {
        $writerFactory = new WriterFactory();

        return $this->dry ? $writerFactory->makeConsoleWriter() : $writerFactory->makeFileWriter('data/zip/dtd');
    }
}
