<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $code_url = request()->segment(1);
        $this->data['menu'] = $code_url;

        return view('product', $this->data);
    }

    public function getDatatables(Request $request)
    {
        // dd($request);
        url('/');
        $data = Product::orderBy('created_at', 'DESC')
                    // ->with('consultingService')
                    // ->when($request->consulting_service_id, function ($query, $consulting_service_id) {
                    //     return $query->where('consulting_service_id', $consulting_service_id);
                    // })
                    // ->when($request->date, function ($query, $date) {
                    //     return $query->where('createdAt', 'like', "%" . eKreative::dateFormatDB($date) . "%");
                    // })
                    // ->when(!is_null($request->published_status), function ($query) use ($request){
                    //     return $query->where('published_status', $request->published_status);
                    // })  
                    ->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function($data) {
                return '
                    <a href="'.url('/product/edit/'.$data->id).'" class="btn btn-icon btn-xs"><i class="fas fa-edit"></i></a>
                    <button type="button" class="btn btn-icon btn-xs" id="btnDelete" title="Delete" data-bs-toggle="modal" data-bs-target="#modalDelete" data-id="'.$data->id.'"><i class="fas fa-trash-alt"></i></button>';
            })
            ->rawColumns(['actions','deskripsi'])
            ->make(true);
    }

    public function add()
    {
        $code_url = request()->segment(1);
        $this->data['menu'] = $code_url;

        return view('product-add', $this->data);
    }

    public function edit($id)
    {
        $code_url = request()->segment(1);
        $this->data['menu'] = $code_url;

        $this->data['data'] = Product::find($id);

        return view('product-edit', $this->data);
    }

    public function store(Request $request){
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(),[
                'nama' => 'required',
                'deskripsi' => 'required',
                'harga' => 'required',
                'status' => 'required',
                // 'file' => 'required|image|mimes:jpeg,png,jpg,|max:2048',
            ]);
            if(!$validator->passes()){
                return response()->json(['metaData' => ['code' => 403, 'message' => $validator->errors()]], 200);
            }

            // $request['image'] = eKreative::uploadImage(self::IMAGE_PATH,$request['file']);
            // $request['createdBy'] = Auth::user()->id;
            // $request['updatedBy'] = Auth::user()->id;

            $result = Product::create($request->all());
            DB::commit();
            return response()->json(['metaData' => ['code' => 200, 'message' => 'Data berhasil disimpan.'], 'response' => $result], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['metaData' => ['code' => 500, 'message' => $e->getMessage()]], 200);
        }
    }

    public function update(Request $request){
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(),[
                'nama' => 'required',
                'deskripsi' => 'required',
                'harga' => 'required',
                'status' => 'required',
                // 'file' => 'required|image|mimes:jpeg,png,jpg,|max:2048',
            ]);
            if(!$validator->passes()){
                return response()->json(['metaData' => ['code' => 403, 'message' => $validator->errors()]], 200);
            }

            $result = Product::find($request->id);
            $result->nama = $request->nama;
            $result->deskripsi = $request->deskripsi;
            $result->harga = $request->harga;
            $result->status = $request->status;
            $result->save();

            // $request['image'] = eKreative::uploadImage(self::IMAGE_PATH,$request['file']);
            // $request['createdBy'] = Auth::user()->id;
            // $request['updatedBy'] = Auth::user()->id;

            DB::commit();
            return response()->json(['metaData' => ['code' => 200, 'message' => 'Data berhasil disimpan.'], 'response' => $result], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['metaData' => ['code' => 500, 'message' => $e->getMessage()]], 200);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $result = Product::find($id);
            // $result->updatedBy = Auth::user()->id;
            $result->delete();

            DB::commit();
            return response()->json(['metaData' => ['code' => 200, 'message' => 'Data berhasil dihapus.'], 'response' => $result], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['metaData' => ['code' => 500, 'message' => $e->getMessage()]], 200);
        }
    }
}
