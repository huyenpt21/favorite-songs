<?php
  include("../class/songs.php");

  $Song = new Song;

  // Get the request URL
  $requestUrl = $_SERVER['REQUEST_URI'];
  // Parse the URL and extract the ID
  $urlParts = parse_url($requestUrl);
  $path = $urlParts['path'];
  // Extract the ID from the path
  $parts = explode('/', $path);
  $id = end($parts);

  // Access the data fields
  $name = $_POST['name'];
  $singer = $_POST['singer'];
  
  if (isset($id) && isset($name) && isset($singer)) {
    $Song->updateSong($id, $name, $singer);
  }
?>