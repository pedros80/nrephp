<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Darwin\Commands;

use Exception;
use Pedros80\NREphp\Darwin\Services\PushPortBroker;
use Stomp\Transport\Frame;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PushPortListen extends Command
{
    protected static $defaultName        = 'darwin:pushPortListen';
    protected static $defaultDescription = 'Listen to Darwin PushPort topic';

    protected function configure(): void
    {
        $this->addArgument('username', InputArgument::REQUIRED, 'The Darwin Topic username');
        $this->addArgument('password', InputArgument::REQUIRED, 'Your Darwin Topic\'s password');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = $input->getArgument('username');
        $pass = $input->getArgument('password');

        try {
            $broker = PushPortBroker::fromCredentials($user, $pass);
        } catch (Exception $e) {
            $output->writeln('<error>Failed to connect to broker</error>');
            $output->writeln("<comment>{$e->getMessage()}</comment>");

            return Command::FAILURE;
        }
        $output->writeln('<comment>Connected to broker, listening for messages...</comment>');

        while (true) {
            $message = $broker->read();
            if ($message instanceof Frame) {
                if ($message['type'] === 'terminate') {
                    $output->writeln('<comment>Received shutdown command</comment>');

                    return Command::SUCCESS;
                }
                $output->writeln('<info>Processed message: ' . gzdecode($message->getBody()) . '</info>');
                $broker->ack($message);
            }
            usleep(100000);
        }
    }
}
