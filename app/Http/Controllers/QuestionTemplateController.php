<?php

namespace App\Http\Controllers;

use App\Models\QuestionDraft;
use App\Models\QuestionTemplate;
use Illuminate\Http\Request;

class QuestionTemplateController extends Controller
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

        return $user->questiontemplates()->latest()->get();
    }

    public function indexdrafts()
    {
        if (auth('admin')->user()) {
            $user = auth('admin')->user();
        }
        if (auth('facilitator')->user()) {
            $user = auth('facilitator')->user();
        }

        return $user->questiondrafts()->latest()->get();
    }



    public function store(Request $request)
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



        if (is_null($request->id)) {
            return $user->questiontemplates()->create([

                'organization_id' => $user->organization_id,
                'interest' => $request->interest,
                'title' => $request->title,
                'type' => $request->type,
                'status' => 'active',
                'totalscore' => $request->totalscore,
                'sections' => json_encode($request->sections)
            ]);
        } else {
            $template =  $user->questiontemplates()->where('id', $request->id)->first();
            $template->totalscore = $request->totalscore;
            $template->sections = json_encode($request->sections);
            $template->save();
        }
    }
    public function storedraft(Request $request)
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


        if (is_null($request->id)) {
            return $user->questiontemplates()->create([
                'organization_id' => $user->organization_id,
                'interest' => $request->interest,
                'title' => $request->title,
                'type' => $request->type,
                'status' => 'draft',
                'sections' => json_encode($request->sections)
            ]);
        } else {
            $template =  $user->questiontemplates()->where('id', $request->id)->first();
            $template->sections = json_encode($request->sections);
            $template->save();
            return $template;
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QuestionTemplate  $questionTemplate
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        return QuestionTemplate::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QuestionTemplate  $questionTemplate
     * @return \Illuminate\Http\Response
     */
    public function edit(QuestionTemplate $questionTemplate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuestionTemplate  $questionTemplate
     * @return \Illuminate\Http\Response
     */
    public function makeactive(Request $request, $id)
    {
        $questionTemplate = QuestionTemplate::find($id);
        $questionTemplate->status = $request->status;
        $questionTemplate->save();
        return $questionTemplate;
    }
    public function update(Request $request, $id)
    {
        $questionTemplate = QuestionTemplate::find($id);
        $questionTemplate->title = $request->title;
        $questionTemplate->totalscore = $request->totalscore;
        $questionTemplate->type = $request->type;
        $questionTemplate->status = 'active';
        $questionTemplate->sections = json_encode($request->sections);
        $questionTemplate->save();
        return $questionTemplate;
    }
    public function updatedraft(Request $request, $id)
    {
        $questionTemplate = QuestionTemplate::find($id);
        $questionTemplate->title = $request->title;
        $questionTemplate->totalscore = $request->totalscore;
        $questionTemplate->type = $request->type;
        $questionTemplate->status = 'draft';
        $questionTemplate->sections = json_encode($request->sections);
        $questionTemplate->save();
        return $questionTemplate;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuestionTemplate  $questionTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        QuestionTemplate::find($id)->delete();
        return response()->json([
            'message' => 'Delete successful'
        ]);
    }
    public function destroydraft($id)
    {
        QuestionDraft::find($id)->delete();
        return response()->json([
            'message' => 'Delete successful'
        ]);
    }
}
