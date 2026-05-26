<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MeditationResource;
use App\Models\Meditation;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class MeditationController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return MeditationResource::collection(
            Meditation::orderBy('sort_order')->get()
        );
    }

    public function show(string $id): JsonResource
    {
        $meditation = Meditation::findOrFail($id);

        return new MeditationResource($meditation);
    }
}
