<?php
namespace App\Classes\Core;

use DateTimeImmutable;

class Upload
{
    private const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    private const MAX_SIZE = 5_000_000; // 5 Mo

    public static function moveFile(array $file): ?string
    {
        if (!self::isValid($file)) {
            return null;
        }

        $uploadDir = dirname(__DIR__, 3) . "/public/uploads/";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $filename = self::renameFile($file["name"]);
        $destination = $uploadDir . $filename;

        if (move_uploaded_file($file["tmp_name"], $destination)) {
            return "uploads/" . $filename;
        }

        return null;
    }

    private static function isValid(array $file): bool
    {
        if ($file["error"] !== UPLOAD_ERR_OK) {
            return false;
        }

        if ($file["size"] > self::MAX_SIZE) {
            return false;
        }

        $extension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

        if (!in_array($extension, self::ALLOWED_EXTENSIONS)) {
            return false;
        }

        return true;
    }

    private static function renameFile(string $filename): string
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        return (new DateTimeImmutable())->format("YmdHis") . "_" . uniqid() . "." . $extension;
    }
}