<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Str;
use DB;
use League\Flysystem\Ftp\FtpAdapter;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use Intervention\Image\Facades\Image;

use App\Models\BuyerAccList;
use App\Models\BuyerAccListDetails;
class InventoryController extends Controller
{
   
public function getItemdetails($item_id){

    $item_dt=DB::table(DB::raw('ITEM_MASTER IM'))
    ->select('ITEM_ID','ITEM_NAME','IM.UNIT_ID','UM.UNIT_NAME')
    ->crossJoin(DB::raw('ITEM_CATEGORY IC'))
    ->crossJoin(DB::raw('UNIT_MEASUREMENT UM'))
    ->whereRaw('IC.CATEGORY_ID = IM.CATEGORY_ID')
    ->whereRaw('UM.UNIT_ID = IM.UNIT_ID')
    ->where('ITEM_ID', '=',$item_id)
    ->whereIn('IC.CATEGORY_ID',['IC-008',
    'IC-009',
    'IC-010'])
    ->get();
    return response()->json(
        $item_dt);
}

    public function storeget(Request $request)
    {
        $data=$request->input();
        //return response()->json($data);

        $id=DB::table('BUYER_ACCESORIES_LIST')
        ->select(DB::raw('to_char(TO_DATE(\''.$data['price_date'].'\',\'RRRR-MM-DD\'),\'MMRRRR\')
        || LPAD (NVL (MAX (TO_NUMBER (SUBSTR (ID_PK,7))), 0) + 1,
        3,
        0
        ) ID_PK'))
        ->whereRaw('to_char(PRICE_DATE,\'MMRRRR\') = to_char(TO_DATE(\''.$data['price_date'].'\',\'RRRR-MM-DD\'),\'MMRRRR\')')
        ->first();
        if($request->ajax())
        {
            
            try{
                $buyerAccList= new BuyerAccList;
                $buyerAccList->id_pk=$id->id_pk;
                $buyerAccList->buyer_id=$data['buyer_name'];
                $buyerAccList->price_date=$data['price_date'];
                $buyerAccList->save();
                return response()->json(
                    ['status2' => 200,
                    'loan_nooo' => $id->id_pk,]
                   
                );
            }catch(\Illuminate\Database\QueryException $e){
                      
                return $e;
            } 


        }
    }

public function storeitemdetails(Request $request){
$data=$request->input();
$sl=DB::table('F_STORE.BUYER_ACCESORIES_LIST_DT')
->select(DB::raw('NVL(MAX(TO_NUMBER(SLNO)),0)+1 SLNO'))
->where('ID_PK','=',$data['id_pk'])
->first();
$item_name=str_replace(array("\r" ,"\n",' '), '',preg_replace("/\([^)]+\)/","", $data['item_name']));
$filenamewithextension =$request->file('image')->getClientOriginalName();
 
        //     //get filename without extension
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

        //get file extension
        $extension = $request->file('image')->getClientOriginalExtension();

        //     //filename to store
        $filenametostore = $data['id_pk'].'_'.$sl->slno.'.'.$extension;
        Storage::disk('ftp2')->put('accimage/'.$filenametostore, fopen( $request->file('image'), 'r+'));

        

try{
    $buyerAccList= new BuyerAccListDetails;
    $buyerAccList->id_pk= $data['id_pk'];
    $buyerAccList->slno= $sl->slno;
    $buyerAccList->item_id= $data['item_id'];
    $buyerAccList->price= $data['price'];
    $buyerAccList->item_unit= $data['item_unit'];
    $buyerAccList->supplier_id= $data['party_id'];
    $buyerAccList->image_loc= $filenametostore;
    //$buyerAccList->buyer_id='1';
    //$buyerAccList->price_date=$data['price_date'];
    $buyerAccList->save();
    return response()->json(
        ['success' => 'success',$item_name]
       
    );
}catch(\Illuminate\Database\QueryException $e){
                      
    return $e;
} 


   

    



    // if($request->hasFile('profile_image')) {
    //     //$directory = Storage::disk('ftp')->files('demo');

    //     //get filename with extension
    //     $filenamewithextension = $request->file('profile_image')->getClientOriginalName();
 
    //     //get filename without extension
    //     $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
 
    //     //get file extension
    //     $extension = $request->file('profile_image')->getClientOriginalExtension();
 
    //     //filename to store
    //     $filenametostore = $filename.'_'.uniqid().'.'.$extension;
    //     return          $filenametostore;     
        
    //  // return  Storage::disk('ftp')->put($filenametostore, fopen($request->file('profile_image'), 'r+'));

    //     //Upload File to external server
    //     Storage::disk('ftp')->put($filenametostore, fopen($request->file('profile_image'), 'r+'));
 
    //     //Store $filenametostore in the database
    // }

    // return redirect('file')->with('success', "Image uploaded successfully.");
}

public function getItemlist($id_pk){
    $base_url='http://192.168.189.205:81/accimage/';
    $itemList=DB::table('BUYER_ACCESORIES_LIST_DT')
    ->select('ID_PK', 'ITEM_ID',DB::raw('COM.GET_ITEM_NAME(ITEM_ID) ITEM_NAME'),'slno', 'ITEM_UNIT', 'PRICE', 'SUPPLIER_ID',DB::raw('COM.GET_PARTY_NAME(SUPPLIER_ID) PARTY_NAME'), DB::raw('\''.$base_url.'\'||IMAGE_LOC IMAGE_LOC'))
    ->where('ID_PK','=',$id_pk)
    ->get();
//dd($itemList);
    return view('inv.accfilelis',['itemList'=>$itemList]);

}
public function getItemfind(){
    $base_url='http://192.168.189.205:81';
    $itemList=DB::table(DB::raw('BUYER_ACCESORIES_LIST BAL'))
    ->select('BAL.ID_PK',DB::raw('COM.GET_PARTY_NAME(BUYER_ID) BUYER_NAME'))
    ->get();
//dd($itemList);
    return view('inv.accfilelist',['itemList'=>$itemList]);

}
public function pdfview($id_pk){
 $link='http://192.168.189.205:8090/jri/report?_repName=buyer_acc_list&_repFormat=pdf&_dataSource=default&P_ID_PK='.$id_pk.'&_outFilename=&_repLocale=&_repEncoding=&_repTimeZone=&_printIsEnabled=&_printPrinterName=&_printJobName=&_printPrinterTray=&_printCopies=&_printDuplex=&_printCollate=&_saveIsEnabled=&_saveFileName=';
 // dd($link);
 
 
 return view('pdf',compact('link'));

}

public function  getItemFull($id_pk){
    $list=DB::table('BUYER_ACCESORIES_LIST')
    ->select('BUYER_ACCESORIES_LIST.ID_PK','BUYER_ID', DB::raw("COM.GET_PARTY_NAME(BUYER_ID) as BUYER_NAME"), DB::raw("TO_CHAR(PRICE_DATE, 'YYYY-MM-DD') as PRICE_DATE"))
    ->where('BUYER_ACCESORIES_LIST.ID_PK','=',$id_pk)
    ->get();
    return response()->json($list);
    dd($list);

}
    public function  buyAccList(){
       
        if (!session('LoggedId') == null) {

          //  return (session('LoggedId'));
            $item_dt=DB::table(DB::raw('ITEM_MASTER IM'))
            ->select('ITEM_ID','ITEM_NAME','IM.UNIT_ID','UM.UNIT_NAME')
            ->crossJoin(DB::raw('ITEM_CATEGORY IC'))
            ->crossJoin(DB::raw('UNIT_MEASUREMENT UM'))
            ->whereRaw('IC.CATEGORY_ID = IM.CATEGORY_ID')
            ->whereRaw('UM.UNIT_ID = IM.UNIT_ID')
            ->whereIn('IC.CATEGORY_ID',['IC-008',
            'IC-009',
            'IC-010'
            ])
            ->get();
    $supllyer=DB::table('PARTY_PROFILE')
    ->select('PARTY_ID','PARTY_NAME')
    ->where('PARTY_TYEP','=','Supplier')
    ->get();
                $buyerName=DB::table('PARTY_PROFILE')
                ->where([['PARTY_TYEP','Buyer'],['COMPANY_ID','100']])
                ->get();
    
    //dd($item_dt);
    return view('inv.buyWiseAccList',['buyerName'=>$buyerName,'item_dt'=>$item_dt,'supllyer'=>$supllyer]);



        }else{
            return redirect('login');
        }

       
    }

    public function getImageName(Request $request){
        $data=$request->input();

$getImageName=DB::table('BUYER_ACCESORIES_LIST_DT')
->select('IMAGE_LOC')
->where('ID_PK','=',$data['first'])
->where('SLNO','=',$data['id'])
->first();
//return $getImageName->image_loc;
if(Storage::disk('ftp2')->exists('accimage/'.$getImageName->image_loc)){
    Storage::disk('ftp2')->delete('accimage/'.$getImageName->image_loc);
    //dd('ok');

}else{
    dd('error');
}
    }
}