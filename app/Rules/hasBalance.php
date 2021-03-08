<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Services\Contracts\UserServiceContract;

class hasBalance implements Rule
{
    /**
     * @var UserServiceContract
     */
    private $userService;

    /**
     * @var int
     */
    private $payer;
    
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(int $payer)
    {
        $this->payer = $payer;
        $this->userService = app(UserServiceContract::class);
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $balance = $this->userService->balance($this->payer);
        return $balance >= $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'User does not have enough balance.';
    }
}
