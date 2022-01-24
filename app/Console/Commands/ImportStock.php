<?php

namespace App\Console\Commands;

use App\Imports\StocksImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:stock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Stock';

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
     * @return int
     */
    public function handle()
    {
        Excel::import(new StocksImport, 'product.csv');
        Excel::import(new StocksImport, 'makeup.csv');
    }
}
