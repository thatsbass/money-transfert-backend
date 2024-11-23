<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Transfer;
use Illuminate\Support\Facades\Redis;
use App\Repositories\Interfaces\AccountRepositoryInterface;
use App\Repositories\Interfaces\TransferRepositoryInterface;

class TransferService
{
    protected AccountRepositoryInterface $accountRepository;
    protected TransferRepositoryInterface $transferRepository;

    public function __construct(AccountRepositoryInterface $accountRepository, TransferRepositoryInterface $transferRepository)
    {
        $this->accountRepository = $accountRepository;
        $this->transferRepository = $transferRepository;
    }

   // Initier le transfert
   public function initiateTransfer($data, $receiverId)
   {

       $redisKey = 'transfer:' . uniqid();
       Redis::set($redisKey, json_encode([
           'sender_id' => $data['sender_id'],
           'receiver_id' => $receiverId,
           'amount' => $data['amount'],
           'fee' => $this->calculateFee($data['amount']),
           'status' => 'PENDING',
       ]));

       return $redisKey;
   }

   // Confirmer le transfert
   public function confirmTransfer($key)
   {
       $transferData = json_decode(Redis::get($key), true);

       // Récupérer les comptes
       $senderAccount = Account::where('user_id',$transferData['sender_id'])->first();
       $receiverAccount = Account::where('user_id',$transferData['receiver_id'])->first();

       if ($senderAccount->balance < $transferData['amount'] + $transferData['fee']) {
           throw new \Exception('Solde insuffisant.');
       }

       // Effectuer le transfert
       $senderAccount->decrement('balance', $transferData['amount']);
       $receiverAccount->increment('balance', $transferData['amount']);

       // Sauvegarder le transfert dans la base de données
       Transfer::create([
           'sender_id' => $senderAccount->id,
           'receiver_id' => $receiverAccount->id,
           'amount' => $transferData['amount'],
           'fee' => $transferData['fee'],
           'status' => 'SUCCESS',
       ]);

       // Supprimer le transfert de Redis
       Redis::del($key);
   }

    public function cancelTransfer(string $redisKey, string $reason = 'Annulé par l’utilisateur'): bool
    {
        $transferData = Redis::hgetall($redisKey);

        if (!$transferData) {
            throw new \Exception('Le transfert n’existe pas ou a expiré.');
        }

        $transferData['status'] = 'CANCELED';
        $transferData['reason_failed'] = $reason;

        Redis::hmset($redisKey, $transferData);

        return true;
    }

    private function calculateFee(float $amount): float
    {
        return $amount * 0.01;
    }
}





  // Create transfer
  // public function simpleTransfer() {}
  // public function MultipleTransfer() {}
  // public function scheduleTransfer() {}

  // // Get transfer history by client
  // public function historyTransferByClient() {}