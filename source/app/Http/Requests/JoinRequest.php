<?php declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\IntegerRule;
use App\Rules\Password;
use App\Rules\StrLower;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JoinRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|alpha',
            'nickname' => ['required', new StrLower],
            'password' => ['required', 'min:10', new Password],
            'phone' => ['required', new IntegerRule, 'unique:users'],
            'email' => 'required|email|unique:users',
            'gender' => ['nullable', Rule::in(User::MALE, User::FEMALE)]
        ];
    }
}
