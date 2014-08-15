<?php

namespace Boxmeup\Test;

class DatabaseTestCase extends \PHPUnit_Extensions_Database_TestCase
{
    protected $fixture = [];

    public function setUp()
    {
        getConnection()->query("set foreign_key_checks=0");
        parent::setUp();
        getConnection()->query("set foreign_key_checks=1");

    }

    public function getConnection()
    {
        static $conn;

        if (!$conn) {
            $conn = $this->createDefaultDBConnection(getConnection()->getWrappedConnection(), 'boxmeup_test');
        }

        return $conn;
    }

    protected function getDataSet()
    {
        return new ArrayDataSet($this->fixture);
    }
}
