<?php
  include("../class/songs.php");

  $Song = new Song;

  $$id = $_POST['$id'];
  $singer = $_POST['singer'];
  
  if (isset($id)) {
    $Song->deleteSong($id);
  }
?>