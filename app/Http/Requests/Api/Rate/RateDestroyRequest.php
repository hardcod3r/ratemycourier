<?php

namespace App\Http\Requests\Api\Rate;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
class RateDestroyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:rates,id',
            'user_id' => [
                'required',
                'string',
                 Rule::exists('rates', 'user_id')->where(function (Builder $query) {
                    $query->where('id', $this->route('id'));
                }),
            ]
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'id' => $this->route('id'),
            'user_id' => Auth::id(),
        ]);
    }
}
