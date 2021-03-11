<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Childrens;
use Illuminate\Support\Facades\Validator;

class ControllerChildrens extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $childrens= Childrens::all()->load('Employees');
        $data=[
            'status'=>'success',
            'code'=>200,
            'contracts'=>$childrens
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
                'name'=>'required|min:3|max:45',
                'age'=>'required|integer|max:11',
                'employees_id'=>'required|integer'
            ]);

            if(!$validate->fails()){
                $childrens= new Childrens();
                $childrens->name= $params_array['name'];
                $childrens->age= $params_array['age'];
                $childrens->employees_id= $params_array['employees_id'];

                $childrens->save();

                $data=[
                    'status'=>'success',
                    'code'=>200,
                    'contracts'=>$childrens
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
        $childrens= Childrens::find($id)->load('employees');
        if(!is_null($childrens)){
            $data=[
                'status'=>'success',
                'code'=>200,
                'employees'=>$childrens
            ];      
        }else{
            $data=[
                'status'=>'error',
                'code'=>400,
                'message'=>'El registro no existe'
            ];  
        }

        return response()->json($data ,$data['code']);
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
    public function update(Request $request, $id)
    {
        $json= $request->input('data',null);
        $params_array= json_decode($json,true);
        
        if(!empty($params_array)){
            
            $validate= Validator::make($params_array,[
                'name'=>'required|min:3|max:45',
                'age'=>'required|integer|max:11',
                'employees_id'=>'required|integer|max:20'
            ]);

            if(!$validate->fails()){
                $update_childrens=Childrens::where('id',$id)->first();
                
                if(is_null($update_childrens) || !is_object($update_childrens)){
                    return response()->json(array(
                        'status'=>'success',
                        'code'=>400,
                        'message'=>'Registro no existe'
                    ),400);
                }
                unset($update_employees['id']);
                unset($update_employees['created_at']);

                $childrens= Childrens::where('id',$id)->updated($params_array);

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
        $childrens=Childrens::where('id',$id)->first();
        if(!is_null($childrens) || !empty($childrens)){
            $childrens->delete();
            $data=[
                'status'=>'success',
                'code'=>200,
                'message'=>'Registro eliminado'
            ];              
        }else{
            $data=[
                'status'=>'error',
                'code'=>400,
                'message'=>'Elemento no existe'
            ];  
        }
        return response()->json($data,$data['code']);
    }
}
