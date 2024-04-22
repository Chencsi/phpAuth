<?php

class Login {

    private string $username;
    private string $password;
    private string $hashedPassword;
    private string $email;
    private string $token;
    private string $data = __DIR__ . "/data/data.json";
    private array $users = [];
    private array $newUsers = [];
    private array $user;
    public string $error = "";
    public string $success = "";
    public function __construct(string $username, string $password) {

        $filterChars = " \t\n\r\0\x0B";

        $this->username = trim(filter_var($username, FILTER_SANITIZE_STRING), $filterChars);
        $this->password = trim(filter_var($password, FILTER_SANITIZE_STRING), $filterChars);

        $this->hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

        $this->users = json_decode(file_get_contents($this->data), true);

        if ($this->checkInputValues()) {
            if ($this->checkDataMatching()) {
                if ($this->user["token"] === "" ) {
                    if ($this->addTokenToUser()) {
                        $this->setSessionAndLogin();
                    }
                } else {
                    //ide még visszatérek
                    if ($this->checkToken($this->user["token"])) {
                        $this->setSessionAndLogin();
                    }
                }
            }
        }
    }

    private function setSessionAndLogin(): void {
        session_start();
        $_SESSION['token'] = $this->token;
        header("location: /dashboard");
    }

    private function checkToken(string $token): bool {
        if ($this->user["token"] === $token) {
            $this->success = "Sikeres bejelentkezés!";
            return true; 
        } else {
            $this->error = "Sikertelen bejelentkezés.";
            return false;
        }
    }

    private function addTokenToUser(): bool {

        $this->token = $this->generateToken();
        $this->user["token"] = $this->token;
        return true;
    }

    private function checkDataMatching(): bool {
        foreach ($this->users as $user) {
            if (
                $this->username === $user->username && 
                password_verify($this->hashedPassword, $user["password"])) {
                    $this->success = "Sikeres bejelentkezés!";
                    $this->user = $user;
                    return true;
                } 
        }
        $this->error = "Nem található felhasználó ezzel a jelszóval!";
        return false;
    }

    private function checkInputValues(): bool {
        if (empty($this->username) || empty($this->password)) {
            $this->error = "Felhasználónév és jelszó megadása kötelező.";
            return false;
        }
        return true;
    }

    private function generateToken(): string {
        $bytes = random_bytes(16);
        return bin2hex($bytes);
    }
}