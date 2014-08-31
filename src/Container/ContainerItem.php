<?php

namespace Boxmeup\Container;

use Cjsaylor\Domain\Entity;
use Cjsaylor\Domain\Behavior\PropertyLimitable;
use Cjsaylor\Domain\Behavior\PropertyLimitTrait;
use Boxmeup\Schema\SchemaValidatable;
use Boxmeup\Schema\DefaultEntitySchemaValidate;

class ContainerItem extends Entity implements SchemaValidatable, PropertyLimitable
{
    use DefaultEntitySchemaValidate, PropertyLimitTrait;

    /**
     * Initialization of container item entity.
     *
     * @param array $initialData
     * @return void
     * @throws Boxmeup\Exception\InvalidSchemaException
     */
    public function initialize(array $initialData = [])
    {
        if (!array_key_exists('quantity', $initialData)) {
            $initialData['quantity'] = 1;
        }
        $initialData['quantity'] = abs($initialData['quantity']);
        parent::initialize($initialData);
        $this->verifyRequiredSchema();
    }

    /**
     * Schema for containers items.
     *
     * @return string[]
     */
    public function getRequiredSchema()
    {
        return [
            'body', 'quantity'
        ];
    }

    /**
     * Allowable attributes for this entity.
     *
     * @return array
     */
    public function concreteAttributes()
    {
        return [
            'id',
            'container',
            'body',
            'quantity',
            'created',
            'modified'
        ];
    }
}
