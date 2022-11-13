<?php

namespace Pedros80\NREphp\Darwin\Commands;

use Exception;
use Pedros80\NREphp\Shared\Services\Broker;
use Stomp\Transport\Frame;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PushPortListener extends Command
{
    protected static $defaultName       = 'darwin:pushPortListener';
    protected static $defaultDescrption = 'Listen to Darwin PushPort topic';

    private const HOST = 'darwin-dist-44ae45.nationalrail.co.uk';
    private const PORT = 61613;

    private const TOPICS = [
        'darwin.pushport-v16',
        'darwin.status',
    ];

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
            $broker = new Broker(self::HOST, self::PORT, $user, $pass);
        } catch (Exception $e) {
            $output->writeln('<error>Failed to connect to broker</error>');
            $output->writeln("<comment>{$e->getMessage()}</comment>");

            return Command::FAILURE;
        }
        $output->writeln('<comment>Connected to broker, listening for messages...</comment>');

        foreach (self::TOPICS as $topic) {
            $broker->subscribe($topic);
        }

        while (true) {
            $message = $broker->read();
            if ($message instanceof Frame) {
                if ($message['type'] === 'terminate') {
                    $output->writeln('<comment>Received shutdown command</comment>');

                    return Command::SUCCESS;
                }
                $output->writeln('<info>Processed message: ' . '$message->getBody()' . '</info>');
                $broker->ack($message);
            }
            usleep(100000);
        }
    }
}
