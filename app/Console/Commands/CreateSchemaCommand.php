<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateSchemaCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'create-schema';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Creates the database schema";

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $schemaName = $this->input->getOption('schemaName');

	    return DB::statement(DB::raw("CREATE DATABASE IF NOT EXISTS $schemaName"));
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array('schemaName', null, InputOption::VALUE_OPTIONAL, 'The schema name to be created', env('DB_NAME')),
        );
    }

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		return $this->laravel->call([$this, 'fire']);
	}

}