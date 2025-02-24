<?php

namespace App\Http\Controllers\Drivers;

use function Codewithkyrian\Transformers\Pipelines\pipeline;
use App\Http\Controllers\Controller;
use Codewithkyrian\Transformers\Pipelines\Task;
use Codewithkyrian\Transformers\Transformers;
use Codewithkyrian\Transformers\Utils\ImageDriver;
use Codewithkyrian\Transformers\Utils\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Geometry\Factories\RectangleFactory;
use Intervention\Image\ImageManager;
use Intervention\Image\Typography\FontFactory;

/**
 * FaceDetection Driver For athemys
 * version: 1.0.0
 */

class FaceDetection extends Controller
{



    /**
     * Quantifies the number 
     * of recognizable items within an image.
     */
    public static function Quantity(string $path)
    {
        $result = AiModelControl::AiObjectDetection($path);
        return collect($result)->map(function ($mp) {
            return (object)$mp;
        });
    }

    /**
     * Identify the items in the image
     */
    public static function Identify(string $path)
    {
        return static::Quantity($path)->where('label', 'person');
    }

    /**
     * Apply visual markers to the image binary
     */
    public static function Apply(string $file)
    {
        $itens = static::Identify($file);
        
        $manager = new ImageManager(new Driver());
        $image = $manager->read($file);
        $name = array_reverse(explode('/', $file))[0];
        $hash = hash('sha256', file_get_contents($file));

        foreach ($itens->toArray() as $item) {
            $box = $item->box;

            $image->drawRectangle($box['xmax'], $box['ymin'], function (RectangleFactory $rectangle) {
                $rectangle->size(100, 100); // width & height of rectangle
                $rectangle->border('orange', 2); // border color & size of rectangle
            });

            $image->text($item->label, $box['xmin'], max($box['ymin'] - 5, 0), function (FontFactory $font) {
                $font->filename(public_path("fonts/orbitron.ttf"));
                $font->size(16);
                $font->color('fff');
                $font->stroke('ff5500', 2);
                $font->align('center');
                $font->valign('middle');
                $font->lineHeight(1.6);
                $font->angle(0);
                $font->wrap(250);
            });
        }

        $image->text("Arthemys - Face Detection Driver", 120, max(10, 0), function (FontFactory $font) {
            $font->filename(public_path("fonts/orbitron.ttf"));
            $font->size(12);
            $font->color('fff');
            $font->stroke('ff5500', 2);
            $font->align('center');
            $font->valign('middle');
            $font->lineHeight(1.6);
            $font->angle(0);
            $font->wrap(250);
        });

        $pathToImage = "app/driver/face-detection";
        $storageImagePath = storage_path($pathToImage);

        if (!is_dir($storageImagePath)) {
            mkdir($storageImagePath);
        }

        $image->save("{$storageImagePath}/{$hash}:{$name}");

        return (object)[
           'object_output' => (object)[
                'path_to_image' => $pathToImage,
                'storage_image_path' => $storageImagePath,
                'image_name' => "{$hash}:{$name}",
                'original_check_sun' => $hash
            ],
            'object_result' => (object)[
                'total_itens' => $itens->count(),
                'list_itens' => $itens->toArray()
            ]
        ];
    }
}
