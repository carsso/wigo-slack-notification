<?php
require __DIR__.'/vendor/autoload.php';
require_once(__DIR__.'/config.php');

if(isset($config)) {
    $slack = new Slack($config['webhookUrl']);
    $slack->setDefaultUsername($config['webhookUsername']);
    $slack->setDefaultIcon($config['webhookIconUrl']);
    $message = new SlackMessage($slack);
    if(isset($_POST['Notification'])) {
        $notification = json_decode($_POST['Notification'], true);
        if(isset($notification['Message'])) {
            $message->setText('['.$notification['NewProbe']['Value'].'] '.$notification['Message']."\n".$notification['NewProbe']['Message']."\n".'```'.json_encode($notification['NewProbe']['Detail'], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT).'```');
            $result = $message->send();
            if($result) {
                echo 'OK (message sent)';
            } else {
                echo 'KO (message not sent)';
            }
        } else {
            echo 'OK (no message)';
        }
    } elseif(isset($_GET['test'])) {
        $message->setText('This is a Wigo-to-Slack notification test message');
        $result = $message->send();
        if($result) {
            echo 'OK (test message sent)';
        } else {
            echo 'KO (test message not sent)';
        }
    } else {
        echo 'OK (no notification)';
    }
} else {
    echo 'KO (configuration missing)';
}
