<?php

namespace Boxmeup\Test;

class ArrayDataSet extends \PHPUnit_Extensions_Database_DataSet_AbstractDataSet
{
	protected $tables = [];

	public function __construct(array $data) {
		foreach ($data as $table => $rows) {
			$meta = new \PHPUnit_Extensions_Database_DataSet_DefaultTableMetaData($table, array_keys($rows[0]));
			$entry = new \PHPUnit_Extensions_Database_DataSet_DefaultTable($meta);

			foreach ($rows as $row) {
				$entry->addRow($row);
			}

			$this->tables[$table] = $entry;
		}
	}

	protected function createIterator($reverse = false) {
		return new \PHPUnit_Extensions_Database_DataSet_DefaultTableIterator($this->tables, $reverse);
	}

}
