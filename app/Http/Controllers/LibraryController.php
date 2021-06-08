<?php

namespace App\Http\Controllers;

use App\Http\Resources\LibraryResource;
use App\Http\Resources\SingleLibraryResource;
use App\Models\Library;
use Illuminate\Http\Request;

class LibraryController extends Controller
{

    public function index()
    {
        $user  = auth('api')->user();
        return  LibraryResource::collection(Library::where('user_id', $user->id)->get());
    }

    public function store(Request $request)
    {
        $user  = auth('api')->user();
        return $user->library()->create([
            'course_id' => $request->course_id
        ]);
    }

    public function show($id)
    {
        $user  = auth('api')->user();
        $library = Library::where('user_id', $user->id)->where('course_id', $id)->first();
        return new SingleLibraryResource($library);
    }

    public function updateprogress(Request $request)
    {
        $find = Library::where('course_id', $request->id)->first();

        if (is_null($find->current_module) ||  $find->current_module < $request->current_module) {

            $find->current_module = $request->current_module;
            $find->total_modules = $request->total_modules;
            $find->progress = ($request->current_module / $request->total_modules)  * 100;
        }
        $find->save();
        return $find;
    }


    public function update(Request $request, Library $library)
    {
        //
    }

    public function destroy(Library $library)
    {
        $library->delete();
        return response()->json([
            'message' => 'Delete successful'
        ]);
    }
}
