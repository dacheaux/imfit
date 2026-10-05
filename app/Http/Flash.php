<?php

namespace App\Http;

class Flash {

    /**
     * Create a default flash message.
     *
     * @param $title
     * @param $message
     * @param $type
     * @param string $key
     */
    public function create($title, $message, $type, $key='flash_message')
    {
        session()->flash($key, [
            'title' => $title,
            'message' => $message,
            'type'  => $type
        ]);
    }

    /**
     * Create a info flash message.
     *
     * @param $title
     * @param $message
     */
    public function info($title, $message)
    {
        return $this->create($title, $message, 'info');
    }

    /**
     * Create a success flash message.
     *
     * @param $title
     * @param $message
     */
    public function success($title, $message)
    {
        return $this->create($title, $message, 'success');
    }

    /**
     * Create a error flash message.
     *
     * @param $title
     * @param $message
     */
    public function error($title, $message)
    {
        return $this->create($title, $message, 'error');
    }

    /**
     * Create a overlay flash message.
     *
     * @param $title
     * @param $message
     */
    public function overlay($title, $message, $type='success')
    {
        return $this->create($title, $message, $type, 'flash_message_overlay');
    }

}