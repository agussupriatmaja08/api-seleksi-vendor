<?php

namespace App\Helpers;

class ServiceResponse
{
    public $success;
    public $message;
    public $data;
    public $status;

    /**
     * Konstruktor utama untuk response service.
     */
    public function __construct($success, $message, $data = null, $status)
    {
        $this->success = $success;
        $this->message = $message;
        $this->data = $data;
        $this->status = $status;
    }

    /**
     * Helper untuk membuat response sukses.
     */
    public static function success($data = null, $message = 'Success', $status = 200)
    {
        return new self(true, $message, $data, $status);
    }

    /**
     * Helper untuk membuat response error.
     */
    public static function error($message = 'Error', $status = 500, $data = null)
    {
        return new self(false, $message, $data, $status);
    }
}
