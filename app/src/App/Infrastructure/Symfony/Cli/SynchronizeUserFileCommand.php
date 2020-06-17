<?php

namespace App\Infrastructure\Symfony\Cli;

use App\Infrastructure\User\CSVUserFilepathRetriever;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class SynchronizeUserFileCommand extends Command
{
    const URL = "https://drive.google.com/uc?export=download&id=1iurSedxD6c7Wp-1zdpmZGrV5hvZDhH2_";

    protected static $defaultName = 'user:synchronize-file';

    /** @var CSVUserFilepathRetriever */
    private $csvUserFilepathRetriever;

    public function __construct(CSVUserFilepathRetriever $csvUserFilepathRetriever)
    {
        parent::__construct();

        $this->csvUserFilepathRetriever = $csvUserFilepathRetriever;
    }

    protected function configure()
    {
        $this
            ->setDescription('Synchronize the users file.')
            ->setHelp('This command connects to the cloud users csv file and download it.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filesystem = new Filesystem();

        $section = $output->section();
        $section->writeln('Importing users file...');
        $filesystem->copy(self::URL, $this->csvUserFilepathRetriever->get());
        $section->writeln('Done');

        return 0;
    }
}
