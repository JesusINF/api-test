<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Notes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class NotesController extends Controller
{
    public function add(Request $request)
    {
        try {
            $validateNote = Validator::make(
                $request->all(),
                [
                    'title' => 'required',
                    'description' => 'required',
                ]
            );

            if ($validateNote->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => "Campos incorrectos.",
                    'errors' => $validateNote->errors()
                ], 401);
            }

            $note = Notes::create(
                [
                    'title' => $request->title,
                    'description' => $request->description,
                    'user_id' => auth()->user()->id
                ]
            );

            return response()->json([
                'status' => true,
                'message' => "Nota agregada correctamente."
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validateNote = Validator::make(
                $request->all(),
                [
                    'title' => 'required',
                    'description' => 'required',
                ],
            );

            if ($validateNote->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => "Campos incorrectos.",
                    'errors' => $validateNote->errors()
                ], 401);
            }

            $note = Notes::find($id)->update(
                [
                    'title' => $request->title,
                    'description' => $request->description,
                ]
            );

            return response()->json([
                'status' => true,
                'message' => "Nota actualizada correctamente."
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function delete($id)
    {
        try {

            $note = Notes::where('id', $id)->delete();

            if (!$note) {
                return response()->json([
                    'status' => false,
                    'message' => "Surgió un error al intentar eliminar esta nota.",
                ], 401);
            }

            return response()->json([
                'status' => true,
                'message' => "Nota eliminada correctamente.",
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function notes()
    {
        try {

            $note = Notes::where('user_id', auth()->user()->id)->get();

            return response()->json([
                'status' => true,
                'message' => "Notas obtenidas correctamente.",
                'data' => $note
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
