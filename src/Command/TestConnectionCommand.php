<?php

declare(strict_types=1);

namespace Madco\Tecsafe\Command;

use Madco\Tecsafe\Tecsafe\ApiClient;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'tecsafe:test-connection',
    description: 'Test connection to Tecsafe',
)]
class TestConnectionCommand extends Command
{
    public function __construct(
        private readonly ApiClient $apiClient
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $response = $this->apiClient->getJwks();

        if ($response->getStatusCode() !== 200) {
            $io->error('Error: ' . $response->getBody()->getContents());

            return Command::FAILURE;
        }

        $io->success('Connection test successful');

        return Command::SUCCESS;
    }
}
