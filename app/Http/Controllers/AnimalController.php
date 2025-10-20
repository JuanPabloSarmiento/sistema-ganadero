<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\Response;

class AnimalController extends Controller
{
    public function index(Request $request)
    {
        $query = Animal::query();

        // Filtro por estado (activo/inactivo)
        if ($request->filled('activo')) {
            $query->where('activo', $request->activo);
        }

        // Filtro por número de arete
        if ($request->filled('arete')) {
            $query->where('arete', 'like', '%'.$request->arete.'%');
        }

        // Filtro por sexo
        if ($request->filled('sexo')) {
            $query->where('sexo', $request->sexo);
        }

        // Ordenar por arete
        $animales = $query->orderBy('arete')->paginate(10)->appends($request->query());

        return view('animales.index', compact('animales'));
    }

    public function create()
    {
        return view('animales.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'arete' => 'required|unique:animales|max:20',
            'especie' => 'required|max:50',
            'raza' => 'required|max:100',
            'sexo' => 'required|in:M,H',
            'fecha_nacimiento' => 'required|date|before:today',
            'peso_actual' => 'nullable|numeric|min:0',
            'foto' => 'nullable|image|max:2048'
        ]);

        $data = $request->only(['arete','especie','raza','sexo','fecha_nacimiento','peso_actual','padre_id','madre_id','activo']);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('public/animales');
            $data['foto'] = basename($path);
        }

        Animal::create($data);
        return redirect()->route('animales.index')->with('success','Animal registrado correctamente');
    }

    public function show(Animal $animal)
    {
        return view('animales.show', compact('animal'));
    }

    public function edit(Animal $animal)
    {
        return view('animales.edit', compact('animal'));
    }

    public function update(Request $request, Animal $animal)
    {
        $request->validate([
            'arete' => 'required|max:20|unique:animales,arete,'.$animal->id,
            'especie' => 'required|max:50',
            'raza' => 'required|max:100',
            'sexo' => 'required|in:M,H',
            'fecha_nacimiento' => 'required|date|before:today',
            'peso_actual' => 'nullable|numeric|min:0',
            'foto' => 'nullable|image|max:2048'
        ]);

        $data = $request->only(['arete','especie','raza','sexo','fecha_nacimiento','peso_actual']);

        if ($request->hasFile('foto')) {
            if ($animal->foto && file_exists(storage_path('app/public/animales/'.$animal->foto))) {
                unlink(storage_path('app/public/animales/'.$animal->foto));
            }

            $path = $request->file('foto')->store('public/animales');
            $data['foto'] = basename($path);
        }

        $animal->update($data);

        return redirect()->route('animales.show', $animal)
                         ->with('success', 'Animal actualizado correctamente');
    }

    public function destroy(Animal $animal)
    {
        $animal->update(['activo' => false]);
        return redirect()->route('animales.index')->with('success','Animal desactivado');
    }

    /**
     * Exporta los animales filtrados a un archivo Excel usando PhpSpreadsheet.
     */
    public function export(Request $request)
    {
        $filters = $request->only(['arete', 'sexo', 'activo']);

        // Consulta filtrada
        $query = Animal::query();

        if (!empty($filters['arete'])) {
            $query->where('arete', 'like', '%'.$filters['arete'].'%');
        }

        if (!empty($filters['sexo'])) {
            $query->where('sexo', $filters['sexo']);
        }

        if ($filters['activo'] !== null && $filters['activo'] !== '') {
            $query->where('activo', $filters['activo']);
        }

        $animales = $query->orderBy('arete')->get();

        // Crear hoja de cálculo
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Encabezados
        $headers = ['ID', 'Arete', 'Especie', 'Raza', 'Sexo', 'Fecha Nacimiento', 'Peso', 'Activo', 'Creado en'];
        $sheet->fromArray($headers, null, 'A1');

        // Datos
        $rows = $animales->map(function ($a) {
            return [
                $a->id,
                $a->arete,
                $a->especie,
                $a->raza,
                $a->sexo == 'M' ? 'Macho' : 'Hembra',
                $a->fecha_nacimiento,
                $a->peso_actual,
                $a->activo ? 'Sí' : 'No',
                $a->created_at->format('Y-m-d H:i'),
            ];
        })->toArray();

        $sheet->fromArray($rows, null, 'A2');

        // Estilo simple de encabezado
        $sheet->getStyle('A1:I1')->getFont()->setBold(true);

        // Descargar archivo
        $writer = new Xlsx($spreadsheet);
        $filename = 'animales_'.now()->format('Ymd_His').'.xlsx';

        $response = new Response();
        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment;filename="'.$filename.'"');
        $response->headers->set('Cache-Control', 'max-age=0');

        ob_start();
        $writer->save('php://output');
        $response->setContent(ob_get_clean());

        return $response;
    }
}
// End of AnimalController.php
