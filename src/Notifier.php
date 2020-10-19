<?php

namespace notifier;

class Notifier
{
    private $config;

    function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function subscribe($groupName, $userId)
    {
        return $this->request_post("group/subscribe", [
            'groupName' => $groupName,
            'userId' => $userId
        ]);
    }

    public function user_inbox($userId)
    {
        return $this->request_get('notification/user/' . $userId . '/inbox');
    }

    public function user_inbox_unread($userId)
    {
        return $this->request_get('notification/user/' . $userId . '/inbox/unread');
    }

    public function notification_push($groupName, $data)
    {
        return $this->request_post('notification/new', [
            "groupName" => $groupName,
            "data" => $data
        ]);
    }

    public function group_scroll($groupName, $userId, $scrollId)
    {
        return $this->request_post('group/scroll', [
            "userId" => $userId,
            "groupName" => $groupName,
            "scrollId" => $scrollId
        ]);
    }

    public function group_inbox($groupName)
    {
        $groupId = $this->request_get('group/' . $groupName)->id ?? false;
        if (!$groupId) {
            return false;
        }
        return $this->request_get('notification/group/' . $groupId . '/inbox');
    }

    public function group_mute($groupName, $userId)
    {
        return $this->request_post('group/mute', [
            "userId" => $userId,
            "groupName" => $groupName
        ]);
    }

    public function group_unmute($groupName, $userId)
    {
        return $this->request_post('/group/unmute', [
            "userId" => $userId,
            "groupName" => $groupName
        ]);
    }

    public function test()
    {
        return $this->request_get("group/2", []);
    }

    private function request_post($path, $data = [])
    {
        if ($path[0] == "/") {
            $path = substr($path, 1);
        }
        $data['key'] = $this->config->vendorKey;
        $url = $this->config->endpoint . $path;
        $ch = curl_init($url);
        $payload = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result);
    }

    private function request_get($path, $data = [])
    {
        if ($path[0] == "/") {
            $path = substr($path, 1);
        }
        $result = [];
        $data['key'] = $this->config->vendorKey;
        foreach ($data as $key => $value) {
            $result[] = $key . "=" . $value;
        }
        $result = implode("&", $result);
        $url =  $this->config->endpoint . $path . "?" . $result;
        return json_decode(file_get_contents($url));
    }
}
