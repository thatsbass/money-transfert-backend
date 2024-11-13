<?php

namespace App\Services;

use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Repositories\Interfaces\TransferRepositoryInterface;

class TranferService
{
  protected $transferRepository;

  public function __construct(TransferRepositoryInterface $transferRepository)
  {
    $this->transferRepository = $transferRepository;
  }


  // Create transfer
  public function simpleTransfer() {}
  public function MultipleTransfer() {}
  public function scheduleTransfer() {}

  // Get transfer history by client
  public function historyTransferByClient() {}

  // Cancelled transfer
  public function cancelTransfer() {}

  private function calculateFee($amount) {}
}
