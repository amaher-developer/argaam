<?php

namespace App\Http;

class Flash
{

    private function create($title, $message, $type, $key = 'sweet_flash_message')
    {
        return session()->flash($key, [
            'title' => $title,
            'message' => $message,
            'type' => $type
        ]);
    }

    public function info($title, $message)
    {
        return $this->create($title, $message, 'info');
    }

    public function success($title, $message)
    {
        return $this->create($title, $message, 'success');
    }

    public function error($title, $message)
    {
        return $this->create($title, $message, 'error');
    }

    public function overlay($title, $message, $type = 'info')
    {
        return $this->create($title, $message, $type, 'sweet_flash_message_overlay');
    }


}