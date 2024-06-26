<?php

declare(strict_types=1);

namespace Pedros80\Build\Commands;

use Pedros80\NREphp\Factories\ServicesFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class GetToken extends Command
{
    protected static $defaultName = 'build:getToken';

    protected static $defaultDescription = 'Generate a new access token from user/pass credentials';

    public function __construct()
    {
        parent::__construct('build:getToken');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        [$user, $pass] = $this->parseArguments($input);

        $serviceFactory = new ServicesFactory();
        $tokenGenerator = $serviceFactory->makeTokenGenerator($user, $pass);

        $this->displayToken($output, $tokenGenerator->get());

        return Command::SUCCESS;
    }

    private function displayToken(OutputInterface $output, array $token): void
    {
        foreach ($token as $key => $value) {
            $output->writeln("{$key} - {$value}");
        }
    }

    private function parseArguments(InputInterface $input): array
    {
        return [
            $input->getArgument('username'),
            $input->getArgument('password'),
        ];
    }

    public function configure(): void
    {
        $this->addArgument('username', InputArgument::REQUIRED, 'The username linked to your NRE profile');
        $this->addArgument('password', InputArgument::REQUIRED, 'Your NRE profile\'s password');
    }
}
