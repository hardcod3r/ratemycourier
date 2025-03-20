<?php

namespace App\Http\Requests\Api\Rate;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\RateType;
use Illuminate\Support\Facades\Auth;

class RateStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'courier_id' => 'required|exists:couriers,id',
            'rate' => 'required|in:' . implode(',', RateType::getValues()),
            'user_id' => 'required|exists:users,id'
        ];
    }

    //merge the request with the user_id
    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => Auth::id()
        ]);
    }
}
