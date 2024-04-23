<?php

namespace App\User;

class Register {
    private string $username;
    private string $password;
    private string $hashedPassword;
    private string $email;
    private string $data = __DIR__ . "/../../../data/data.json";
    private array $newUser;
    private array $users = [];
    public string $error = "";
    public string $success = "";
    public function __construct(string $username, string $email, string $password) {

        $filterChars = " \t\n\r\0\x0B";

        $this->username = trim(htmlspecialchars($username), $filterChars);
        $this->email = trim(htmlspecialchars($email), $filterChars);
        $this->password = trim(htmlspecialchars($password), $filterChars);

        $this->hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

        $this->users = json_decode(file_get_contents($this->data), true);

        $this->newUser = [
            "username" => $this->username,
            "email"=> $this->email,
            "password" => $this->hashedPassword,
            "token" => ""
        ];

        if ($this->checkInputValues()) {
            $this->insertNewUser();
        }

    }
    
    private function checkInputValues(): bool {
        if (empty($this->username) || empty($this->password) || empty($this->email)) {
            $this->error = "Minden mező kitöltése szükséges a regisztrációhoz.";
            return false;
        }
        return true;
    }

    private function validateDatas(): bool {
        foreach($this->users as $user) {
            if ($user["username"] === $this->username) {
                $this->error = "Ez a felhasználónév már foglalt.";
                return true;
            }
            if ($user["email"] === $this->email) {
                $this->error = "Ez az E-mail cím már foglalt.";
                return true;
            }
            if (strlen($this->password) < 6) {
                $this->error = "A jelszónak legalább 6 karakter hosszúnak kell lennie.";
                return true;
            }
            if (strlen($this->username) < 6) {
                $this->error = "A felhasználónévnek legalább 6 karakter hosszúnak kell lennie.";
                return true;
            }
            if (filter_var($user["email"], FILTER_VALIDATE_EMAIL)) {
                $this->error = "Nem megfelelő E-mail cím formátum.";
                return true;
            }
        }
        return false;
    }

    private function insertNewUser(): void {
        if (!$this->validateDatas()) {
            array_push($this->users, $this->newUser);
            if (file_put_contents($this->data, json_encode($this->users, JSON_PRETTY_PRINT))) {
                $this->success = "Sikeresen regisztráltál!";
            } else {
                $this->error = "Valami hiba történt, próbáld úrja.";
            }
        }
    }
}