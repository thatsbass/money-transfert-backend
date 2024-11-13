<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Exception;

class FileUploadService
{
    public function uploadFile(UploadedFile $file, string $directory = 'uploads', string $disk = 'public'): string
    {
        try {
            $fileName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs($directory, $fileName, $disk);
            return $filePath;
        } catch (Exception $e) {
            throw new Exception("Erreur lors de l'upload du fichier : " . $e->getMessage());
        }
    }
}


