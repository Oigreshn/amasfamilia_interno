<?php

namespace App\Livewire;

use App\Models\Evento;
use Livewire\Component;
use Livewire\WithPagination;

class Historial extends Component
{
    use WithPagination;
    
    public $termino = '';


    public function render()
    {
        $termino = strtoupper($this->termino); // Convertir a mayúsculas
        $eventos = Evento::where('id_miembroprincipal', 'like', '%' . $termino . '%')->paginate(10);
        
        return view('livewire.historial', [
            'eventos' => $eventos,
        ]);
    }
}
