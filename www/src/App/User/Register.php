<?php

class Register {

    private string $username;
    private string $password;
    private string $hashedPassword;
    private string $email;
    private string $data = "data.json";
    private array $newUser;
    private array $users = [];
    public string $error = "";
    public string $success = "";
    public function __construct(string $username, string $password, string $email) {

        $this->username = trim(filter_var($username, FILTER_SANITIZE_STRING), " \t\n\r\0\x0B");
        $this->email = trim(filter_var($email, FILTER_SANITIZE_EMAIL), " \t\n\r\0\x0B");
        $this->password = trim(filter_var($password, FILTER_SANITIZE_STRING), " \t\n\r\0\x0B");

        $this->hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

        $this->users = json_decode(file_get_contents($this->data), true);

        $this->newUser = [
            "username" => $this->username,
            "email"=> $this->email,
            "password" => $this->hashedPassword
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

    private function usernameExists(): bool {
        foreach($this->users as $user) {
            if ($user["username"] === $this->username) {
                $this->error = "Már létezik felhasználó ilyen névvel.";
                return false;
            }
        }
        return true;
    }

    private function insertNewUser(): void {
        if (!$this->usernameExists()) {
            array_push($this->users, $this->newUser);
            if (file_put_contents($this->data, json_decode($this->users, JSON_PRETTY_PRINT))) {
                $this->success = "Sikeresen regisztráltál!";
                return;
            } else {
                return $this->error = "Valami hiba történt, próbáld úrja."
            }
        }
    }

}