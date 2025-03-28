<?php

class ContactModel
{
  public function fetch(): array
  {
    try {
      $conn = Database::getInstance();
      $conn->beginTransaction();
      $stmt = $conn->prepare('SELECT * FROM contacts');
      $stmt->execute([]);
      $contact = $stmt->fetch();
      $conn->commit();

      return $contact;
    } catch (PDOException $e) {
      return [];
    }
  }

  public function update(string $address, string $phone, string $email, string $facebook, string $github, string $latitude, string $longitude)
  {
    try {
      $conn = Database::getInstance();
      $conn->beginTransaction();
      $stmt = $conn->prepare('UPDATE contacts SET address = ?, phone = ?, facebook = ?, github = ?, latitude = ?, longitude = ?, email = ?');
      $stmt->execute([$address, $phone, $facebook, $github, $latitude, $longitude, $email]);
      $conn->commit();
    } catch (PDOException $e) {
    }
  }
}
