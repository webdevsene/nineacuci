<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class CustomRepertoireCommand extends Command
{

    const SUCCESSFUL_EXECUTION_CONDITION = "";
    const EXECUTION_FAILURE_CONDITION = "";
    const INVALID_EXECUTION_CONDITION = "";

    private  $entityManager;
    private $container;
    
    public function __construct(EntityManagerInterface  $entityManager,ContainerInterface $container)
    {

        // 3. Update the value of the private entityManager variable through injection
        $this->entityManager =  $entityManager;
        $this->container = $container;
        

        parent::__construct();
    }


    // In this function set the name, description and help hint for the command
    protected function configure(): void
    {
        // Use in-build functions to set name, description and help

        $this->setName('repertoire:import')
             ->setDescription('This command runs your custom task to import check list informations for repertoire')
             ->setHelp('Run this command to execute your custom tasks in the execute function.');
    }

    // write the code you want to execute when command runs
    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        // Return below values according to the occurred situation

        if (SUCCESSFUL_EXECUTION_CONDITION) {

            // if everything is executed successfully with no issues then return SUCCESS as below
            return Command::SUCCESS;

        } elseif (EXECUTION_FAILURE_CONDITION) {

            // if execution fails return FAILURE as below
            return Command::FAILURE;

        } elseif (INVALID_EXECUTION_CONDITION) {

            // if invalid things happens i.e. invalid arguments etc. then return INVALID as below
            return Command::INVALID ;

        }
    }
}