<?php

use notifier\Config;
use notifier\Notifier;

include __DIR__ . "/vendor/autoload.php";

$config = new Config("http://185.53.141.102:8080", "dsafdasfasdf1234");

$notifier = new Notifier($config);
die(var_dump(
    // $notifier->notification_push('post_12', ["message" => 'another update']),
    // $notifier->subscribe("post_12", 12),
    // $notifier->user_inbox(12)
    // $notifier->group_mute('post_12', 12)
    // $notifier->group_unmute('post_12', 12)
    // $notifier->group_scroll("user_12", 12, 7),
    // $notifier->group_scroll("post_12", 12, 10),
    // $notifier->user_inbox_unread(12)
    $notifier->group_inbox("user_12")
));
