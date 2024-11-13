<?php

namespace App\Http\Controllers;

use App\Http\Requests\TranferRequest;
use Illuminate\Http\Request;

class TransferController extends Controller
{

    // Create transfer
    public function simpleTransfer(TranferRequest $request){}
    public function MultipleTransfer(TranferRequest $request){}
    public function scheduleTransfer(TranferRequest $request){}

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