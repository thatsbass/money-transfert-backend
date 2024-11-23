<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette requête.
     *
     * @return bool
     */
    public function authorize()
    {
        // Assurez-vous que seuls les utilisateurs authentifiés ou autorisés puissent faire un transfert
        // return auth()->check();
        return  true;
    }

    /**
     * Obtenez les règles de validation appliquées à la requête.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sender_id' => 'required|uuid|exists:users,id',
            'receiver_phone' => 'required|string|exists:users,phone',
            'amount' => 'required|numeric|min:1',
        ];
    }

    /**
     * Personnaliser les messages d'erreur de validation.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'sender_id.required' => 'L\'ID de l\'expéditeur est requis.',
            'sender_id.uuid' => 'L\'ID de l\'expéditeur doit être un UUID valide.',
            'sender_id.exists' => 'L\'expéditeur spécifié n\'existe pas dans la base de données.',
            'receiver_phone_number.required' => 'Le numéro de téléphone du destinataire est requis.',
            'receiver_phone_number.exists' => 'Le destinataire spécifié n\'existe pas.',
            'amount.required' => 'Le montant est requis.',
            'amount.numeric' => 'Le montant doit être un nombre.',
            'amount.min' => 'Le montant doit être supérieur ou égal à 1.',
            'fee.required' => 'Les frais sont requis.',
            'fee.numeric' => 'Les frais doivent être un nombre.',
            'fee.min' => 'Les frais ne peuvent pas être négatifs.',
        ];
    }
}
