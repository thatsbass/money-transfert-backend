<?php

namespace App\Http\Controllers;

use App\Http\Requests\OTPRequest;
use App\Http\Requests\RegisterClientRequest;
use App\Services\DiceBearService;
use App\Services\OTPService;

use App\Services\RedisService;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    private $userRedisService;
    private $otpService;
    private $userService;
    private $diceBearService;


    public function __construct(
        RedisService $userRedisService,
        OTPService $otpService,
        UserService $userService,
        DiceBearService $diceGen

    ) {
        $this->userRedisService = $userRedisService;
        $this->otpService = $otpService;
        $this->userService = $userService;
        $this->diceBearService = $diceGen;

    }

    public function registerClient(RegisterClientRequest $request)
    {
        $userData = $request->only(['firstName', 'lastName', 'email', 'phone', 'password', 'role_id']);
        $clientData = $request->only(['address', 'CIN']);

        try {
            $tempKey = $this->userRedisService->createUserTemporary($userData, $clientData);
            $this->otpService->generateOtp($userData['phone']);

            return response()->json([
                'message' => 'Un OTP a été envoyé pour vérification.',
                'tempKey' => $tempKey,
            ], 200);
        } catch (Exception $e) {
            Log::error('Erreur lors de l\'inscription : ' . $e->getMessage());
            return response()->json(['error' => 'Une erreur est survenue lors de l\'inscription.'], 500);
        }
    }


    public function completeRegistration(OTPRequest $request)
    {
        $phone = $request->input('phone');
        $otpInput = $request->input('otp');

        try {

            $otpVerified = $this->otpService->verifyOtp($phone, $otpInput);

            if ($otpVerified === true) {
                $data = $this->userRedisService->retrieveTemporaryUserData($phone);

                if (!$data) {
                    throw new Exception("Données temporaires non trouvées. Veuillez recommencer l'inscription.");
                }

                $userData = $this->userRedisService->extractUserData($data);
                $clientData = $this->userRedisService->extractClientData($data);

                $client = $this->userService->registerClient($userData, $clientData);
                $this->userRedisService->deleteTemporaryUserData($phone);

                return response()->json([
                    'client' => $client,
                    'message' => 'Client enregistré avec succès'
                ], 201);
            }

            return response()->json(['error' => $otpVerified], 400);
        } catch (Exception $e) {
            Log::error('Erreur lors de la vérification OTP : ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function generate(){
        $photo = $this->diceBearService->generateAvatar('Fatima Mbengue');
        return response()->json([
            'message' => "L'image generer avec succes!",
            'urlImage' => $photo,
        ], 200);
    }
}
