<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Holon
{
	protected $ci;

	public function __construct()
	{
		$this->ci =& get_instance();
	}

	public function get_row($sql_expr, $params = FALSE)
	{
		$query  = $this->ci->db->query($sql_expr, $params);
		$fields = $this->_map_field_data($query->field_data());
		$row    = $query->row_array();

		if ($query->num_rows() > 0)
		{
			$this->_map_row_data($fields, $row); return $row;
		}

		return NULL;
	}

	public function get_rows($sql_expr, $params = FALSE)
	{
		$query  = $this->ci->db->query($sql_expr, $params);
		$fields = $this->_map_field_data($query->field_data());
		$rows   = $query->result_array();

		for ($i = 0; $i < count($rows); $i++)
		{
			$this->_map_row_data($fields, $rows[$i]);
		}

		return $rows;
	}

	private function _map_field_data($data)
	{
		$fields = [];

		foreach ($data as $item)
		{
			$fields[$item->name] = $item->type;
		}

		return $fields;
	}

	private function _map_row_data($fields, &$row)
	{
		foreach ($row as $key => $value)
		{
			$row[$key] = $this->_set_type($value, $fields[$key]);
		}
	}

	private function _set_type($value, $type)
	{
		switch ($type) {
			case 'timestamp':
			case 'datetime':
			case 'date':
				return new DateTime($value);
			case 'mediumint':
			case 'smallint':
			case 'tinyint':
			case 'bigint':
			case 'year':
			case 'int':
				return (integer) $value;
			case 'decimal':
			case 'double':
			case 'float':
				return (float) $value;
			case 'bit':
				return (boolean) $value;
			default:
				return $value;
		}
	}
}
