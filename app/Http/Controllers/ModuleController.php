<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth('admin')->user()) {
            $user = auth('admin')->user();
        }
        if (auth('facilitator')->user()) {
            $user = auth('facilitator')->user();
        }
        if (auth('api')->user()) {
            $user = auth('api')->user();
        }
        return Module::where('organization_id', $user->organization_id)->with('course', 'questionnaire')->latest()->get();
    }

    public function store(Request $request)
    {
        if (auth('admin')->user()) {
            $user = auth('admin')->user();
        }
        if (auth('facilitator')->user()) {
            $user = auth('facilitator')->user();
        }


        return $user->module()->create([

            'module' => $request->module,
            'cover_image' => $request->cover_image,
            'modules' => json_encode($request->modules),
            'course_id' => $request->course_id,
            'organization_id' => $user->organization_id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function show(Module $module)
    {
        return $module;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Module $module)
    {

        $module->cover_image = $request->cover_image;
        $module->modules = json_encode($request->modules);
        $module->save();
        return $module->load('course');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function destroy(Module $module)
    {
        $module->delete();
        return response()->json([
            'message' => 'Delete successful'
        ]);
    }
}
