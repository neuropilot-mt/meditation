<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGenerationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'client_id' => ['required', 'string', 'max:120'],
            'type' => ['required', 'in:image,audio'],
            'idempotency_key' => ['nullable', 'string', 'max:120'],
            'webhook_url' => ['nullable', 'url', 'max:500'],

            'input' => ['required', 'array'],
            'input.prompt' => ['required_if:type,image', 'string', 'max:2000'],
            'input.text' => ['required_if:type,audio', 'string', 'max:10000'],
            'input.voice_id' => ['nullable', 'string', 'max:120'],

            'options' => ['sometimes', 'array'],
            'options.provider' => ['nullable', 'string', 'max:40'],
            'options.size' => ['nullable', 'in:1024x1024,1024x1536,1536x1024'],
            'options.quality' => ['nullable', 'in:low,medium,high,standard,hd'],
            'options.format' => ['nullable', 'string', 'max:40'],
            'options.model' => ['nullable', 'string', 'max:80'],
        ];
    }
}
