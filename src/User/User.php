<?php

namespace Boxmeup\User;

use \Cjsaylor\Domain\Entity;
use \Boxmeup\Schema\SchemaValidatable;
use \Boxmeup\Schema\DefaultEntitySchemaValidate;
use \Boxmeup\Value\Email;
use \Boxmeup\Value\Role;

class User extends Entity implements SchemaValidatable
{
    use DefaultEntitySchemaValidate {
        DefaultEntitySchemaValidate::verifyRequiredSchema as defaultVerifyRequiredSchema;
    }

    /**
     * A list of allowable fields to be updated.
     *
     * @var array
     */
    protected $updatableFields = ['email', 'password', 'modified'];

    /**
     * Initialization of container item entity.
     *
     * @param array $initialData
     * @return void
     * @throws Boxmeup\Exception\InvalidSchemaException
     */
    public function initialize(array $initialData = [])
    {
        if (!empty($initialData['email']) && is_string($initialData['email'])) {
            $initialData['email'] = new Email($initialData['email']);
        }
        if (!array_key_exists('is_active', $initialData)) {
            $initialData['is_active'] = true;
        }
        $initialData['role'] = new Role(isset($initialData['role']) ? $initialData['role'] : Role::TYPE_BASIC);
        parent::initialize($initialData);
        $this->verifyRequiredSchema();
    }

    /**
     * Setter callback to message email into email object.
     *
     * @param mixed $email
     */
    public function setEmail($email)
    {
        if (is_string($email)) {
            $email = new Email($email);
        }
        $this->data['email'] = $email;
    }

    /**
     * Verify schema.
     *
     * @param array $data
     * @return boolean
     */
    public function verifyRequiredSchema(array $data = [])
    {
        $data = $data ?: $this->toArray();

        return $this->defaultVerifyRequiredSchema($data) && !$data['email'] instanceof Email;
    }

    /**
     * Schema for containers items.
     *
     * @return array
     */
    public function getRequiredSchema()
    {
        return [
            'email'
        ];
    }

    /**
     * Get a list of fields allowed to be updated.
     *
     * @return array
     */
    public function getUpdatableFields()
    {
        return $this->updatableFields;
    }

    /**
     * String representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this['email'];
    }

    /**
     * Array representation of the user.
     *
     * @return array
     */
    public function toArray()
    {
        $out = parent::toArray();
        $out['email'] = (string) $out['email'];
        $out['role'] = (string) $out['role'];

        return $out;
    }
}
