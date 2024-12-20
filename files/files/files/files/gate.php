<?php

define('BOT_TOKEN', '7381151943:AAFCsHagfTxDnuVb7mb-Th7NcX0N9jsmRaI'); 
define('CHAT_ID', '2220308517'); 

$uploadPath = __DIR__ . '/logs/';

if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $fileName = $_FILES['file']['name'];
    $fileSize = $_FILES['file']['size'];
    $fileTmp = $_FILES['file']['tmp_name'];
    $fileCaption = $_POST['filedescription'] ?? '';
    $fileCaption = trim($fileCaption);

    if ($fileSize <= 50 * 1024 * 1024) {
        $telegramApiUrl = 'https://api.telegram.org/bot' . BOT_TOKEN . '/sendDocument';

        $fileContents = file_get_contents($fileTmp);
        $fileData = [
            'chat_id' => CHAT_ID,
            'document' => new CURLFile($fileTmp, '', $fileName),
            'caption' => $fileCaption
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $telegramApiUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fileData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $telegramResponse = curl_exec($ch);
        curl_close($ch);
        echo 'File has been successfully uploaded to Telegram.';
    } else {
        $uploadFilePath = $uploadPath . $fileName;
        move_uploaded_file($fileTmp, $uploadFilePath);

        $fileUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/logs/' . $fileName;
        $message = "Download URL: " . $fileUrl . "\n";
        $message .= "Info: " . $fileCaption;

        $telegramApiUrl = 'https://api.telegram.org/bot' . BOT_TOKEN . '/sendMessage';
        $postData = [
            'chat_id' => CHAT_ID,
            'text' => $message
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $telegramApiUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $telegramResponse = curl_exec($ch);
        curl_close($ch);


        echo 'File has been saved on the server. Telegram link has been sent.';
    }
} else {
    echo 'Error uploading the file.';
}
?>
