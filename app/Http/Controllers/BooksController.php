<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Books ; 
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use App\Models\Categories ; 


class BooksController extends Controller
{
   
    public function index( Request $request)
    {
        $categories = Categories::get();
 
     
 
         if ($request->ajax()) 
        {
            $data = Books::with('categories')->select('*') ;
            return DataTables::of($data)
                    ->addIndexColumn()
                    
                    ->filter(function ($instance) use ($request) {
                    //     if (!empty($request->get('type_order'))  ) {
                    //         $instance->where('type_order', $request->get('type_order'));
                    //     }
                    //    if (!empty($request->get('search')) ) { 
                    //       $search =$request->get('search');
                    //      $instance->where('code','like' , "%$search%");
                    //    }
                    if (!empty($request->get('category')) && $request->get('category') <> -1 ) {
                        $instance->where('category_id', $request->get('category'));
                    }
                       })
                     ->addColumn('action', function ($data) {
                        return '
                     

                                    <button type="button"  class="btn btn-xs btn" 
                                         data-name="'.$data->name.'" 
                                         data-author="'.$data->author.'" 
                                         data-date="'.$data->date_of_publication.'" 
                                         data-category="'.$data->category_id.'"  
                                         data-details="'.$data->details.'"  
                                         data-price="'.$data->price.'"      
                                         data-id="'.$data->id.'"         
                                        id="form-edit" data-bs-toggle="modal" data-bs-target="#modelUpdateBooks"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                                        <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"/>
                                    </svg></a>
                       
                                    <button name="bstable-actions" class="deleteRecord btn btn-xs btn show_confirm"    data-id="'.$data->id.'" > <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                  </svg> </button>
                                  
                            ';
                        
                      })
                    ->addColumn('name' , function ($data){
                        $url=asset("/storage/uploads/images/$data->image"); 
                        return ' 
                        <div class="d-flex align-items-center">
                            <!--begin::Thumbnail-->
                            <a href="" class="symbol symbol-50px">
                                <span class="symbol-label" style="background-image:url('.$url.');"></span>
                            </a>
                            <!--end::Thumbnail-->
                            <div class="ms-5">
                                <!--begin::Title-->
                                <a href="" class="text-gray-800 text-hover-primary fs-5 fw-bolder" data-kt-ecommerce-product-filter="product_name">'.$data->name.'</a>
                                <!--end::Title-->
                            </div>
                        </div>
              
                   ' ; 
                    })  
                    ->addColumn('create', function ($data) {  
                        return  date('d M Y', strtotime($data->created_at)); 
 
                    })
                    ->addColumn('category_id', function ($data) {  
                        return   $data->categories->name  ;

                    })
                    ->rawColumns(['create' , 'name' , 'action'  , 'category_id'])
                    ->make(true);
        }
      
        return view('Books.book' , ['categories'=> $categories ]);
    }

    public function store(Request $request)
    {

           $validator = Validator::make($request->all(), 
        [    
            'name' => 'required|string|max:255',
            'author' => 'required',
            'category_id' => 'required',
            'date' => 'required',
            'details' => 'required',
            'price' => 'required|integer',
            'image' => 'required',
        ]);
        if ($validator->fails()) 
        {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422); 
        }
        $image = $request->file('image') ; 
        $path = 'uploads/images/';
        $nameImage = time()+rand(1,10000000).'.'.$image->getClientOriginalExtension();
        Storage::disk('public')->put($path.$nameImage, file_get_contents( $image ));
 
        $createBooks = Books::create(
            ['name' => $request['name'] , 
             'image' => $nameImage   ,
             'author' => $request['author'] , 
             'category_id' => $request['category_id'] , 
             'date_of_publication' => $request['date'] , 
             'details'=> $request['details']  , 
             'price' => $request['price'] 
        ]);

        if($createBooks->save())
        {
                return response()->json([
                    'success' =>  "successfully insert data category ",
                ], 200); 
            
        }
    }
  
    public function dataAjaxDeviceDropdown(Request $request)
       {
          $data = [];
            if($request->has('q')){
               $search = $request->q;
               $data =Categories::select("id","name")
                   ->where('name','LIKE',"%$search%")
                   ->get();
           }
            return response()->json($data);
       }
  public function update(Request $request)
    {
        $id = $request['id'] ; 
        $rowBook =  books::find($id); 
        $image = $request->file('image') ;
        $request_data = $request->except(['image'  , 'date']);
 
      
         if(isset($image))
          {
                $path = 'uploads/images/';
                $name_image = time()+rand(1,10000000).'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->put($path.$name_image, file_get_contents( $image ));
                $rowBook->image =$name_image ;
                
          } 
          $rowBook->fill($request_data);
          $updateOP =  $rowBook->update() ;
                if($updateOP)
                {
                return response()->json([
                    'success' => 'Record updated  successfully!'
                ]);
                }else
                {
                return response()->json([
                'errpr ' => 'Record updated falid!'
                ]);
            }
    }
    public function delete($id)
    {
        $deleteRow =  Books::find($id)->delete($id);
        if($deleteRow)
        {
          return response()->json([
              'success' => 'Record deleted successfully!'
          ]);
         }else
         {
          return response()->json([
            'error ' => 'Record deleted falid!'
          ]);    
        }
    }



}
