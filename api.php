<?php
  include("./systemConfig.php");

  class songResources {
    private $dbReference;
    var $dbConnection;
    var $result;

    // get all songs
    function getAllSongResources () {
      $this->dbReference = new systemConfig();
      $this->dbConnection = $this->dbReference->connectDB();
      
      if ($this->dbConnection === NULL) {
        echo "Connect fail";
        $this->dbReference->sendResponse(503, "{'error_message':" . $this->dbReference->getStatusCodeMessage(503)."}");
      } else {
        // echo "Connect successfully";
        // echo "</br>";
        $sql = 'SELECT * FROM favorite_songs.songs';
        // echo var_dump(mysqli_error($this->dbConnection));
        // echo "</br>";
        $this->result = $this->dbConnection->query($sql);
        if ($this->result == false) {
          die("Something occur");
        }
        if ($this->result->num_rows > 0) {
          $resultSet = array();
          while($row = $this->result->fetch_assoc()) {
            $resultSet[] = $row;
          }

          // echo var_dump($resultSet);
          $this->dbReference->sendResponse(200, '{"items:":' . json_encode($resultSet).'}');
        }
      }
    }
  }

  // call api
  $songs = new songResources();
  $songs->getAllSongResources();
?>