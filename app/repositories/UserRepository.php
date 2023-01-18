<?php
require_once __DIR__ . '/../Models/User.php';
include_once __DIR__ . '/Repository.php';

class UserRepository extends Repository
{
    function verifyAndGetUser($email, $enteredPassword)
    {
        try {
            $user = null;
            $stmt = $this->connection->prepare("SELECT id,firstName, lastName, email,HashPassword,Salt FROM Users WHERE email= :email");
            $stmt->bindParam(":email", $email);
            if ($this->checkUserExistence($stmt)) {
                $storedPassword = $this->getSaltAndHashedPassword($stmt);
                if ($this->verifyPassword($enteredPassword, $storedPassword[0], $storedPassword[1])) {
                    $stmt->execute();
                    $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
                    $user = $stmt->fetch();
                }
            }
            return $user;
        } catch (PDOException $e) {
            echo $e;
        }
    }
    private function getSaltAndHashedPassword($stmt)
    {
        try {
            $stmt->execute();

            while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
                $hashPassword = $result["HashPassword"];
                $salt = $result["Salt"];
            }
            return [$hashPassword, $salt];
        } catch (PDOException $e) {
            echo $e;
        }
    }
    private function checkUserExistence($stmt): bool
    {
        try {
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    private function verifyPassword($enteredPassword, $hashedPassword, $salt): bool
    {
        return password_verify($enteredPassword . $salt, $hashedPassword);
    }
    public function  getUserById($id)
    {
        $stmt = $this->connection->prepare("SELECT id,firstName, lastName, email FROM Users WHERE id= :id");
        $stmt->bindParam(":id", $id);
        if ($this->checkUserExistence($stmt)) {
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
            return $stmt->fetch();
        }
        return null;
    }
    public function insertUserInDatabase($userDetails) :bool{
        $stmt = $this->connection->prepare("INSERT INTO Users( firstName, lastName, email, HashPassword, Salt) VALUES (:firstName,:lastName,:email,:hashPassword,:salt)");
        $stmt->bindValue(":firstName",$userDetails["firstName"]);
        $stmt->bindValue(":lastName",$userDetails["lastName"]);
        $stmt->bindValue(":email",$userDetails["email"]);
        $stmt->bindValue(":hashPassword",$userDetails["hashPassword"]);
        $stmt->bindValue(":salt",$userDetails["salt"]);
        $stmt->execute();
        if ($stmt->rowCount()==0){
            return false;
        }
        return true;
    }
}
