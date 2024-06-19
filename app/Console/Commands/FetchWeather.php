<?php

namespace App\Console\Commands;

use App\Models\WeatherItem;
use Illuminate\Console\Command;

class FetchWeather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:weather';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command fetch weather of provinces';

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
        $items = WeatherItem::get();
        foreach($items as $item) {
            \Illuminate\Support\Facades\Log::info('The loop ran. ' . $item->title);
        }
        // Logic here: Article::whereDate('published_at', '<=', now())->scheduled()->update(['status' => Article::STATUS_PUBLISHED]);
    }
}
