<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contracts;
use Illuminate\Support\Facades\Validator;

class ControllerContracts extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contracts= Contracts::all()->load('employees');
        $data=[
            'status'=>'success',
            'code'=>200,
            'contracts'=>$contracts
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
                'date'=>'required|date',
                'file'=>'required|max:45',
                'employees_id'=>'required|integer|max:20'
            ]);

            if(!$validate->fails()){
                $contracts= new Contracts();
                $contracts->name= $params_array['name'];
                $contracts->date= $params_array['date'];
                $contracts->file= $params_array['file'];
                $contracts->employees_id= $params_array['employees_id'];

                $contracts->save();

                $data=[
                    'status'=>'success',
                    'code'=>200,
                    'contracts'=>$contracts
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
        $contract= Contracts::find($id)->load('Employees');
        if(is_object($contract)){
            $data=[
                'status'=>'success',
                'code'=>200,
                'employees'=>$contract
            ];
        }else{
            $data=[
                'status'=>'error',
                'code'=>400,
                'message'=>'Elemento no existe'
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
                'date'=>'required|date',
                'file'=>'required|max:45',
                'employees_id'=>'required|integer|max:20'
            ]);

            if(!$validate->fails()){
                $update_contracts=Contracts::where('id',$id)->first();
                
                if(is_null($update_contracts) || !is_object($update_contracts)){
                    return response()->json(array(
                        'status'=>'success',
                        'code'=>400,
                        'message'=>'Registro no existe'
                    ),400);
                }
                unset($update_employees['id']);
                unset($update_employees['created_at']);
                $contracts= Contracts::where('id',$id)->update($params_array);

                $data=[
                    'status'=>'success',
                    'code'=>200,
                    'message'=>'Registro Actualizado'
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
        $contracts=Contracts::where('id',$id)->first();
        if(!is_null($contracts) || !empty($contracts)){
            $contracts->delete();
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
