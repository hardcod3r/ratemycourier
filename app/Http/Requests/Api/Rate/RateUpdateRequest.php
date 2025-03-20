<?php

namespace App\Http\Requests\Api\Rate;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Enums\RateType;
class RateUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'rate' => 'required|in:' . implode(',', RateType::getValues()),
            'id' => 'required|exists:rates,id',
            'user_id' => 'required|exists:users,id',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'rate' => $this->route('rate'),
            'id' => $this->route('id'),
            'user_id' => Auth::id()
        ]);
    }
}
