<?php

declare(strict_types=1);

namespace Domain\Model\User\Entity\User;

use Webmozart\Assert\Assert;

final class Password
{
    private string $value;

    /**
     * Password constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        Assert::notEmpty($value, 'User password required');
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqual(Password $password): bool
    {
        return $this->value === $password->getValue();
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
