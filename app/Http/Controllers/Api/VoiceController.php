<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VoiceResource;
use App\Models\Voice;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class VoiceController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return VoiceResource::collection(
            Voice::orderBy('sort_order')->get()
        );
    }
}
