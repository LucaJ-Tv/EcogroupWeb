<?php
session_start();
header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

  if (empty($_SESSION['user_id'])) {
    echo json_encode(array('error' => 'User not authenticated'));
    exit;
  }

  $userID = $_SESSION['user_id'];
  echo json_encode(array('userID' => $userID));
}