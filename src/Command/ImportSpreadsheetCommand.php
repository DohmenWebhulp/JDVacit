<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\ArrayInput;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
        $array = $this->readTheSheet($data, 'A2:H3');
        
        $result = $this->convertToDatabase($array);

        return 0;
    }

    private function readTheSheet($data, $string){

        $array = $data->rangeToArray(
            $string,
            NULL,
            TRUE,
            TRUE,
            TRUE
        );

        return($array);
    }

    private function convertToDatabase($array){

        $result = [];

        foreach($array as $row){
            $database = array(
                'email' => $row["A"],
                'roles' => ["ROLE_COMPANY"],
                'password' => $this->generate_string(8),
                'record_type' => $row["B"],
                'gebruikersnaam' => $row["C"],
                'adres' => $row["D"],
                'geboortedatum' => new \DateTime($row["E"]),
                'telefoonnummer' => $row["F"],
                'postcode' => $row["G"],
                'woonplaats' => $row["H"]
            );

            $result[] = $this->us->toevoegenUser($database);
        }

        return($result);
    }

    private function generate_string($strength = 16) {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $input_length = strlen($permitted_chars);
        $random_string = '';
        for ($i = 0; $i < $strength; $i++) {
            $random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

        return $random_string;
    }
}