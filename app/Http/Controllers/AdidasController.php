<?php

namespace App\Http\Controllers;

use App\Models\adidas;
use Illuminate\Http\Request;
use App\Http\Resources\AdidasResource;
use Illuminate\Support\Facades\Validator;

class AdidasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $adidas = Adidas::all();
        return response([
            'total' => $adidas->count(),
            'messages' => 'Retrieved successfuly',
            'data' => AdidasResource::collection($adidas)
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
        $adidas = Adidas::create($request->all());
        return response([
            'data' => new AdidasResource($adidas),
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
        $adidas = Adidas::find($id);
        if ($adidas != null) {
            return response([
                'project' => new AdidasResource($adidas),
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
        $adidas = Adidas::find($id);
        if ($adidas != null){
            $adidas->update($request->all());
            return response([
                'data' => new AdidasResource($adidas),
                'message' => 'Adidas has been updated!'], 202);
        } else {
            return response([
                'message'=>'No data found!',], 403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Adidas  $adidas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $adidas = Adidas::find($id);
        if($adidas != null) {
            $adidas->delete();
            return response([
                'message' => 'Data has been deleted!']);
        } else {
            return response([
                'message' => 'No data found!',], 403);
        }
    }
}