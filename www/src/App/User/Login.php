<?php

namespace App\User;

class Login
{
    private string $username;
    private string $password;
    private string $hashedPassword;
    private string $email;
    private string $token;
    private string $data = __DIR__ . "/data/data.json";
    private static array $users = [];
    private array $user;
    public string $error = "";
    public string $success = "";
    public function __construct(string $username, string $password)
    {

        $filterChars = " \t\n\r\0\x0B";

        $this->username = trim(filter_var($username, FILTER_SANITIZE_STRING), $filterChars);
        $this->password = trim(filter_var($password, FILTER_SANITIZE_STRING), $filterChars);

        $this->hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

        $this->users = json_decode(file_get_contents($this->data), true);

        if (
            $this->checkInputValues() &&
            $this->checkDataMatching() &&
            $this->user["token"] === "" &&
            $this->addTokenToUser() &&
            $this->saveUsers()
        ) {
            $this->setSessionAndLogin();
        }
    }

    public static function getUserFromToken(string $token): object | bool
    {
        foreach (self::$users as $user) {
            if ($user["token"] === $token) {
                return $user;
            }
        }
        return false;
    }

    private function setSessionAndLogin(): void
    {
        $_SESSION['token'] = $this->token;
        header("location: /dashboard");
    }

    private function addTokenToUser(): bool
    {

        $this->token = $this->generateToken();
        foreach ($this->users as $user) {
            if ($user["username"] === $this->user["username"]) {
                $user["token"] = $this->token;
            }
        }
        return true;
    }

    private function checkDataMatching(): bool
    {
        foreach ($this->users as $user) {
            if ($this->username === $user->username) {
                if (password_verify($this->hashedPassword, $user["password"])) {
                    $this->user = $user;
                    return true;
                }
                break;
            }
        }
        $this->error = "Nem található felhasználó ezzel a jelszóval!";
        return false;
    }

    private function checkInputValues(): bool
    {
        if (empty($this->username) || empty($this->password)) {
            $this->error = "Felhasználónév és jelszó megadása kötelező.";
            return false;
        }
        return true;
    }

    private function generateToken(): string
    {
        $bytes = random_bytes(16);
        return bin2hex($bytes);
    }

    private function saveUsers(): bool
    {
        if (file_put_contents($this->data, json_encode($this->users, JSON_PRETTY_PRINT))) {
            $this->success = "Sikeres bejelentkezés!";
            return true;
        } else {
            $this->error = "Valami hiba történt, próbáld úrja.";
            return false;
        }
    }
}
