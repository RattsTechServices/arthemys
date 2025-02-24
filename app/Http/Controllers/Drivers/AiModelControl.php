<?php

namespace App\Http\Controllers\Drivers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use function Codewithkyrian\Transformers\Pipelines\pipeline;

class AiModelControl extends Controller
{
    /**
     * Detect obects default model
     */
    public static string $objectDetectionModel = "Xenova/detr-resnet-50";
    
    /**
     * Detect objects in a image file
     */
    public static function AiObjectDetection(string $objectivePath) {
        $classifier = pipeline('object-detection', static::$objectDetectionModel);
        return $classifier($objectivePath);
    }
}
