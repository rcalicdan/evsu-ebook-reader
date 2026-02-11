<?php

namespace App\Services;

class RedirectNotification
{
    /**
     * Flash a notification message to the session
     *
     * @param string $message
     * @param string $type
     * @return void
     */
    public static function flash(string $message, string $type = 'success'): void
    {
        session()->flash('notify', [
            'message' => $message,
            'type' => $type,
        ]);
    }

    /**
     * Flash a success notification
     *
     * @param string $message
     * @return void
     */
    public static function success(string $message): void
    {
        self::flash($message, 'success');
    }

    /**
     * Flash an error notification
     *
     * @param string $message
     * @return void
     */
    public static function error(string $message): void
    {
        self::flash($message, 'error');
    }

    /**
     * Flash a warning notification
     *
     * @param string $message
     * @return void
     */
    public static function warning(string $message): void
    {
        self::flash($message, 'warning');
    }

    /**
     * Flash an info notification
     *
     * @param string $message
     * @return void
     */
    public static function info(string $message): void
    {
        self::flash($message, 'info');
    }
}