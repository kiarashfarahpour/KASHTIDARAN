<?php

namespace App\Console;

use App\Models\WeatherItem;
use File;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Storage;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\FetchWeather',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //$schedule->command('fetch:weather')->everyMinute();
        // TODO:: Transfer code to command in future
        $items = WeatherItem::get();
        foreach($items as $item) {
            if($item->method == 1) {
                if($item->updated_at->diffInMinutes(now()) >= $item->duration) {
		            /*//\Storage::disk('public')->put('filename.pdf', $data);
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $item->link);
                    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
                    $file = curl_exec ($ch);
                    curl_close ($ch); 
                    //Storage::disk('public')->put($item->id . '.' . $item->suffix, $file);
                    File::put(public_path('storage/files/' . $item->id . '.' . $item->suffix), $file);
                    $file = file_get_contents($item->link);
                    file_put_contents('/'. $itme->id . '.' . $item->suffix, $file);
                    \Illuminate\Support\Facades\Log::info('The loop ran. ' . $item->title . ' - ' . public_path('storage/files/' . $item->id . '.' . $item->suffix));*/
                }
            } elseif($item->method == 2) {
                if($item->updated_at->diffInMinutes(now()) >= $item->duration) {
                    libxml_use_internal_errors(true);
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $item->link);
                    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
                    $content = curl_exec ($ch);
                    curl_close ($ch); 
                    File::put(public_path('storage/files/' . $item->id . '.html'), $content);
                    $dom = new \DOMDocument("1.0", "utf-8");
                    $dom->loadHTMLFile(public_path('storage/files/' . $item->id . '.html'));
                    $div = $dom->getElementById($item->element);
		            $item->content = $div->textContent;
		            $item->save();
                }
            }
        }
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
