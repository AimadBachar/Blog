<?php

namespace App\Traits;

trait Notification
{
    public function setErrorNotification(String $key, String $message): void
    {
        $_SESSION['errors'][$key] = $message;
    }

    public function setSuccesNotification(String $key, String $message): void
    {
        $_SESSION['success'][$key] = $message;
    }

    private function getErrorNotification(String $key): String
    {
        $message = $_SESSION['errors'][$key];
        unset($_SESSION['errors'][$key]);
        return $message;
    }

    private function getSuccesNotification(String $key): String
    {
        $message = $_SESSION['success'][$key];
        unset($_SESSION['success'][$key]);
        return $message;
    }

    public function checkErrorsNotification(String $key): bool
    {
        if(!empty($_SESSION['errors'][$key])) {
            return true;
        }
        return false;
    }

    public function checkSuccessNotification(String $key): bool
    {
        if(!empty($_SESSION['success'][$key])) {
            return true;
        }
        return false;
    }

    public function getInvalidFeedback(String $key): String
    {
        $content = self::checkErrorsNotification($key) ? self::getErrorNotification($key) : '';
        return '<small class="text-danger">'.$content.'</small>';
    }
}