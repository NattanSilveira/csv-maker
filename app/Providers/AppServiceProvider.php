<?php

namespace App\Providers;

use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;
use ReflectionProperty;

class AppServiceProvider extends ServiceProvider
{
    private $queue = [];
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Queue::after(function (JobProcessed $event) {

            $payload = json_decode( $event->job->getRawBody() );
            $data = unserialize($payload->data->command);
            $property = new ReflectionProperty($data, 'request');
            $property->setAccessible(true);

            $csvQueue = DB::table('jobs')->whereQueue('csv-queue')->get();

            array_push($this->queue, (array)$property->getValue($data));

            if ($csvQueue->count() <= 0) {

                try {
                    $filename = "json-to-csv.csv";
                    $path = storage_path('app/public/');

                    $handle = fopen($path.$filename, 'w');

                    $this->queue = array_reverse($this->queue);

                    foreach ($this->queue as $key => $item) {
                        $header = (array_keys($this->queue[$key]));
                        fputcsv($handle,  $header, ';');
                        fputcsv($handle,  $item);

                    }

                    fclose($handle);
                } catch(\Exception $ex){
                    Log::info($ex);
                }


            }

        });

    }

}
