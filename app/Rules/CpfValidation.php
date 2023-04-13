<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CpfValidation implements Rule
{
    /**
     * Alias
     *
     * @var string
     */
    protected $alias = 'cpf';

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $cpf
     * @return bool
     */
    public function passes($attribute, $cpf)
    {
        $cpf = preg_replace("/[^0-9]/", "", $cpf);

        if (strlen($cpf) != 11) {
            return false;
        }

        $digito1 = 0;
        $digito2 = 0;

        $ignore_list = [
            '00000000000',
            '01234567890',
            '11111111111',
            '22222222222',
            '33333333333',
            '44444444444',
            '55555555555',
            '66666666666',
            '77777777777',
            '88888888888',
            '99999999999'
        ];

        if (in_array($cpf, $ignore_list)) {
            return false;
        }

        /**
         * Calcula primeiro digito
         */
        for ($i = 0; $i < 9; $i++) {
            $digito1 += $cpf[$i] * (10 - $i);
        }

        $res = $digito1 % 11;
        $digito1 = ($res > 1) ? (11 - $res) : 0;

        /**
         * Calcula segundo digito
         */
        for ($i = 0; $i < 9; $i++) {
            $digito2 += $cpf[$i] * (11 - $i);
        }
        $res = ($digito2 + ($digito1 * 2)) % 11;
        $digito2 = ($res > 1) ? (11 - $res) : 0;

        return substr($cpf, -2) == "{$digito1}{$digito2}";
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O CPF é inválido';
    }
}
