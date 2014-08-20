<?php

namespace Boxmeup\Test;

interface FixtureInterface
{
    /**
     * Get an array of records to insert as part of the test case bootstrap.
     *
     * @return array
     */
    public function getRecords();
}
