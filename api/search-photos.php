<?php
header('Content-Type: application/json');

require_once 'config/index.php';
require_once 'models/Photo.php';

$photoModel = new PhotoModel();

$keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';
$pageSize = isset($_POST['pageSize']) ? intval($_POST['pageSize']) : 12;

if ($keyword) {
  $photos = $photoModel->fetchPageByKeyword($keyword, 0, $pageSize);
} else {
  $totalCount = $photoModel->fetchCount();

  $randomOffset = max(0, rand(0, $totalCount - $pageSize));

  $photos = $photoModel->fetchPage($randomOffset, $pageSize);
}

$response = [
  'photos' => array_map(function ($photo) {
    return [
      'id' => $photo->id,
      'name' => $photo->name,
      'url' => $photo->url
    ];
  }, $photos)
];

echo json_encode($response);
