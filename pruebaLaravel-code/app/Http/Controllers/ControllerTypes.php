<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Types;
use Illuminate\Support\Facades\Validator;

class ControllerTypes extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types= Types::all();
        $data=[
            'status'=>'success',
            'code'=>200,
            'types'=>$types
        ];
        return response()->json($data ,$data['code']);
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
        $json= $request->input('data',null);
        $params_array= json_decode($json,true);
        
        if(!empty($params_array)){
            
            $validate= Validator::make($params_array,[
                'name'=>'required|min:3|max:45'
            ]);

            if(!$validate->fails()){
                $type= new Types();
                $type->name= $params_array['name'];
                $type->save();

                $data=[
                    'status'=>'success',
                    'code'=>200,
                    'types'=>$type
                ];
            }else{
                $data=[
                    'status'=>'error',
                    'code'=>400,
                    'errors'=>$validate->errors()
                ];
            }
        }else{
            $data=[
                'status'=>'error',
                'code'=>400,
                'message'=>'Datos incorrectos'
            ];            
        }

        return response()->json($data,$data['code']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $type= Types::find($id);
        if(!is_null($type)){
            $data=[
                'status'=>'success',
                'code'=>200,
                'types'=>$type
            ];  
        }else{
            $data=[
                'status'=>'success',
                'code'=>400,
                'message'=>'Registro no existe'
            ];      
        }

        return response()->json($data,$data['code']);
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
    public function update($id,Request $request)
    {
        $json= $request->input('data',null);
        $params_array= json_decode($json,true);
        if(!empty($params_array)){
            $validate= Validator::make($params_array,[
                'name'=>'required|min:3|max:45'
            ]);
            
            if(!$validate->fails()){
                unset($params_array['id']);
                $update_type=Types::where('id',$id)->first();
                
                if(is_null($update_type) || !is_object($update_type)){
                    return response()->json(array(
                        'status'=>'success',
                        'code'=>400,
                        'message'=>'Registro no existe'
                    ),400);
                }
                $type=Types::where('id',$id)->update($params_array);

                $data=[
                    'status'=>'success',
                    'code'=>200,
                    'message'=>"Registro Actualizado"
                ];
            }else{
                $data=[
                    'status'=>'error',
                    'code'=>400,
                    'errors'=>$validate->errors()
                ];
            }
        }else{
            $data=[
                'status'=>'error',
                'code'=>400,
                'message'=>'Datos incorrectos'
            ];            
        }

        return response()->json($data,$data['code']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type=Types::where('id',$id)->first();
        if(!is_null($type) || !empty($type)){
            $type->delete();
            $data=[
                'status'=>'success',
                'code'=>200,
                'message'=>'Registro eliminado'
            ];              
        }else{
            $data=[
                'status'=>'error',
                'code'=>400,
                'message'=>'El registro no existe'
            ];  
        }
        return response()->json($data,$data['code']);
    }
}
