<?php

namespace Boxmeup\Schema;

use \Boxmeup\Schema\SchemaValidatable;
use \Boxmeup\Exception\InvalidSchemaException;
use \Boxmeup\Exception\InternalException;

trait DefaultEntitySchemaValidate
{
    /**
     * Verify required schema.
     *
     * @param array $data If not set, uses the data from the entity.
     * @return boolean
     */
    public function verifyRequiredSchema(array $data = [])
    {
        if (!$this instanceof SchemaValidatable) {
            throw new InternalException('Must implement SchemaValidatable interface.');
        }
        $diff = array_intersect(array_keys($data ?: $this->toArray()), $this->getRequiredSchema());

        return empty($diff);
    }
}
