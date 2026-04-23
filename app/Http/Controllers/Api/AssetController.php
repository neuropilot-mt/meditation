<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AssetController extends Controller
{
    public function show(string $assetId): JsonResponse
    {
        $asset = Asset::query()
            ->where('public_id', $assetId)
            ->firstOrFail();

        return response()->json([
            'data' => [
                'asset_id' => $asset->public_id,
                'type' => $asset->type,
                'provider' => $asset->provider,
                'mime_type' => $asset->mime_type,
                'size_bytes' => $asset->size_bytes,
                'download_url' => route('assets.download', ['assetId' => $asset->public_id]),
                'path' => $asset->path,
                'metadata' => $asset->metadata,
            ],
        ]);
    }

    public function download(string $assetId): StreamedResponse
    {
        $asset = Asset::query()
            ->where('public_id', $assetId)
            ->firstOrFail();

        $filename = "{$asset->public_id}.{$this->extensionFromMime($asset->mime_type)}";

        return Storage::disk($asset->disk)->download($asset->path, $filename);
    }

    private function extensionFromMime(?string $mimeType): string
    {
        return match ($mimeType) {
            'audio/mpeg' => 'mp3',
            'image/png' => 'png',
            default => 'bin',
        };
    }
}
