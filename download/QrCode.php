<?php
require_once('vendor/autoload.php');
use Endroid\QrCode\QrCode;
$qrCode = new QrCode();

$host = isset($_GET['host']) ? $_GET['host'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : '';

$qrCode
    ->setText("http://".$host.$id)
    ->setSize(300)
    ->setPadding(10)
    ->setErrorCorrection('high')
    ->setLabelFontSize(16)
    ->setImageType(QrCode::IMAGE_TYPE_PNG);

header('Content-Type: '.$qrCode->getContentType());
$qrCode->render();