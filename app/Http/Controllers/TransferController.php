<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransferService;
use App\Http\Requests\TransferRequest;
use App\Repositories\TransferRepository;
use App\Models\User;

class TransferController extends Controller
{
    protected $transferService;

    public function __construct(TransferService $transferService)
    {
        $this->transferService = $transferService;
    }

    // Initiate the transfer
    public function initiate(TransferRequest $request)
    {
        // Recherche l'utilisateur par son numéro de téléphone
        $receiver = User::where('phone', $request->receiver_phone)->first();

        if (!$receiver) {
            return response()->json(['error' => 'Le destinataire n\'existe pas.'], 404);
        }

        // Créer le transfert
        $redisKey = $this->transferService->initiateTransfer($request->all(), $receiver->id);

        return response()->json(['message' => 'Transfert initié', 'key' => $redisKey], 201);
    }

    public function confirm(string $key)
    {
        try {
            $this->transferService->confirmTransfer($key);

            return response()->json(['message' => 'Transfert confirmé.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function cancel(string $key)
    {
        try {
            $this->transferService->cancelTransfer($key);

            return response()->json(['message' => 'Transfert annulé.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function history(Request $request, $accountId)
    {
        $transfers = app(TransferRepository::class)->getHistory($accountId)
            ->load(['sender.user', 'receiver.user']);

        $formattedTransfers = $transfers->map(function ($transfer) use ($accountId) {
            $isSender = $transfer->sender_id === $accountId;

            $otherAccount = $isSender ? $transfer->receiver : $transfer->sender;
            $otherUser = $otherAccount->user;

            return [
                'id' => $transfer->id,
                'amount' => $transfer->amount,
                'fee' => $transfer->fee,
                'status' => $transfer->status,
                'signe' => $isSender ? '-' : '+',
                'color' => $isSender ? 'red' : '',
                'otherPerson' => [
                    'id' => $otherAccount->id,
                    'firstName' => $otherUser->firstName,
                    'lastName' => $otherUser->lastName,
                    'type' => $isSender ? 'receiver' : 'sender',
                ],
                'date' => $transfer->created_at->toDateTimeString(),
            ];
        });

        return response()->json($formattedTransfers);
    }
}
