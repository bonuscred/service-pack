<?php

namespace FakeData\Provider\pt_BR;

class Company extends \FakeData\Provider\Company
{
    protected static $formats = [
        '{{lastName}} {{companySuffix}}',
        '{{lastName}}-{{lastName}}',
        '{{lastName}} e {{lastName}}',
        '{{lastName}} e {{lastName}} {{companySuffix}}',
        '{{lastName}} Comercial Ltda.',
    ];

    protected static $companySuffix = ['e Filhos', 'e Associados', 'Ltda.', 'S.A.'];

    /**
     * A random CNPJ number.
     *
     * @see http://en.wikipedia.org/wiki/CNPJ
     *
     * @param bool $formatted If the number should have dots/slashes/dashes or not.
     *
     * @return string
     */
    public function cnpj($formatted = true)
    {
        $n = static::numerify('########0001');
        $n .= \FakeData\Calculator\Ssn::check_digit($n);
        $n .= \FakeData\Calculator\Ssn::check_digit($n);

        return $formatted ? vsprintf('%d%d.%d%d%d.%d%d%d/%d%d%d%d-%d%d', str_split($n)) : $n;
    }
}
