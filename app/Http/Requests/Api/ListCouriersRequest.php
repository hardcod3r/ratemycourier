<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ListCouriersRequest extends FormRequest
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
            'name' => 'string',
            'min_likes' => 'integer',
            'min_dislikes' => 'integer',
            'min_views' => 'integer',
            'created_at' => 'date',
            'order' => 'in:asc,desc',
            'order_by' => 'in:name,likes_count,dislikes_count,views_count,created_at',
            'page' => 'integer',
            'per_page' => 'integer',
        ];
    }
}
