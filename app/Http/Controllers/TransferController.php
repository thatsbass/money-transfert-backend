<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransferService;
use App\Http\Requests\TransferRequest;

class TransferController extends Controller
{

    protected $transferService;

    public function __construct(TransferService $transferService)
    {
        $this->transferService = $transferService;
    }


    public function initiateTransfer(TransferRequest $request)
    {
        $transferKey = $this->transferService->initiateTransfer($request->validated());

        return response()->json([
            'message' => 'Transfert temporaire initié avec succès.',
            'transfer_key' => $transferKey,
        ], 201);
    }


    public function confirmTransfer(string $transferKey)
    {
        try {
            $transfer = $this->transferService->confirmTransfer($transferKey);

            return response()->json([
                'message' => 'Transfert confirmé avec succès.',
                'transfer' => $transfer,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    
    // Create transfer
    public function simpleTransfer(TransferRequest $request){}
    public function MultipleTransfer(TransferRequest $request){}
    public function scheduleTransfer(TransferRequest $request){}

    // Get transfer history by client
    public function historyTransferByClient(Request $request){}

    // Cancelled transfer
    public function cancelTransfer(Request $request){}
}







/*
   * il faut une classe mere de base apiService qui s'occuperas le communication du backend avec le frontend qui aura les methode de requete
    (post, get , put, delete) et les erreurs.

    * Il faut des sercice qui s'herite de la classe apiService pour chaque methode de requete

    * IL faut un seul provider qui s'occupe
*/