<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $url
 */
class FetchRequest extends FormRequest
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
            // A full scheme is not always present in TikTok share links (e.g., vm.tiktok.com/…).
            // We only need a non-empty string here; the actual URL is validated later by SplashComponent().
            "url" => ["required", "string", "min:5"]
        ];
    }
}
