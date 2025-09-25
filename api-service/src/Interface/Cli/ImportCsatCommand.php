<?php

declare(strict_types=1);

namespace App\Interface\Cli;

use App\Application\Csat\UseCase\ImportCsatResponsesUseCase;
use App\Domain\Csat\ValueObject\ValidCsatFile;
use SplFileObject;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'csat:import')]
final class ImportCsatCommand extends Command
{
    public function __construct(private readonly ImportCsatResponsesUseCase $importCsatResponsesUseCase)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Imports CSAT records from a CSV file')
            ->addArgument('file', InputArgument::REQUIRED, 'Relative path to the CSV file');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $inputPath = $input->getArgument('file');

        $file = new ValidCsatFile($inputPath);
        $splFile = new SplFileObject($file->filePath());

        $this->importCsatResponsesUseCase->importFromFile(
            $splFile,
            $file->week()->value(),
            $file->year()->value(),
        );

        $output->writeln(sprintf('Command: %s success', $this->getName()));

        return Command::SUCCESS;
    }
}
