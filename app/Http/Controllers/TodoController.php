<?php

namespace App\Http\Controllers;

use App\Model\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function getAllData(Request $request){
        if ($request->get('status') == 'All'){
            $todos = Todo::all();
            return response()->json($todos);
        }
        $todos = Todo::where('status', $request->get('status'))->get();
        return response()->json($todos);
    }

    public function save(Request $request){
//        return response()->json($request);
        $request->validate([
            'id' => 'nullable|numeric',
            'to_do' => 'required|max:255'
        ]);
        $data = $request->except('_token', 'id');
        if ($request->get('id')){
            Todo::where('id', $request->get('id'))->update($data);
        } else {
            $data['status'] = 'Active';
            Todo::create($data);
        }
        return response()->json('successful');
    }

    public function updateStatus(Request $request){
        $data['status'] = $request->get('status');
        Todo::where('id', $request->get('id'))->update($data);
        return response()->json('Status Changed');
    }

    public function delete(Request $request){
        Todo::where('status', 'Completed')->delete();
        return response()->json('successful');
    }
}
