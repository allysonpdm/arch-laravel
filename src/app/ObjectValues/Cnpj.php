<?php

namespace ArchCrudLaravel\App\ObjectValues;

use ArchCrudLaravel\App\Rules\CnpjValidationRule;
use ArchCrudLaravel\App\ObjectValues\Contracts\{
    Maskable,
    ObjectValue,
    Sanitizable
};
use ArchCrudLaravel\App\ObjectValues\Traits\{
    Masked,
    Sanitized
};
use InvalidArgumentException;

class Cnpj extends ObjectValue implements Maskable, Sanitizable
{
    use Masked, Sanitized;

    public function __construct(protected mixed $value)
    {
        parent::__construct($value);
        $this->setMask('##.###.###/####-##');
        $this->setRegex('[^0-9]');
        $this->value = $this->sanitized();
    }

    protected function validate(mixed $value): void
    {
        $rule = new CnpjValidationRule;

        if (!$rule->passes('', $value)) {
            throw new InvalidArgumentException('CNPJ inválido.');
        }
    }

    public function __toString()
    {
        return str_pad($this->value, 14, '0', STR_PAD_LEFT);
    }

}
