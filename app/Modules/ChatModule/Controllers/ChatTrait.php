<?php

namespace App\Modules\ChatModule\Controllers;

use App\Http\Controllers\Traits\RestActions;
use App\Modules\ChatModule\Chat;
use Illuminate\Support\Facades\Validator;

trait ChatTrait
{
    use RestActions;

    public function chatValidate($request)
    {
        return Validator::make(
            $request->all(),
            [
                'guide_id' => 'nullable',
                'content' => 'nullable',
                'state' => 'nullable',
            ]
        );
    }
    public function getChats()
    {
        try {
            $chats = Chat::get();
            return $this->respond(200, $chats);
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage());
        }
    }
    public function showChat($id)
    {
        try {
            $chat = Chat::where('id', $id)->first();
            return $this->respond(200, $chat);
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage());
        }
    }
    public function saveChat($request)
    {
        request()->merge([
            'content' => json_encode($request->content),
        ]);
        $validator = $this->chatValidate($request);

        if ($validator->fails()) {
            return $this->respond(500,  $validator->errors(),  $validator->errors()->first());
        }
        try {
            $chat = Chat::create($request->all());
            return $this->respond(200, $chat, null, 'Chat creado exitosamente');
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al crear Chat');
        }
    }
    public function updateChat($request, $id)
    {
        try {
            $validator = $this->chatValidate($request);
            if ($validator->fails()) {
                return $this->respond(500,  $validator->errors(),  $validator->errors()->first());
            }
            $chat = Chat::find($id);
            $chat->update($request->all());

            return $this->respond(200, $chat, null, 'Chat actualizado exitosamente');
        } catch (\Throwable $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al actualizar Chat');
        }
    }
    public function deleteChat($id)
    {
        try {
            $chat = Chat::find($id);
            $chat->delete();
            return $this->respond(200, $chat, null, 'Chat eliminado exitosamente');
        } catch (\Exception $e) {
            return $this->respond(500, [], $e->getMessage(), 'Error al eliminar Chat');
        }
    }
}
