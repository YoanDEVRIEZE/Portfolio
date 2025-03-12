<?php
namespace App\Enum;

enum StatutEnum: string
{
    case EnReflexion = 'En cours de réflexion';
    case EnCours = 'En cours';
    case Termine = 'Terminé';

    public function Statut(): string
    {
        return $this->value;
    }
}
