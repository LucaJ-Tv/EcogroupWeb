<?php
// Verifica se la richiesta è di tipo OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Imposta gli header CORS appropriati
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');

    // Termina l'esecuzione dello script PHP
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     // Imposta gli header CORS appropriati per le richieste POST
     header('Access-Control-Allow-Origin: *');
     header('Content-Type: application/json');
 
     // Accedi direttamente ai dati inviati tramite Axios
     $nome = isset($_POST['NomeAzienda']) ? $_POST['NomeAzienda'] : '';
     $email = isset($_POST['email']) ? $_POST['email'] : '';
     // E così via per gli altri campi...
 
     // Ora puoi utilizzare $nome, $email, ecc. come desideri
 
     // Esempio di risposta
     $response = array(
         'nome' => $nome,
         'email' => $email,
         // Altri campi...
     );
 
     // Converti l'array in formato JSON e invialo come risposta
     echo json_encode($response);
}
