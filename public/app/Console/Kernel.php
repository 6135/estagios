<?php

namespace App\Console;

use App\Models\AccessLog;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //Log::debug('Kernel: cron schedule() begin');

        //$schedule->command('queue:work')->everyMinute()->withoutOverlapping();

        /*$schedule->command('inspire')->everyMinute()->when(function() {
            Log::debug('Kernel: cron schedule() ping');

            //VAI BUSCAR ACCOES ONDE NÃO TENHAM SIDO ENVIADAS NOTIFICAÇÕES
            $estagioActions = EstagioAction::whereNull('notificationssent')->get();

            $estagiosIds = EstagioAction::distinct()->whereNull('notificationssent')->get();

            //VAI BUSCAR ENDEREÇO DE EMAIL DA EMPRESA ASSOCIADA AO ESTÁGIO
            foreach ($estagiosIds as $estagioId) {
                try {

                    $estagio = Estagio::with('empresa')->where('idestagio', '=', $estagioId->estagio_idestagio)->take(1)->get();

//
                    if (sizeof($estagio) > 0) {
                        $emailEmpresa = $estagio[0]->empresa->emailempresa;
                    }
//
                    //Log::debug('email empresa: ' . $emailEmpresa);
                } catch (QueryException $e) {
                    //dd($e);
                    Log::error($e);
                }
            }

            //Log::debug("----------------------------------------------------------------------------------------------------");


            //
//            //VAI BUSCAR ENDEREÇO DE EMAIL DOS ALUNOS ASSOCIADO AO ESTÁGIO
//            //VAI BUSCAR ENDEREÇO DE EMAIL DO ORIENTADOR ASSOCIADO AO ESTÁGIO
//
//            //$estagioActions = EstagioAction::all()->where('estagio_idestagio', '=', '510');
//
            foreach ($estagioActions as $estagioAction) {
                try {

                    $estagioAction->update([
                        'notificationssent' => now(),
                    ]);
                } catch (QueryException $e) {
                    Log::error($e);
                }
            }
//
//
            return true;
        });*/

        $schedule->call(function () {
            $files = collect(Storage::disk('temporary')->files())
                ->filter(function($file) {
                    $delete = Storage::disk('temporary')->delete($file);
                    return !$delete;
                });

            Log::debug("temp files are: ".count($files));
        })->dailyAt("01:35");

        //delete database log entries older than 15 days
        $schedule->call(function () {
            $delete = AccessLog::where('data', '<', Carbon::now()->subDays(15))->get();
            $al = new AccessLog([
                'ipaddr' => 'localhost',
                'status' => 'Deleting',
                'acao' => 'Deleting old log entries',
                'detalhes' => 'Deleting old log entries. Deleted '. count($delete) . " entries: " . $delete->take(1000),
                'data' => Carbon::now(),
            ]);
            if(count($delete) > 0) {
                $al->save();
                //older than 90 days or if
                AccessLog::where('data', '<', Carbon::now()->subDays(15))->delete();
            }
            Log::debug("deleted ". count($delete) . " EstagioAction entries");
        })->daily();



        //  $schedule->call(function (){
        //     $filesPublic = collect(Storage::disk('public')->files())
        //         ->filter(function($file) {
        //             Log::debug($file);
        //             $delete = false;
        //             if(count(EmpresaColaborador::where('cv_colab',$file)->get()) == 0)
        //                 $delete = Storage::disk('public')->delete($file);
        //             return !$delete;
        //         });
        //     Log::debug("public Files are: ".count($filesPublic));

        // })->();

        //Log::debug('Kernel: cron schedule() end');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');

    }
}
