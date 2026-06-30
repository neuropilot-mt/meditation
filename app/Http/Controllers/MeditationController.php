<?php

namespace App\Http\Controllers;

use App\Http\Resources\MeditationResource;
use App\Models\Meditation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MeditationController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Meditation::with('voices');

        if ($request->has('category')) {
            $query->where('category', $request->input('category'));
        }

        return MeditationResource::collection($query->get());
    }
}
