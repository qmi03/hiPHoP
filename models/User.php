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
  public function fetchById(int $id): ?User
  {
    try {
      $conn = Database::getInstance();
      $conn->beginTransaction();
      $stmt = $conn->prepare('SELECT * FROM users WHERE id = ?');
      $stmt->execute([$id]);
      $user = $stmt->fetch();
      if (!$user) {
        $conn->commit();

        return null;
      }
      $conn->commit();

      return new User($id, new DateTime($user['dob']), $user['first_name'], $user['last_name'], $user['address'], $user['email'], $user['username'], $user['avatar_url'], $user['is_admin']);
    } catch (PDOException $e) {
      return null;
    }
  }

  public function fetchPage(int $pageNumber, int $pageSize): array
  {
    $conn = Database::getInstance();
    try {
      $conn->beginTransaction();
      $offset = $pageNumber * $pageSize;
      $stmt = $conn->prepare('SELECT * FROM users ORDER BY id LIMIT :limit OFFSET :offset');
      $stmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
      $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
      $stmt->execute();
      $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $conn->commit();

      return array_map(fn($user) => new User($user['id'], new DateTime($user['dob']), $user['first_name'], $user['last_name'], $user['address'], $user['email'], $user['username'], $user['avatar_url'], $user['is_admin']), $users);
    } catch (PDOException $e) {
      print_r($e);
      $conn->rollBack();

      return [];
    }
  }

  public function fetchPageByKeyword(string $keyword, int $pageNumber, int $pageSize): array
  {
    $conn = Database::getInstance();
    try {
      $conn->beginTransaction();
      $offset = $pageNumber * $pageSize;
      $stmt = $conn->prepare('
        SELECT *
        FROM users
        WHERE username LIKE :keyword OR email LIKE :keyword
        ORDER BY id LIMIT :limit OFFSET :offset
      ');
      $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
      $stmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
      $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
      $stmt->execute();
      $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $conn->commit();

      return array_map(fn($user) => new User($user['id'], new DateTime($user['dob']), $user['first_name'], $user['last_name'], $user['address'], $user['email'], $user['username'], $user['avatar_url'], $user['is_admin']), $users);
    } catch (PDOException $e) {
      print_r($e);
      $conn->rollBack();

      return [];
    }
  }

  public function fetchCount(): int
  {
    $conn = Database::getInstance();

    try {
      $conn->beginTransaction();
      $stmt = $conn->prepare('SELECT COUNT(*) FROM users');
      $stmt->execute();
      $total = $stmt->fetch();
      $conn->commit();

      return $total[0];
    } catch (PDOException $e) {
      $conn->rollBack();

      return 0;
    }
  }

  public function fetchCountByKeyword(string $keyword): int
  {
    $conn = Database::getInstance();

    try {
      $conn->beginTransaction();
      $stmt = $conn->prepare('
        SELECT COUNT(*)
        FROM users
        WHERE username LIKE :keyword OR email LIKE :keyword
      ');
      $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
      $stmt->execute();
      $total = $stmt->fetch();
      $conn->commit();

      return $total[0];
    } catch (PDOException $e) {
      $conn->rollBack();

      return 0;
    }
  }

  public function update(int $id, string $firstName, string $lastName, string $address, DateTime $dob, bool $isAdmin): void
  {
    $conn = Database::getInstance();

    try {
      $conn->beginTransaction();
      $stmt = $conn->prepare('
        UPDATE users
        SET first_name = ?, last_name = ?, address = ?, dob = ?, is_admin = ?
        WHERE id = ?
      ');
      $stmt->execute([$firstName, $lastName, $address, $dob->format('Y-m-d'), (int) $isAdmin, $id]);
      $conn->commit();
    } catch (PDOException $e) {
      $conn->rollBack();
    }
  }

  public function changePassword(int $id, string $password): void
  {
    $conn = Database::getInstance();

    try {
      $conn->beginTransaction();
      $stmt = $conn->prepare('
        UPDATE users
        SET password = ?
        WHERE id = ?
      ');
      $stmt->execute([password_hash($password, PASSWORD_BCRYPT), $id]);
      $conn->commit();
    } catch (PDOException $e) {
      $conn->rollBack();
    }
  }
}
