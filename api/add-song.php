<?php
  include("../class/songs.php");

  $Song = new Song;

  $name = $_POST['name'];
  $singer = $_POST['singer'];
  
  if (isset($name) && isset($singer)) {
    $Song->createSong($name, $singer);
  }
?>