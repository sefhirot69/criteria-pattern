<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

final class Email extends StringValueObject
{
    protected function __construct(protected string $value)
    {
        parent::__construct($value);
        $this->ensureIsValidEmail();
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    private function ensureIsValidEmail(): void
    {
        if (filter_var($this->value(), FILTER_VALIDATE_EMAIL)) {
            return;
        }

        throw new \InvalidArgumentException('Email not is valid');
    }
}
