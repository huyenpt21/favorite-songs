<?php
  include("../class/songs.php");

  $method = "GET";
  $Song = new Song;
  $Song->getAllSongResources();
?>