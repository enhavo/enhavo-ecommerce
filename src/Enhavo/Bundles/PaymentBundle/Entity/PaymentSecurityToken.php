<?php

namespace Enhavo\Bundle\PaymentBundle\Entity;

use Payum\Core\Model\Token;

class PaymentSecurityToken extends Token
{
    private ?int $id;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
}
