# Holon

A CodeIgniter library to fix data types from MySQL query results.

## Install

Add this project to your ```application/libraries``` directory.

## Example

```php
class User_model extends CI_Model
{
  public function __construct()
  {
    $this->load->database();
    $this->load->library('holon-master/holon');
  }
  
  public function get_user($id)
  {
    return $this->holon->get_row('SELECT * FROM user WHERE id = ?', [ $id ]);
  }
  
  public function get_users()
  {
    return $this->holon->get_rows('SELECT * FROM user');
  }
}
```

## Output

CodeIgniter ```row_array()```

```
array(5) {
  ["string"]   => string(10) "John Smith"
  ["integer"]  => string(2)  "10"
  ["decimal"]  => string(5)  "10.75"
  ["bit"]      => string(1)  "1"
  ["datetime"] => string(25) "2018-09-01T18:32:49+00:00"
}
```

Holon ```get_row()```

```
array(5) {
  ["string"]   => string(10) "John Smith"
  ["integer"]  => int(10)
  ["decimal"]  => float(10.75)
  ["bit"]      => bool(true)
  ["datetime"] => object(DateTime)
}
```

## License

See LICENSE file for more details.
