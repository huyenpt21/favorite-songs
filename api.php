<?php
  include("./systemConfig.php");

  class songResources {
    private $dbReference;
    private $db_table = "songs";
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
        $sql = 'SELECT * FROM songs';
        $this->result = $this->dbConnection->query($sql);
        if ($this->result === false) {
          die("Something occur" . $this->dbConnection->error);
        }
        if ($this->result->num_rows > 0) {
          $resultSet = array();
          while($row = $this->result->fetch_assoc()) {
            $resultSet[] = $row;
          }
          $this->dbReference->sendResponse(200, '{"items:":' . json_encode($resultSet).'}');
        }
      }
    }

    // get all songs
    function getSongResourcesWithName ($name) {
      $this->dbReference = new systemConfig();
      $this->dbConnection = $this->dbReference->connectDB();
      
      if ($this->dbConnection === NULL) {
        echo "Connect fail";
        $this->dbReference->sendResponse(503, "{'error_message':" . $this->dbReference->getStatusCodeMessage(503)."}");
      } else {
        $sql = "SELECT * FROM " . $this->db_table . " WHERE name LIKE '%" .$name . "%'";
        $this->result = $this->dbConnection->query($sql);
        if ($this->result === false) {
          die("Something occur" . $this->dbConnection->error);
        }
        if ($this->result->num_rows > 0) {
          $resultSet = array();
          while($row = $this->result->fetch_assoc()) {
            $resultSet[] = $row;
          }
          $this->dbReference->sendResponse(200, '{"items:":' . json_encode($resultSet).'}');
        }
      }
    }

    function createSong ($name = "", $singer = "") {
      $this->dbReference = new systemConfig();
      $this->dbConnection = $this->dbReference->connectDB();

      if ($this->dbConnection === NULL) {
        echo "Connect failed";
        $this->dbReference->sendResponse(503, "{'error_message':" . $this->dbReference->getStatusCodeMessage(503) . "}");
      } else {
        $sql = "INSERT INTO " . $this->db_table . " (name, singer) VALUES ('" .$name. "', '" . $singer . "')";
        $this->result = $this->dbConnection->query($sql); 
        if ($this->result === false) {
          die("Something occur" . $this->dbConnection->error);
        } else {
          $newRecordId = $this->dbConnection->insert_id;
          $this->dbReference->sendResponse(200, "New song created successfully - " . $newRecordId)
          ;
        }
      }
    }

    function updateSong ($id, $name, $singer) {
      $this->dbReference = new systemConfig();
      $this->dbConnection = $this->dbReference->connectDB();

      if ($this->dbConnection === NULL) {
        echo "Connect failed";
        $this->dbReference->sendResponse(503, "{'error_message':" . $this->dbReference->getStatusCodeMessage(503) . "}");
      } else {
        $sql = "UPDATE " . $this->db_table . " SET name = '" .$name. "', singer = '" . $singer . "' WHERE id = '" .$id ."'";
        $this->result = $this->dbConnection->query($sql); 
        if ($this->result === false) {
          die("Something occur" . $this->dbConnection->error);
        } else {
          $this->dbReference->sendResponse(200, "Song with id = " .$id. " updated successfully", 'POST');
        }
      }
    }

    function deleteSong ($id) {
      $this->dbReference = new systemConfig();
      $this->dbConnection = $this->dbReference->connectDB();

      if ($this->dbConnection === NULL) {
        echo "Connect failed";
        $this->dbReference->sendResponse(503, "{'error_message':" . $this->dbReference->getStatusCodeMessage(503) . "}");
      } else {
        $sql = "DELETE FROM " . $this->db_table . " WHERE id=" .$id;
        $this->result = $this->dbConnection->query($sql); 
        if ($this->result === false) {
          die("Something occur" . $this->dbConnection->error);
        } else {
          $this->dbReference->sendResponse(200, "Delete song with id = " .$id. " successfully", 'DELETE');
        }
      }
    }


  }

  // call api
  $songs = new songResources();
  // $songs->getAllSongResources();
  // $songs->createSong("Merry Christmas", "Ed Shreeran");
  // $songs->updateSong(12, "Update Merry Christmas", "Update Ed Shreeran");
  // $songs->deleteSong(12);
  $songs->getSongResourcesWithName("a");
  
?>