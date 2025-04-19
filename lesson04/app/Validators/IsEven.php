<?php

namespace App\Validators;

use App\Interfaces\ValidatorInterface;
class IsEven implements ValidatorInterface
{
    public function validate($value): bool
    {
        /**
         * Atenção para:
         * A verificação de inteiro é necessária porque números decimais como 2.5
         * não devem ser considerados pares, mesmo que sua parte inteira seja par.
         * A comparação como string garante que valores como "2.0" também sejam
         * rejeitados, mantendo apenas inteiros puros.
         *
         * @param mixed $value O valor a ser validado
         * @return bool Retorna true se o valor for um número inteiro par, false caso contrário
         */
        return is_numeric($value) && (string) (int) $value === (string) $value && $value % 2 === 0;
    }
}
