<?php

namespace Boxmeup\Test\Value;

use Boxmeup\Value\Email;

class EmailTest extends \PHPUnit_Framework_TestCase
{
    public function testEmail()
    {
        $email = new Email('test@test.com');
        $this->assertEquals('test@test.com', (string) $email);
    }

    /**
	 * @expectedException Boxmeup\Exception\InvalidParameterException
	 */
    public function testInvalidEmail()
    {
        $email = new Email('invalid');
    }
}
