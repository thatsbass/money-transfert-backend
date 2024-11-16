<?php

namespace App\Services;


use App\Models\Transfer;
use Illuminate\Support\Facades\Redis;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Repositories\Interfaces\TransferRepositoryInterface;

class TransferService
{
  protected $transferRepository;

  public function __construct(TransferRepositoryInterface $transferRepository)
  {
    $this->transferRepository = $transferRepository;
  }

   /**
     * Initialise un transfert en le stockant temporairement dans Redis.
     */
    public function initiateTransfer(array $data)
    {
        $transferKey = 'transfer:' . uniqid();

        // Ajoute les données dans Redis
        Redis::hmset($transferKey, [
            'sender_id' => $data['sender_id'],
            'receiver_id' => $data['receiver_id'],
            'amount' => $data['amount'],
            'fee' => $this->calculateFee($data['amount']),
            'status' => 'PENDING',
        ]);

        Redis::expire($transferKey, 70);

        return $transferKey;
    }

        /**
     * Finalise un transfert en le déplaçant de Redis à PostgreSQL.
     */
    public function confirmTransfer(string $transferKey)
    {
        $transferData = Redis::hgetall($transferKey);

        if (empty($transferData)) {
            throw new \Exception('Transfert introuvable ou expiré.');
        }

        // Sauvegarde dans PostgreSQL
        $transfer = $this->transferRepository->create([
            'sender_id' => $transferData['sender_id'],
            'receiver_id' => $transferData['receiver_id'],
            'amount' => $transferData['amount'],
            'fee' => $transferData['fee'],
            'status' => 'SUCCESS',
        ]);

        // Supprime les données de Redis après confirmation
        Redis::del($transferKey);

        return $transfer;
    }


    public function getTransferHistory($userId)
{
    $transfers = Transfer::where('sender_id', $userId)
        ->orWhere('receiver_id', $userId)
        ->orderBy('created_at', 'desc')
        ->get();

    // Formater la réponse
    $formattedTransfers = $transfers->map(function ($transfer) use ($userId) {
        return [
            'id' => $transfer->id,
            'amount' => $transfer->amount,
            'type' => $transfer->sender_id == $userId ? 'debit' : 'credit',
            'status' => $transfer->status,
            'other_party' => $transfer->sender_id == $userId ? $transfer->receiver->name : $transfer->sender->name,
            'date' => $transfer->created_at->toDateTimeString(),
        ];
    });

    return response()->json($formattedTransfers);
}



    private function calculateFee($amount)
    {
        return $amount * 0.01;
    }

  // Create transfer
  public function simpleTransfer() {}
  public function MultipleTransfer() {}
  public function scheduleTransfer() {}

  // Get transfer history by client
  public function historyTransferByClient() {}

  // Cancelled transfer
  public function cancelTransfer() {}

}
