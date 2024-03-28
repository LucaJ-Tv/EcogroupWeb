<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  header('Access-Control-Allow-Origin: *');

  if (!isset($_SESSION['user_id'])) {
    echo json_encode(array('error' => 'User not authenticated'));
    exit;
  }

  $userID = $_SESSION['user_id'];
  echo json_encode(array('userID' => $userID));
}