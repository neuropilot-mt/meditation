<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIntakeRequest extends FormRequest
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
            'idempotency_key' => ['nullable', 'string', 'max:120'],
            'questionnaire' => ['required', 'array'],
            'questionnaire.age' => ['required', 'integer', 'between:8,100'],
            'questionnaire.emotional_state' => ['required', 'string', 'max:120'],
            'questionnaire.preferences' => ['nullable', 'string', 'max:1000'],
            'questionnaire.language' => ['nullable', 'string', 'in:en,ru'],
            'questionnaire.target_duration_minutes' => ['nullable', 'integer', 'between:3,30'],

            'providers' => ['sometimes', 'array'],
            'providers.image' => ['nullable', 'string', 'max:40'],
            'providers.audio' => ['nullable', 'string', 'max:40'],

            'image_options' => ['sometimes', 'array'],
            'image_options.size' => ['nullable', 'in:1024x1024,1024x1536,1536x1024'],
            'image_options.quality' => ['nullable', 'in:low,medium,high,standard,hd'],
            'image_options.format' => ['nullable', 'in:png,webp,jpg'],

            'audio_options' => ['sometimes', 'array'],
            'audio_options.voice_id' => ['nullable', 'string', 'max:120'],
            'audio_options.format' => ['nullable', 'string', 'max:40'],
            'audio_options.model' => ['nullable', 'string', 'max:80'],
        ];
    }
}
