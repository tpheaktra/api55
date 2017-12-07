<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\ProductModel;
class ProductController extends Controller
{
    private $status, $date;
    public  function  __construct(ProductModel $status)
    {

        $this->status = $status;

        date_default_timezone_set('Asia/Phnom_penh');
        $this->date = date('Y-m-d H:i:s');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $status = $this->status->get();
        return response()->json([
                    
                    'Network'=>[
                        'id'=> 1,
                        'join' => 1,

                        'info'=>[
                                'title'=>'hello',
                                'desc' =>'description'
                        ],

                        'Network_member'=>[
                            'id'=>2,
                            'favarite'=>'test',
                                'desc'=>[
                                    'presonal'=>[
                                        'year'=>2,
                                    ],
                                    'business'=>[
                                        $status
                                    ],
                                ],
                        ],

                       
                    ],
                ],200);
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
        $this->status->name        = $request->txtName;
        $this->status->description = $request->txtDescription;
        $this->status->created_at  = $this->date;
        $this->status->updated_at  = null;

        $insert = $this->status->save();
        if($insert){
            return response()->json([
                'status'=>true,
                'message'=>'data has been successful'
            ],200);
        }else{
            return response()->json([
               'status'=>false,
               'message'=>'data has been not insert'
            ],200);
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
        $id = Preg_replace('#[^0-9]#', '', $id);
        if($id != '' && !empty($id)){
            $status = $this->status->where('id', $id)->first();
            if($status){
                return response()->json([
                    'status'=>true,
                    'Data'=>$status
                ],200);
            }
        }
        return response()->json([
            'status'=>false,
            'Message'=>"Data Not Found"
        ],200);
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
    public function update(Request $request)
    {
        $id = Preg_replace('#[^0-9]#', '', $request->id);

        if($id != '' && !empty($id)){
            $update =  $this->status->where('id',$id)->first();
            if($update){
                $this->status->where('id',$id)->update([
                    'name'        => $request->txtName,
                    'description' => $request->txtDescription,
                    'updated_at'  => $this->date
                ]);
                return response()->json([
                    'status'=>true,
                    'message'=>'data has been updated successful'
                ],200);
            }
        }
        return response()->json([
            'status'=>false,
            'message'=>'data not updated successful'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = Preg_replace('#[^0-9]#', '', $id);

        if(!empty($id)){
            $delete = $this->status->where('id', $id)->update([
                'status'=>0,
            ]);
            if($delete){
                return response()->json([
                    'status'=>true,
                    'messages'=>'data delete successful',
                ],200);
            }
        }
        return response()->json([
            'status'=>flase,
            'messages'=>'data delete not successful',
        ],200);

    }
}
