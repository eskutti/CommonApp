<?php
error_reporting(-1);
ini_set('display_errors', 'On');
require_once __DIR__ . '/push.php';
require_once __DIR__ . '/firebase.php';
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['api_key']))
        define('FIREBASE_API_KEY', $_GET['api_key']);
    else
        define('FIREBASE_API_KEY', 'AIzaSyDIxzI1vNxyBUxH1Pjn2ccF5WmUsrIfiXM');
    $firebase = new Firebase();
    $push = new Push();
    $payload = array();
    $payload['team'] = 'India';
    $payload['score'] = '5.6';
    $title = isset($_GET['title']) ? $_GET['title'] : '';
    $message = isset($_GET['message']) ? $_GET['message'] : '';
    $push_type = isset($_GET['push_type']) ? $_GET['push_type'] : '';
    $include_image = isset($_GET['include_image']) ? TRUE : FALSE;
    if (isset($_GET['firekey'])) {
        define('FIREBASE_API_KEY', $_GET['firekey']);
    }
    $push->setTitle($title);
    $push->setMessage($message);
    if ($include_image) {
        if (isset($_GET['img_url']))
            $push->setImage($_GET['img_url']);
        else
            $push->setImage('http://api.androidhive.info/images/minion.jpg');
    } else {
        $push->setImage('');
    }
    $regId = isset($_GET['regId']) ? $_GET['regId'] : '';
} else {

    if (isset($_POST['api_key']))
        define('FIREBASE_API_KEY', $_GET['api_key']);
    else
        define('FIREBASE_API_KEY', 'AIzaSyDIxzI1vNxyBUxH1Pjn2ccF5WmUsrIfiXM');

    $firebase = new Firebase();
    $push = new Push();
    $payload = array();
    $payload['team'] = 'India';
    $payload['score'] = '5.6';
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $message = isset($_POST['message']) ? $_POST['message'] : '';
    $push_type = isset($_POST['push_type']) ? $_POST['push_type'] : '';
    $include_image = isset($_POST['include_image']) ? TRUE : FALSE;
    if (isset($_POST['firekey'])) {
        define('FIREBASE_API_KEY', $_POST['firekey']);
    }
    $push->setTitle($title);
    $push->setMessage($message);
    if ($include_image) {
        if (isset($_POST['img_url']))
            $push->setImage($_POST['img_url']);
        else
            $push->setImage('http://api.androidhive.info/images/minion.jpg');
    } else {
        $push->setImage('');
    }
    $regId = isset($_POST['regId']) ? $_POST['regId'] : '';
}
$push->setIsBackground(FALSE);
$push->setPayload($payload);
$json = '';
$response = '';
if ($push_type == 'topic') {
    $json = $push->getPush();
    $response = $firebase->sendToTopic('global', $json);
} else if ($push_type == 'individual') {
    $json = $push->getPush();
    $response = $firebase->send($regId, $json);
}
echo json_encode($response)
?>