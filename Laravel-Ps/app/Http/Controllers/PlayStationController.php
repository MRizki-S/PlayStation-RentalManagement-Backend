<?php

namespace App\Http\Controllers;

use App\Models\PlayStation;
use Illuminate\Http\Request;

class PlayStationController extends Controller
{
    public function index() {
        $playStationAll = PlayStation::all();

        if($playStationAll) {
            return response()->json($playStationAll);
        }
    }
    public function store(Request $request) {
        $request->validate([
            'ps_code' => ['required', 'max:10', 'unique:playstation'],
            'name' => ['required'],
            'price_perjam' => ['required'],
        ]);


        // dd($request->all());
        $request['status'] = 'inactive';
        // dd($request['status']);
        $playStationStore = PlayStation::create($request->all());

        if($playStationStore) {
            return response()->json([
                'addData' => $playStationStore,
                'message' => 'Data berhasil ditambahkan'
            ],200);
        }
    }
    public function update(Request $request, $id) {
        $request->validate([
            'ps_code' => ['required'],
            'name' => ['required'],
            'price_perjam' => ['required'],
        ]);

        // dd($request->all());

        $playStationUpdate = PlayStation::findOrFail($id);
        $playStationUpdate->update($request->all());

        if($playStationUpdate) {
            return response()->json([
                'EditData' => $request->all(),
                'message' => 'Data berhasil Di Update!'
            ], 200);
        }else {
            return response()->json([
                'message' => 'data gagal ',
            ], 500
            );
        }
    }
    public function delete($id) {
        $playStationDelete = PlayStation::findOrFail($id);
        $playStationDelete->delete();

        if($playStationDelete) {
            return response()->json([
                'deleteData' => $playStationDelete,
                'message' => 'Data berhasil Dihapus'
            ], 200);
        }
    }
}
