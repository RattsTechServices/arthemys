<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DriverControl extends Controller
{
    public string $defaultDriver = "App\\Http\\Controllers\\Drivers\\ObjectDetection";

    /**
     * List all avaliable drivers
     */
    public static function list(){
        return UtilsController::getControllersFromNamespace(app_path('Http/Controllers/Drivers'), 'App\Http\Controllers\Drivers');
    }

    /**
     * Use driver for a jo
     */
    public function use(string $driver) {
        $this->defaultDriver = $driver;
        return $this;
    }

    /**
     * Execute driver for a job
     */
    public function exec(...$params) {
        return $this->defaultDriver::Apply(...$params);
    }
}
