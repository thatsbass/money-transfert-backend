<?php
namespace App\Services;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeService
{
    public function generateQrCode($data)
    {
        // $qrCode = QrCode::format('png')->size(200)->generate($data);
        // $filePath = storage_path('app/public/qrcodes/' . uniqid() . '.png');
        // file_put_contents($filePath, $qrCode);
        // return $filePath;
        $qrCode = QrCode::format('png')->size(200)->generate($data);
        return base64_encode($qrCode);
    }



}



/*

je suis en projet laravel et je veux generer un qr code , il faut le convertir en base 64 pour le stocker dans la base de données

Et lors de la recuperation du qr code je veux le recuperer en base 64 et le generer en image
*/