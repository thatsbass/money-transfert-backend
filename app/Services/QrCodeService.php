<?php
namespace App\Services;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeService
{
    public function generateQrCode($data)
    {
        $qrCode = QrCode::format('png')->size(200)->generate($data);
        $filePath = storage_path('app/public/qrcodes/' . uniqid() . '.png');
        file_put_contents($filePath, $qrCode);
        return $filePath;
    }
}