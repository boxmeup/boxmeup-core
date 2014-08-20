<?php

namespace Boxmeup\Value;

use Cjsaylor\Domain\ValueObject;
use Boxmeup\Exception\InvalidParameterException;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints\Email as EmailConstraint;

class Email extends ValueObject
{
    /**
     * Constructor.
     *
     * @param string $address
     * @throws Boxmeup\Exception\InvalidParameterException
     */
    public function __construct($address)
    {
        $violations = Validation::createValidator()->validateValue($address, new EmailConstraint());
        if ($violations->count()) {
            throw new InvalidParameterException($violations[0]->getMessage());
        }
        $this->data['value'] = $address;
    }

    /**
     * Email address.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->data['value'];
    }
}
