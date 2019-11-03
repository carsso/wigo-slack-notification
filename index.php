<?php
require __DIR__.'/vendor/autoload.php';
require_once(__DIR__.'/config.php');

if(isset($config)) {
    if(isset($_POST['Notification'])) {
        $slack = new Slack($config['webhookUrl']);
        $slack->setDefaultUsername($config['webhookUsername']);
        $slack->setDefaultIcon($config['webhookIconUrl']);
        $message = new SlackMessage($slack);
        $notification = json_decode($_POST['Notification'], true);
        if(isset($notification['Message'])) {
            $message->setText($notification['Message']);
            $message->send();
        }
    }
}
