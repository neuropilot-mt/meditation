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
        $query = Meditation::with('category');

        if ($request->has('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        return MeditationResource::collection($query->get());
    }
}
