<?php
  include("../class/songs.php");

  $method = "GET";
  $Song = new Song;

   // Get the request URL
   $requestUrl = $_SERVER['REQUEST_URI'];
   // Parse the URL and extract the ID
   $urlParts = parse_url($requestUrl);
   $path = $urlParts['path'];
   // Extract the ID from the path
   $parts = explode('/', $path);
   $id = end($parts);

  $Song->getDetailSong($id);
?>