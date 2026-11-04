<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use \Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class NoticiaController extends Controller
{
    private const RULES = [
        'titulo' => 'required|string|min:3|max:150',
        'texto'  => 'required|string|min:10',
    ];

    private const MESSAGES = [
        // Título
        'titulo.required' => 'El título es obligatorio.',
        'titulo.string'   => 'El título debe ser una cadena de texto.',
        'titulo.min'      => 'El título debe tener al menos 3 caracteres.',
        'titulo.max'      => 'El título no puede superar los 150 caracteres.',

        // Texto
        'texto.required' => 'El texto es obligatorio.',
        'texto.string'   => 'El texto debe ser una cadena de texto.',
        'texto.min'      => 'El texto debe tener al menos 10 caracteres.',
    ];

    public function index(): View {
        $noticias = Noticia::with('comentarios')->orderBy('created_at', 'desc')->get();
        return view('noticia.index', ['noticias' => $noticias]);
    }

    public function create(): View {
        return view('noticia.create');
    }

    public function store(Request $request): RedirectResponse {
        $validator = Validator::make($request->all(), self::RULES, self::MESSAGES);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }

        $noticia = new Noticia($request->all());
        try {
            $noticia->save();
        } catch (Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Error al crear la noticia.']);
        }
        return redirect()->route('noticia.index')->with(['success' => 'Se ha creado la noticia correctamente.']);
    }

    public function edit(Noticia $noticia): View|RedirectResponse {
        if (!$noticia->puedeEditarse()) {
            return redirect()->route('noticia.index')->withErrors(['error' => 'Han pasado más de 20 minutos, no se puede editar la noticia.']);
        }
        return view('noticia.edit', ['noticia' => $noticia]);
    }

    public function update(Request $request, Noticia $noticia): RedirectResponse {
        if (!$noticia->puedeEditarse()) {
            return redirect()->route('noticia.index')->withErrors(['error' => 'Han pasado más de 20 minutos, no se puede editar la noticia.']);
        }

        $validator = Validator::make($request->all(), self::RULES, self::MESSAGES);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }

        try {
            $noticia->update($request->all());
        } catch (Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Error al editar la noticia.']);
        }
        return redirect()->route('noticia.index')->with(['success' => 'Se ha editado la noticia correctamente.']);
    }

    public function destroy(Noticia $noticia): RedirectResponse {
        if (!$noticia->puedeBorrarse()) {
            return redirect()->route('noticia.index')->withErrors(['error' => 'No se puede borrar una noticia que tiene comentarios.']);
        }

        try {
            $noticia->delete();
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Error al borrar la noticia.']);
        }
        return redirect()->route('noticia.index')->with(['success' => 'Se ha borrado la noticia.']);
    }
}