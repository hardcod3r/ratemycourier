<?php

namespace App\Http\Requests\Api\Rate;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
class GetUserRateByCourierRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'courier_id' => 'required|exists:couriers,id',
            'user_id' => 'required|exists:users,id'
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => Auth::id(),
            'courier_id' => $this->route('courier_id')
        ]);
    }
}
