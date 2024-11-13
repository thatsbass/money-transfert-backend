<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\AccountService;
use App\Services\QrCodeService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Jobs\SendWelcomeEmailJob;

class CreateAccountJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle(QrCodeService $qrCodeService, AccountService $accountService)
    {
        try {
            $qrCodeUrl = $qrCodeService->generateQrCode($this->user->phone);

            $accountData = ([
                'user_id' => $this->user->id,
                'currency' => 'XOF',
                'qrCode' => $qrCodeUrl,
                'status' => 'ACTIVE'
            ]);

            $accountService
            ->createClientAccount($accountData);

            SendWelcomeEmailJob::dispatch($this->user, $qrCodeUrl);

        } catch (\Exception $e) {
            Log::error('Failed to create account: ' . $e->getMessage(), [
                'user_id' => $this->user->id,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
}
