<?php

namespace ziphp\Command;

use ziphp\Service\ZipService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class CompressCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('compress')
            ->setDescription('Zips a file')
            ->setHelp('This command zips a file or folder...')
            ->addArgument(
                'source',
                InputArgument::REQUIRED,
                'Input file or folder to zip'
            )
            ->addArgument(
                'target',
                InputArgument::OPTIONAL,
                'Output path for zip file'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $arguments = $input->getArguments();
        $arguments['target'] = $arguments['target'] ?: basename($arguments['source']) . '.zip';

        $output->writeln($this->getApplication()->getName() .  '@' . $this->getApplication()->getVersion() . ' by Typomedia Foundation, Philipp Speck');
        $output->writeln('<info>Compressing ' . $arguments['source'] . '...</info>');

        $zip = new ZipService();
        try {
            $zip->open($arguments['target'], ZipService::CREATE);
            $zip->addFolder($arguments['source'], $arguments['target']);
            $zip->close();
        } catch (IOExceptionInterface $e) {
            echo 'An error occurred while creating your zip at ' . $e->getPath();
        }
    }
}
