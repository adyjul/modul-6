<?php

namespace App\Http\Controllers;

use App\Models\puma;
use Illuminate\Http\Request;
use App\Http\Resources\PumaResource;
use Illuminate\Support\Facades\Validator;

class PumaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $puma = puma::all();
        return response([
            'total' => $puma->count(),
            'messages' => 'Retrieved successfuly',
            'data' => PumaResource::collection($puma)
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis' => 'max:255',
            'ukuran' => 'max:10',
            'harga' => 'max:255'
        ]);
        if ($validator -> fails()) {
            return response([
                'error' => $validator->errors(),
                'status' => 'Validation Error'
            ]);
        }
        $puma = puma::create($request->all());
        return response([
            'data' => new PumaResource($puma),
            'message' => 'Data has been created!'
        ], 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $puma = puma::find($id);
        if ($puma != null) {
            return response([
                'project' => new PumaResource($puma),
                'message' => 'Retrieved successfully'], 200);
        } else {
            return response([
                'message' => 'No data found!',], 403);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'jenis' => 'max:255',
            'ukuran' => 'max:10',
            'harga' => 'max:255'
        ]);
        if ($validator -> fails()) {
            return response([
                'error' => $validator->errors(),
                'status' => 'Validation Error'
            ]);
        }
        $puma = puma::find($id);
        if ($puma != null){
            $puma->update($request->all());
            return response([
                'data' => new PumaResource($puma),
                'message' => 'Adidas has been updated!'], 202);
        } else {
            return response([
                'message'=>'No data found!',], 403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\puma  $adidas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $puma = puma::find($id);
        if($puma != null) {
            $puma->delete();
            return response([
                'message' => 'Data has been deleted!']);
        } else {
            return response([
                'message' => 'No data found!',], 403);
        }
    }
}