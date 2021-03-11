<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Employees;

class ControllerEmployees extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees= Employees::all()->load('types');
        $data=[
            'status'=>'success',
            'code'=>200,
            'employees'=>$employees
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
                'phone'=>'required|min:8|max:10',
                'address'=>'required|max:45',
                'types_id'=>'required|integer|max:20'
            ]);

            if(!$validate->fails()){
                $employees= new Employees();
                $employees->name= $params_array['name'];
                $employees->phone= $params_array['phone'];
                $employees->address= $params_array['address'];
                $employees->types_id= $params_array['types_id'];

                $employees->save();

                $data=[
                    'status'=>'success',
                    'code'=>200,
                    'employees'=>$employees
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
        $employees= Employees::find($id)->load('Types');
        if(is_object($employees)){
            $data=[
                'status'=>'success',
                'code'=>200,
                'employees'=>$employees
            ];
        }else{
            $data=[
                'status'=>'success',
                'code'=>400,
                'message'=>'Registro no existe'                
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
                'phone'=>'required|min:8|max:10',
                'address'=>'required|max:45',
                'types_id'=>'required|integer|max:20'
            ]);

            if(!$validate->fails()){
                $update_employees=Employees::where('id',$id)->first();
                
                if(is_null($update_employees) || !is_object($update_employees)){
                    return response()->json(array(
                        'status'=>'success',
                        'code'=>400,
                        'message'=>'Registro no existe'
                    ),400);
                }
                unset($update_employees['id']);
                unset($update_employees['created_at']);

                Employees::where('id',$id)->update($params_array);
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
        $employees=Employees::where('id',$id)->first();
        if(!is_null($employees) || !empty($employees)){
            $employees->delete();
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
