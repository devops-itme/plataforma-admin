<?php

namespace App\Modules\DocumentModule;

use App\Http\Controllers\Traits\RestActions;
use App\Modules\UserModule\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Document extends Model
{
    use SoftDeletes, RestActions;

    protected $table = 'documents';
    protected $fillable = [
        'user_id',
        'url',
        'data',
        'active'
    ];

    protected $appends = ['file_url'];

    public function getFileUrlAttribute()
    {
        $link = "";
        if (!empty($this->url)) {
            $link = Storage::disk('s3')->url($this->url);
        }
        return $link;
    }

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getDocumentsByUser($request)
    {
        try {
            $validator = $this->validateDocument($request);
            if ($validator->fails()) {
                return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
            }
            $documents = $this::where('user_id', $request->user_id)->get();
            return $this->respond(200, $documents, null, 'Documentos obtenidos exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage() . 'Error al obtener los documentos');
        }
    }

    public function validateDocument($request, $action = null)
    {
        return Validator::make(
            $request->all(),
            [
                'user_id' => 'nullable|exists:users,id',
                'url' => [
                    Rule::requiredIf($action == 'create'), 'string'
                ],
                'data' => 'nullable',
                'active' => 'nullable|numeric'
            ]
        );
    }

    public function saveDocument($request)
    {
        $validator = $this->validateDocument($request, 'create');
        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
        }
        try {

            $document = $this::create([
                'user_id' => $request->user_id,
                'url' => $request->url,
                'data' => $request->data,
                'active' => $request->active,
            ]);
            return $this->respond(200, $document, null, 'Documento creado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage() . 'Error al crear el documento');
        }
    }

    public function updateDocument($request, $id)
    {
        $validator = $this->validateDocument($request);
        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(), 'validation error', $validator->errors()->first());
        }
        try {
            $document = $this::findOrFail($id);
            if (is_null($document)) {
                return $this->respond(500, [], 'user not found', 'No se encontró el documento');
            }
            $document->update([
                'user_id' => $request->user_id ?? $document->user_id,
                'url' => $request->url ?? $document->url,
                'data' => $request->data ?? $document->data,
                'active' => $request->active ?? $document->active,
            ]);
            return $this->respond(200, $document, null, 'Documento actualizado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al actualizar documento');
        }
    }

    public function deleteDocument($id)
    {
        try {
            $document = $this::findOrFail($id);
            if (is_null($document)) {
                return $this->respond(500, [], 'user not found', 'No se encontró el documento');
            }
            $document->delete();
            return $this->respond(200, $document, null, 'Documento eliminado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al eliminar documento');
        }
    }
}
