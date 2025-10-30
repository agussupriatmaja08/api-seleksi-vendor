<?php

namespace App\Helpers;

class ServiceResponse
{
    public $status;
    public $message;
    public $data;
    public $statusCode;

    /**
     * Konstruktor utama untuk response service.
     */
    public function __construct($status, $message, $data = null, $statusCode)
    {
        $this->status = $status;
        $this->message = $message;
        $this->data = $data;
        $this->statusCode = $statusCode;
    }

    /**
     * Helper untuk membuat response sukses.
     */
    public static function success($data = null, $message = 'Success', $statusCode = 200)
    {
        return new self($status = true, $message, $data, $statusCode);
    }

    /**
     * Helper untuk membuat response error.
     */
    public static function error($message = 'Error', $statusCode = 500, $data = null)
    {
        return new self($status = false, $message, $data, $statusCode);
    }

}
