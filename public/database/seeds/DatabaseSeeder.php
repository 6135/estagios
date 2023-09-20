<?php

use Database\Seeders\CountrySeeder;
use Database\Seeders\CursosSeeder;
use Database\Seeders\DocumentSeeder;
use Database\Seeders\EspecializacaoSeeder;
use Database\Seeders\EstadoPropostaSeeder;
use Database\Seeders\VisibilidadeSeeder;
use Database\Seeders\EdicaoEstagioEvents;
use Database\Seeders\RoleSeeder;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CursosSeeder::class);
        $this->call(EspecializacaoSeeder::class);
        $this->call(DocumentSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(EstadoPropostaSeeder::class);
        $this->call(VisibilidadeSeeder::class);
        $this->call(EdicaoEstagioEvents::class);
        $this->call(RoleSeeder::class);
        $this->call(DocumentSeeder::class);
    }
}
