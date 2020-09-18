<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Option;

class OptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all = Option::all();
        $groups = $all->where('parent_id', null);
        $options = $all->where('parent_id', '<>', null);
        $types = Option::TYPE;
        return view('admin_def.pages.option_index', compact('groups', 'options', 'types'));
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
        $validator = \Validator::make($request->all() ,[
            'key' => 'required|string|unique:options,key',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $request['parent_id'] = $request->option_group;
        $option = Option::create($request->all());
        if ($option) {
            return redirect()->route('admin.option.index');
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
    public function edit()
    {
        $all = Option::all();
        $groups = $all->where('parent_id', null);
        $options = $all->whereNotIn('type', [1, 2]);
        $items = $all->where('type', 2);
        $types = Option::TYPE;
        return view('admin_def.pages.option_edit', compact('groups', 'options', 'items', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $all = Option::whereNotIn('type', [1, 2])->get();
        $options = $all->mapWithKeys(function($item) {
            if ($item->type == Option::TYPE['checkbox']) {
                $item->value = json_encode($item->value);
            }
            return [$item->key => $item->value];
        });
        $req = $request->option;
        foreach ($req as $key => $value) {
            if (is_array($value)) {
                $req[$key] = json_encode($value);
            }
        }
        $changes = array_diff($req, $options->all());
        $change_flag = false;
        foreach ($changes as $key => $value) {
            $option = Option::where('key', $key)->firstOrFail();
            $change_flag = $option->update([
                'value' => $value,
            ]);
        }

        if ($change_flag) {
            return redirect()->route('admin.option.index');
        } else {
            return redirect()->back();
        }
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

    public function alter($id)
    {
        $option = Option::find($id);
        $items = Option::where('parent_id', $id)->get();
        $types = Option::TYPE;
        unset($types['group']);
        return view('admin_def.pages.option_alter', compact('option', 'items', 'types'));
    }

    public function save(Request $request, $id)
    {
        $req = $request->all();
        if (isset($req['new'])) {
            foreach ($req['new'] as $item) {
                $new_flag = Option::create([
                    'key' => $item['value'],
                    'value' => $item['title'],
                    'parent_id' => $id,
                    'type' => Option::TYPE['item'],
                ]);
            }
        }

        if ($new_flag) {
            return redirect()->route('admin.option.index');
        }
    }
}
