<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SaludarUsuario extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'saludar:usuario {name} {--time}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Saluda al usuario con su nombre y opcionalmente muestra la hora actual';

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
        $usuario = $this->argument('name');
        $this->info("¡Hola, $usuario!");

        if($this->option('time')){
            $horaActual = now()->format('H:i:s');
            $this->info("La hora actual es: $horaActual");
        }
    }
}
