<?php

namespace App\Console\Commands;

use App\Http\Controllers\DriverControl;
use App\Http\Controllers\Drivers\FaceDetection;
use App\Models\SystemConfigs;
use Illuminate\Console\Command;

class DriverSandbox extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:driver-sandbox';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sandox for driver application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $imageFile = base_path("room.jpg");
        $result = (new DriverControl)
            ->use(SystemConfigs::first()->ia_detect_object_driver)
            ->exec($imageFile);
        dd($result);
    }
}
