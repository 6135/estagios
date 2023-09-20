<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class reports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reports:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'DEI account recovery system daily report';

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
     * @return mixed
     */
    public function handle()
    {
        echo "handle function()" . PHP_EOL;
        echo config('estagios.estado.20') . PHP_EOL;
        echo config('estagios.estado.10') . PHP_EOL;
        echo config('estagios.curso.mecd') . PHP_EOL;
        echo config('estagios.curso.msi') . PHP_EOL;
    }
}
