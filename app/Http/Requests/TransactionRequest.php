<?php

namespace App\Http\Requests;

use App\Rules\hasBalance;
use Illuminate\Foundation\Http\FormRequest;
use App\Services\Contracts\UserServiceContract;

class TransactionRequest extends FormRequest
{

    private $userService;

    public function __construct()
    {
        $this->userService = app(UserServiceContract::class);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->userService->canPay($this->input('payer',0));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'payer' => 'bail|required|int|exists:users,id',
            'payee' => 'bail|required|int|exists:users,id',
            'value' => [
                'bail',
                'required',
                'numeric',
                'min:0.01',
                new hasBalance($this->input('payer'))
            ]
        ];
    }
}
