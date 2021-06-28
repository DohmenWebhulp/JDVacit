<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\ArrayInput;

use App\Service\UserService;

class ImportSpreadsheetCommand extends Command{

    private $us;

    public function __construct(UserService $us){

        parent::__construct();
        $this->us = $us;
    }

    protected function configure(){

        $this->setName('app:import-spreadsheet');
        $this->setDescription('Imports spreadsheet from Excel');
        $this->setHelp('This command allows');
        $this->addArgument("file", InputArgument::REQUIRED, "Spreadsheet");
    }

    protected function execute(InputInterface $input, OutputInterface $output){

        $inputFileName = $input->getArgument("file");
        $spreadsheet = IOFactory::load($inputFileName);
        $data = $spreadsheet->getActiveSheet();
        $this->impService->importSheet($data);
        return 0;
    }
}