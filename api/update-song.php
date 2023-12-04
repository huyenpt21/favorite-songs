<?php
  include("../class/songs.php");

  $Song = new Song;

  $$id = $_POST['$id'];
  $name = $_POST['name'];
  $singer = $_POST['singer'];
  
  if (isset($id) && isset($name) && isset($singer)) {
    $Song->updateSong($id, $name, $singer);
  }
?>