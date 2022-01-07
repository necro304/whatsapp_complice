<?php

namespace App\Console\Commands;

use App\Models\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SendWhatsapp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:whatsapp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar mensaje a los usuarios de la tabla clients';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    private $errors = 0;
    private $success = 0;

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $this->output->title('Iniciar proceso de envios de whatsapp');
        $clients = Client::where('establecimiento', 'kosh')->get();


         $contador = 1;
        $bar = $this->output->createProgressBar(count($clients));

        foreach ($clients as $client) {
            if($contador >= 220){
                $this->sendWhatsapp($client);
            }
            ++$contador;

            $bar->advance();
        }

        $bar->finish();

        $this->output->title('');
        $this->output->title('errores: '. $this->errors);

    }

    private function sendWhatsapp(Client $client){

        $content = "Hola ".$client->nombre.", el remate de la champion hoy en Kosh Rooftop con nuestro jangeo Sunset. paga 4 cervezas y lleva 6 🍻!!! Reserva y obtén beneficios 🤟🏻!! https://api.whatsapp.com/send/?phone=573006377875&text&app_absent=0";
        //$content = 'Hola '.$client->nombre .', Te esperamos hoy en🔥 ya no tiene novio. Reserva y obtén beneficios 🤟🏻!! https://api.whatsapp.com/send/?phone=573147836688&text&app_absent=0';
        //content = 'Hola '. $client->nombre .', hoy en Tierrabomba💣 te invitamos a ti y a tus amigos sin cover antes de las 9 Pm, te esperamos🔥🔥! Confirma tu reserva y disfruta de muchos beneficios.';
        $to = '57'. $client->celular.'@c.us';

        $response = Http::accept('application/json')->post('http://localhost:3000/whatsapp/send-message-img', [
            'content' => $content,
            'to' => $to,
        ]);

        if($response->serverError()){
            ++$this->errors;
        }
        if($response->ok()){
            ++$this->success;
        }



    }
}
