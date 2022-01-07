<?php

namespace App\Console\Commands;

use App\Imports\ClientsImport;
use Illuminate\Console\Command;

class ImportClients extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:clients';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para importar clientes desde el excel en el storage';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {

        $import = new ClientsImport();

        $this->output->title('Starting import');

        $import->import(storage_path('app/public/clients3.xlsx'));
        $errors = count($import->failures());
        $success = $import->getRowCountSuccess();
        $total = $import->getRowCount();

        //(new ClientsImport)->withOutput($this->output)->import(storage_path('app/public/clients.xlsx'));


        $this->output->success('Import successful');

        $this->output->title('Errors: '.$errors );
        $this->output->title('Success: '.$success );
        $this->output->title('Total: '.$total );


    }
}
