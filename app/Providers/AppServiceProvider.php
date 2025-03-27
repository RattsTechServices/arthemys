<?php

namespace App\Providers;

use App\Http\Controllers\DriverControl;
use App\Models\ClientApplication;
use App\Models\ClientRegisterCollection;
use App\Models\SystemConfigs;
use App\Models\ThemeManager;
use Codewithkyrian\Transformers\Transformers;
use Codewithkyrian\Transformers\Utils\ImageDriver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Livewire\Volt\Volt;

class AppServiceProvider extends ServiceProvider
{
    private array $IaImageDrivers = [
        'gd' => ImageDriver::GD,
        'imagick' => ImageDriver::IMAGICK,
        'vips' => ImageDriver::VIPS
    ];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        
        if (Schema::hasTable('system_configs')) {
            $SysConfig = SystemConfigs::first();
            if (isset($SysConfig)) {
                if (in_array($SysConfig->image_controller, array_keys($this->IaImageDrivers))) {
                    Transformers::setup()
                        ->setImageDriver($this->IaImageDrivers[$SysConfig->image_controller])
                        ->setCacheDir($SysConfig->ia_models_directory)
                        ->apply();
                }
            }
        }

        view()->composer('*', function ($configs) {
            if (request()->slug) {
                $configs->with('theme', static::ThemeComponents());
                $Application = ClientApplication::where('slug_title', request()->slug)->first();
                if (isset($Application)) {
                    $appClientSession = session()->id() . '::' . $Application->id;
                    $getRegisterBySession = ClientRegisterCollection::where('session_id', $appClientSession)->first();
                    if (!isset($getRegisterBySession)) {
                        ClientRegisterCollection::create([
                            'client_application_id' => $Application->id,
                            'session_id' => $appClientSession,
                            'register_ip' => request()->ip(),
                            'register_ip_sha256' => hash('sha256', request()->ip())
                        ]);

                        $getRegisterBySession = ClientRegisterCollection::where('session_id', $appClientSession)->first();
                    }


                    $generalSettings = (object)[
                        ...$Application->toArray(),
                        ...$getRegisterBySession->toArray()
                    ];

                    $configs->with('system', $generalSettings);
                }
            }
        });
    }

    /**
     * Load info from Theme
     */

    public static function ThemeComponents()
    {
        $theme = ThemeManager::where('is_active', 1)->first();
        return $theme->info();
    }
}
