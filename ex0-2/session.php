<?php
class Session {
    private $data = [];
    private $started = false;

    public function start() {
        if (!$this->started) {
            session_start();
            $this->data = $_SESSION;
            $this->started = true;
        }
    }

    public function set($key, $value) {
        $this->data[$key] = $value;
        $_SESSION[$key] = $value;
    }

    public function get($key) {
        return $this->data[$key] ?? null;
    }

    public function has($key) {
        return isset($this->data[$key]);
    }

    public function destroy() {
        $this->data = [];
        $this->started = false;
        session_unset();
        session_destroy();
    }
}
