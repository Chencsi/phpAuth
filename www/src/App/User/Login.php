<?php

namespace App\User;

use Exception;

class Login
{
    private string $username;
    private string $password;
    private string $hashedPassword;
    private string $email;
    private string $token;
    private string $data = __DIR__ . "/../../../data/data.json";
    private static array $users = [];
    private array $user;
    public string $error = "";
    public string $success = "";
    public function __construct(string $username, string $password)
    {

        $filterChars = " \t\n\r\0\x0B";

        $this->username = trim(htmlspecialchars($username), $filterChars);
        $this->password = trim(htmlspecialchars($password), $filterChars);

        $this->hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

        self::$users = json_decode(file_get_contents($this->data), true);
        if (
            $this->checkInputValues() &&
            $this->checkDataMatching() &&
            $this->clearOldToken() &&
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

    private function clearOldToken(): bool {
        $this->user["token"] = "";
        return true;
    }

    private function setSessionAndLogin(): void
    {
        $_SESSION['token'] = $this->token;
    }

    private function addTokenToUser(): bool
    {
        $this->token = $this->generateToken();
        foreach (self::$users as $key => $user) {
            if ($user["username"] === $this->user["username"]) {
                self::$users[$key]["token"] = $this->token;
            }
        }
        return true;
    }

    private function checkDataMatching(): bool
    {
        foreach (self::$users as $user) {
            if ($this->username === $user["username"]) {
                if (password_verify($this->password, $user["password"])) {
                    $this->user = $user;
                    return true;
                }
                break;
            }
        }
        $this->error = "Helytelen jelszó!";
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
        try {
            file_put_contents($this->data, json_encode(self::$users, JSON_PRETTY_PRINT));
            $this->success = "Sikeres bejelentkezés!";
            return true;
        } catch (Exception $e) {
            $this->error = "Valami hiba történt, próbáld úrja. $e";
            return false;
        }
    }
}
