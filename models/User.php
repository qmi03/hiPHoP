<?php
class User
{
  public int $id;
  public DateTime $dob;
  public string $firstName;
  public string $lastName;
  public string $address;
  public string $email;
  public string $username;
  public string $avatarUrl;
  public bool $isAdmin;

  public function __construct(int $id, DateTime $dob, string $firstName, string $lastName, string $address, string $email, string $username, string $avatarUrl, bool $isAdmin)
  {
    $this->id = $id;
    $this->dob = $dob;
    $this->firstName = $firstName;
    $this->lastName = $lastName;
    $this->address = $address;
    $this->email = $email;
    $this->username = $username;
    $this->avatarUrl = $avatarUrl;
    $this->isAdmin = $isAdmin;
  }
}

class UserModel
{
  public function fetchById(int $id): User | null
  {
    try {
      $conn = Database::getInstance();
      $conn->beginTransaction();
      $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
      $stmt->execute([$id]);
      $user = $stmt->fetch();
      if (!$user) {
        $conn->commit();
        return null;
      }
      $conn->commit();
      return new User($id, new DateTime($user["dob"]), $user["first_name"], $user["last_name"], $user["address"], $user["email"], $user["username"], $user["avatar_url"], $user["is_admin"]);
    } catch (PDOException $e) {
      return null;
    }
  }
}
