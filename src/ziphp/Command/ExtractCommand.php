<?php

namespace ziphp\Command;

use ziphp\Service\ZipService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class ExtractCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('extract')
            ->setDescription('Unzips a file')
            ->setHelp('This command unzips an archive...')
            ->addArgument(
                'source',
                InputArgument::REQUIRED,
                'Input zip file to extract'
            )
            ->addArgument(
                'target',
                InputArgument::OPTIONAL,
                'Output path for extraction'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $arguments = $input->getArguments();
        $arguments['target'] = $arguments['target'] ?: getcwd();

        $output->writeln($this->getApplication()->getName() .  '@' . $this->getApplication()->getVersion() . ' by Typomedia Foundation, Philipp Speck');
        $output->writeln('<info>Extracting ' . $arguments['source'] . '...</info>');

        $zip = new ZipService();
        try {
            $zip->open($arguments['source']);
            $zip->extractTo($arguments['target']);
            $zip->close();
        } catch (IOExceptionInterface $e) {
            echo 'An error occurred while extracting your zip at '.$e->getPath();
        }
    }
}
