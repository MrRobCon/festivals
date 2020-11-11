<?php
class Festival {
  public $id;
  public $title;
  public $description;
  public $location;
  public $start_date;
  public $end_date;
  public $contact_name;
  public $contact_email;
  public $contact_phone;

  public function __construct() {
    $this->id = null;
  }

  public function save() {
    throw new Exception("Not yet implemented");
  }

  public function delete() {
    throw new Exception("Not yet implemented");
  }

  public static function findAll() {
    $festivals = array();

    try {
      $db = new DB();
      $db->open();
      $conn = $db->get_connection();

      $select_sql = "SELECT * FROM festivals";
      $select_stmt = $conn->prepare($select_sql);
      $select_status = $select_stmt->execute();

      if (!$select_status) {
        $error_info = $select_stmt->errorInfo();
        $message = "SQLSTATE error code = ".$error_info[0]."; error message = ".$error_info[2];
        throw new Exception("Database error executing database query: " . $message);
      }

      if ($select_stmt->rowCount() !== 0) {
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
        while ($row !== FALSE) {
          $festival = new Festival();
          $festival->id = $row['id'];
          $festival->title = $row['title'];
          $festival->description = $row['description'];
          $festival->location = $row['location'];
          $festival->start_date = $row['start_date'];
          $festival->end_date = $row['end_date'];
          $festival->contact_name = $row['contact_name'];
          $festival->contact_email = $row['contact_email'];
          $festival->contact_phone = $row['contact_phone'];
          $festivals[] = $festival;

          $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
        }
      }
    }
    finally {
      if ($db !== null && $db->is_open()) {
        $db->close();
      }
    }

    return $festivals;
  }

  public static function findById($id) {
    throw new Exception("Not yet implemented");
  }
}
?>
