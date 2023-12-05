<?php
  include("../config/systemConfig.php");

  class Song {
    private $dbReference;
    private $db_table = "songs";
    private $dbConnection;
    private $result;

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
          $this->dbReference->sendResponse(200, '{"items":' . json_encode($resultSet).'}');
        }
      }
    }

    function getDetailSong ($id) {
      $this->dbReference = new systemConfig();
      $this->dbConnection = $this->dbReference->connectDB();

      if ($this->dbConnection === NULL) {
        echo "Connect failed";
        $this->dbReference->sendResponse(503, "{'error_message':" . $this->dbReference->getStatusCodeMessage(503) . "}");
      } else {
        // get the last created song
        $sqlSelect = "SELECT * FROM " .$this->db_table . " WHERE id = " . $id;
        $this->result = $this->dbConnection->query($sqlSelect);
        if ($this->result === false) {
          die("Something occur" . $this->dbConnection->error);
        }
        if ($this->result->num_rows > 0) {
          $resultSet = array();
          while($row = $this->result->fetch_assoc()) {
            $resultSet[] = $row;
          }
          $this->dbReference->sendResponse(200, '{"data":' . json_encode($resultSet).'}');
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
        $stmt  = $this->dbConnection->prepare("INSERT INTO " . $this->db_table . "(name, singer) VALUES (?, ?)");
        $stmt->bind_param('ss', $name, $singer);
        $this->result = $stmt->execute();
       
        if ($this->result) {
          $id = $this->dbConnection->insert_id;
          
          // get the last created song
          $sqlSelect = "SELECT * FROM " .$this->db_table . " WHERE id = " . $id;
          $createdSong = $this->dbConnection->query($sqlSelect);
          if ($createdSong === false) {
            die("Something occur" . $this->dbConnection->error);
          }
          if ($createdSong->num_rows > 0) {
            $resultSet = array();
            while($row = $createdSong->fetch_assoc()) {
              $resultSet[] = $row;
            }
            $this->dbReference->sendResponse(200, '{"data":' . json_encode($resultSet).'}', "POST");
          }
        } else {
          echo "Connect failed";
          $this->dbReference->sendResponse(503, "{'error_message':" . $this->dbReference->getStatusCodeMessage(503) . "}");
        }
      }
      $stmt->close();
    }

    function updateSong ($id, $name, $singer) {
      $this->dbReference = new systemConfig();
      $this->dbConnection = $this->dbReference->connectDB();

      if ($this->dbConnection === NULL) {
        echo "Connect failed";
        $this->dbReference->sendResponse(503, "{'error_message':" . $this->dbReference->getStatusCodeMessage(503) . "}");
      } else {
        $stmt = $this->dbConnection->prepare("UPDATE " . $this->db_table . " SET name = ?, singer = ? WHERE id = ?");
        $stmt->bind_param("ssi", $name, $singer, $id);
        $this->result = $stmt->execute();
        if ($this->result === false) {
          die("Something occur" . $this->dbConnection->error);
        } else {
          // get the last updated song
          $sqlSelect = "SELECT * FROM " .$this->db_table . " WHERE id = " . $id;
          $updatedSong = $this->dbConnection->query($sqlSelect);
          if ($updatedSong === false) {
            die("Something occur" . $this->dbConnection->error);
          }
          if ($updatedSong->num_rows > 0) {
            $resultSet = array();
            while($row = $updatedSong->fetch_assoc()) {
              $resultSet[] = $row;
            }
            $this->dbReference->sendResponse(200, '{"data":' . json_encode($resultSet).'}', "PUT");
          }
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
?>