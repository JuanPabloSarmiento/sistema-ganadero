<?php

namespace App\Exports;

use App\Models\Animal;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class AnimalesExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Animal::query();

        if (!empty($this->filters['arete'])) {
            $query->where('arete', 'like', '%'.$this->filters['arete'].'%');
        }

        if (!empty($this->filters['sexo'])) {
            $query->where('sexo', $this->filters['sexo']);
        }

        if (isset($this->filters['activo']) && $this->filters['activo'] !== '') {
            $query->where('activo', $this->filters['activo']);
        }

        return $query->select('id','arete','especie','raza','sexo','fecha_nacimiento','peso_actual','activo','created_at')
                     ->orderBy('arete')
                     ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Arete',
            'Especie',
            'Raza',
            'Sexo',
            'Fecha Nacimiento',
            'Peso Actual (kg)',
            'Activo',
            'Creado en'
        ];
    }
}
