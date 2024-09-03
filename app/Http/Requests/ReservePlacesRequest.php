<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ReservePlacesRequest extends FormRequest
{
    public const PLACES_IDS_KEY = 'places';
    public const USER_NAME_KEY = 'name';
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function getPlacesIds(): array
    {
        return $this->validated(self::PLACES_IDS_KEY);
    }

    public function getUserName(): string
    {
        return $this->validated(self::USER_NAME_KEY);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            self::PLACES_IDS_KEY        => 'required|array',
            self::PLACES_IDS_KEY . '.*' => 'required|integer',
            self::USER_NAME_KEY         => 'required|string',
        ];
    }
}
