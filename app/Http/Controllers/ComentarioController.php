<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Noticia;
use \Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ComentarioController extends Controller
{
    private const RULES = [
        'mensaje'    => 'required|string|min:2|max:255',
        'valoracion' => 'required|in:positivo,negativo',
    ];

    private const MESSAGES = [
        // Mensaje
        'mensaje.required' => 'El mensaje es obligatorio.',
        'mensaje.string'   => 'El mensaje debe ser una cadena de texto.',
        'mensaje.min'      => 'El mensaje debe tener al menos 2 caracteres.',
        'mensaje.max'      => 'El mensaje no puede superar los 255 caracteres.',

        // Valoración
        'valoracion.required' => 'La valoración es obligatoria.',
        'valoracion.in'       => 'La valoración debe ser positivo o negativo.',
    ];

    public function create(Noticia $noticia): View {
        return view('comentario.create', ['noticia' => $noticia]);
    }

    public function store(Request $request, Noticia $noticia): RedirectResponse {
        $validator = Validator::make($request->all(), self::RULES, self::MESSAGES);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }

        $comentario = new Comentario($request->all());
        $comentario->noticia_id = $noticia->id;
        try {
            $comentario->save();
        } catch (Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Error al crear el comentario.']);
        }
        return redirect()->route('noticia.index')->with(['success' => 'Se ha creado el comentario correctamente.']);
    }

    public function edit(Comentario $comentario): View|RedirectResponse {
        if (!$comentario->puedeModificarse()) {
            return redirect()->route('noticia.index')->withErrors(['error' => 'Han pasado más de 5 minutos, no se puede editar el comentario.']);
        }
        return view('comentario.edit', ['comentario' => $comentario]);
    }

    public function update(Request $request, Comentario $comentario): RedirectResponse {
        if (!$comentario->puedeModificarse()) {
            return redirect()->route('noticia.index')->withErrors(['error' => 'Han pasado más de 5 minutos, no se puede editar el comentario.']);
        }

        $validator = Validator::make($request->all(), self::RULES, self::MESSAGES);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }

        try {
            $comentario->update($request->only(['mensaje', 'valoracion']));
        } catch (Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Error al editar el comentario.']);
        }
        return redirect()->route('noticia.index')->with(['success' => 'Se ha editado el comentario correctamente.']);
    }

    public function destroy(Comentario $comentario): RedirectResponse {
        if (!$comentario->puedeModificarse()) {
            return redirect()->route('noticia.index')->withErrors(['error' => 'Han pasado más de 5 minutos, no se puede borrar el comentario.']);
        }

        try {
            $comentario->delete();
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Error al borrar el comentario.']);
        }
        return redirect()->route('noticia.index')->with(['success' => 'Se ha borrado el comentario.']);
    }
}