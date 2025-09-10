<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Tool;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ToolsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* $obj = MaterialType::orderBy('id', 'DESC')->where('del_status', "Live")->get()->map(function ($type) {
            $usedInMaterial = RawMaterial::where('type', $type->id)->where('del_status', 'Live')->exists();
            $category->used_in_material = $usedInMaterial;
            return $category;
        }); */
        $obj = Tool::where('del_status','Live')->orderBy('id','DESC')->get();
        $title =  __('index.tools');
        $total_tools = Tool::where('del_status', "Live")->count();
        return view('pages.tools.index', compact('title', 'obj', 'total_tools'));
    }
    public function create()
    {
        $title =  __('index.add_tools');
        return view('pages.tools.add', compact('title'));
    }
    public function store(Request $request)
    {
        request()->validate([
            'tool_name' => [
                'required',
                'max:100',
                Rule::unique('tbl_tools', 'tool_name')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ],
        ], [
            'tool_name.required' => __('index.tool_name_req'),
            'tool_name.unique' => __('index.tool_name_unique'),
        ]);
        $obj = new \App\Tool();
        $obj->tool_name = ucwords(escape_output($request->get('tool_name')));
        $obj->save();
        return redirect('tools')->with(saveMessage());
    }
    public function edit($id)
    {
        $tool = Tool::find(encrypt_decrypt($id, 'decrypt'));
        $title =  __('index.edit_tools');
        $obj = $tool;
        return view('pages.tools.add', compact('title', 'obj'));
    }
     public function update(Request $request, Tool $tool)
    {
        request()->validate([
            'tool_name' => [
                'required',
                'max:100',
                Rule::unique('tbl_tools', 'tool_name')->ignore($tool->id, 'id')->where(function ($query) {
                    return $query->where('del_status', 'Live');
                }),
            ],
        ], [
            'tool_name.required' => __('index.tool_name_req'),
            'tool_name.unique' => __('index.tool_name_unique'),
        ]);

        $tool->tool_name = ucwords(escape_output($request->get('tool_name')));
        $tool->save();
        return redirect('tools')->with(updateMessage());
    }
    public function destroy(Tool $tool)
    {
        $tool->del_status = "Deleted";
        $tool->save();
        return redirect('tools')->with(deleteMessage());
    }
}
