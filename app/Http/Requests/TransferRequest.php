<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à effectuer cette requête.
     */
    public function authorize()
    {
        return true; // Modifier selon les règles d'autorisation spécifiques si nécessaires
    }

    /**
     * Règles de validation.
     */
    public function rules()
    {
        return [
            'sender_id' => 'required|uuid|exists:accounts,id',
            'receiver_id' => 'required|uuid|exists:accounts,id|different:sender_id',
            'amount' => 'required|numeric|min:1|max:1000000', // Limite de montant (ajuster si nécessaire)
        ];
    }

    /**
     * Messages de validation personnalisés.
     */
    public function messages()
    {
        return [
            'sender_id.required' => 'L\'identifiant de l\'expéditeur est requis.',
            'sender_id.uuid' => 'L\'identifiant de l\'expéditeur doit être un UUID valide.',
            'sender_id.exists' => 'L\'expéditeur doit exister dans le système.',
            'receiver_id.required' => 'L\'identifiant du destinataire est requis.',
            'receiver_id.uuid' => 'L\'identifiant du destinataire doit être un UUID valide.',
            'receiver_id.exists' => 'Le destinataire doit exister dans le système.',
            'receiver_id.different' => 'L\'expéditeur et le destinataire doivent être différents.',
            'amount.required' => 'Le montant est requis.',
            'amount.numeric' => 'Le montant doit être un nombre.',
            'amount.min' => 'Le montant minimum autorisé est de 1.',
            'amount.max' => 'Le montant maximum autorisé est de 1 000 000.',
        ];
    }
}
