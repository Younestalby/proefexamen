<?php
// classes/Session.php

class Session {
    public static function init() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public static function get($key) {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : false;
    }

    public static function destroy() {
        session_unset();
        session_destroy();
    }
}
?>
