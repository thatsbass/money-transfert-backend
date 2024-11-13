<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PdfService
{
    public function generatePdf($qrCodePath)
    {
        // Préparer les données uniquement avec le chemin du code QR
        $data = [
            'qrCodePath' => $qrCodePath // Chemin du code QR
        ];

        $pdf = Pdf::loadView('pdf.card', $data);

        // Chemin pour enregistrer le fichier PDF
        $pdfFilePath = "public/cards/" . uniqid() . '_card.pdf';

        // Enregistrer le PDF à l'emplacement défini
        Storage::put($pdfFilePath, $pdf->output());

        // Retourner le chemin complet du fichier enregistré
        return Storage::path($pdfFilePath);
    }


}