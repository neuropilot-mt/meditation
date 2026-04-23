<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIntakeRequest;
use App\Http\Resources\IntakeSubmissionResource;
use App\Models\IntakeSubmission;
use App\Services\IntakeGenerationService;
use Illuminate\Http\JsonResponse;

class IntakeController extends Controller
{
    public function store(StoreIntakeRequest $request, IntakeGenerationService $service): JsonResponse
    {
        $result = $service->createFromQuestionnaire($request->validated());

        $intake = $result['intake']->fresh(['generationRequests.resultAsset']);

        return response()->json([
            'data' => new IntakeSubmissionResource($intake),
            'meta' => [
                'poll_after_ms' => 2000,
            ],
        ], 202);
    }

    public function show(string $intakeId): JsonResponse
    {
        $intake = IntakeSubmission::query()
            ->where('public_id', $intakeId)
            ->with('generationRequests.resultAsset')
            ->firstOrFail();

        return response()->json([
            'data' => new IntakeSubmissionResource($intake),
        ]);
    }
}
