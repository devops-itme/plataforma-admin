<?php

namespace App\Modules\UserModule\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ParameterValueModule\ParameterValue;
use App\Modules\UserModule\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Modules\DocumentModule\Document;

class ProfileController extends Controller
{
    use ProfileTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $path = 'UserModule.views.html.profile.';
    public function index()
    {
        $user = User::find(Auth::user()->id);
        $documents = ParameterValue::with('getParameter')->whereHas('getParameter', function ($query) {
            $query->where('name', 'document_type');
        })->get();

        $profile_photo = Document::where('user_id',Auth::user()->id)->where('data','')->get();
        $wordCount = $profile_photo->isEmpty();


        return view($this->path.'index', compact('user', 'documents','profile_photo','wordCount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->name){
            $response = $this->updateGeneralData($request);
        }
        if($request->password){
            $response = $this->updatePassword($request);
        }
        if($response['state'] == 200){
            return redirect()->route('profile.index')->with('success', $response['message']);
        } else {
            return redirect()->back()->withInput()->with('danger', $response['message']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function update(Request $request, $id){
         //
    }

    public function imageUploadPost(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = time().'.'.$request->image->extension();

        $path = Storage::disk('s3')->put('images', $request->image);
        $path = Storage::disk('s3')->url($path);


        $DocumentModule = new Document();
        $DocumentModule->saveDocument(new Request(array(
            'user_id' => Auth::user()->id,
            'url' => $path,
            'data' => '',
            'active' => 1,
        )));
        /* Store $imageName name in DATABASE from HERE */

        return back()
            ->with('success','Se ha Subido su foto de perfil satisfactoriamente.')
            ->with('image', $path);
    }

    public function imageUpdatePost(Request $request)
    {

        $id_document = Document::select('id')
        ->where('user_id',Auth::user()->id)
        ->where('data','')
        ->get();

        foreach ($id_document as $doc) {
            $id = $doc->id;
        }
        // dd($id);

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = time().'.'.$request->image->extension();

        $path = Storage::disk('s3')->put('images', $request->image);
        $path = Storage::disk('s3')->url($path);


        $DocumentModule = new Document();
        $DocumentModule->updateDocument(new Request(array(
            'user_id' => Auth::user()->id,
            'url' => $path,
            'data' => '',
            'active' => 1,
        )),$id);
        /* Store $imageName name in DATABASE from HERE */

        return back()
            ->with('success','Se ha actualizado su foto de perfil satisfactoriamente.')
            ->with('image', $path);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
