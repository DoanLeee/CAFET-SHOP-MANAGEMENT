<?php

namespace App\Http\Controllers;

use App\Http\Requests\Menu\CapNhapMenuRequest;
use App\Http\Requests\Menu\NhapMenuRequest;
use App\Models\danhmuc;
use App\Models\menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    public function index(){
        $danhmuc = danhmuc::all();
        return view('Admin.Page.Menu.index', compact('danhmuc'));

    }

    public function getDaTa(){

        $data = menu::join('danhmucs','menus.id_danh_muc', 'danhmucs.id')
                    ->select('menus.*','danhmucs.ten_danh_muc')
                    ->get();
        return response()->json([
            'data' => $data
        ]);
    }

    // -----------tinhtrangkv-------
    public function tinhtrangmenu(Request $request)
    {
        $menu = menu::find($request->id);

        if ($menu) {
            $menu->tinh_trang_m = !$menu->tinh_trang_m;
            $menu->save();

            return response()->json([
                'status'   => true,
                'message'  => 'Đã đổi trạng thái thành công! '
            ]);
        } else {
            return response()->json([
                'status'   => false,
                'message'  => 'Menu không tồn tại! '
            ]);
        }
    }

    //-----nhap----
    public function nhap(NhapMenuRequest $request){
        $data = $request->all();
        $file  = $request->file('hinh_anh');
        $ten_hinh_anh = Str::uuid() . '-' .$request->slug_mon . ' . ' . $file->getClientOriginalExtension();
        // dd($ten_hinh_anh);
        $data['hinh_anh'] = $ten_hinh_anh;
        $file -> move('hinh-mon' , $ten_hinh_anh);
        menu::create($data);
        return response()->json([
            'status' => true,
            'message'  => 'Đã tạo món mới thành công '
        ]);

        // $data = $request->all();
        // menu::create($data);
        // return response()->json([
        //     'status' => true,
        //     'message'  => 'Đã tạo bàn thành công '
        // ]);


    }

    // -------xoa----
    public function xoa(Request $request)
    {
        $menu = menu::find($request->id);
        if ($menu) {
            if ($menu) {
                $menu->delete();
                return response()->json([
                    'status' => true,
                    'message' => "Đã xoá món thành công"
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => "Món không tồn tại"
            ]);
        }
    }

    //-----cập nhập----
    public function capnhapmenu(CapNhapMenuRequest $request){
        $menu = menu::where('id', $request->id)->first();
        $data = $request->all();

        // Kiểm tra nếu có tải lên hình ảnh mới
        if ($request->hasFile('hinh_anh')) {
            $file = $request->file('hinh_anh');
            $ten_hinh_anh = Str::uuid() . '-' . $file->getClientOriginalExtension();
            $data['hinh_anh'] = $ten_hinh_anh;
            $file->move('hinh-mon', $ten_hinh_anh);
            if ($menu->hinh_anh) {
                $oldFilePath = public_path('hinh-mon/' . $menu->hinh_anh);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
        }
        $menu->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Đã cập nhật thông tin món'
        ]);
    }

    //check-slug
    public function checkslug(Request $request){
        if(isset($request->id)){
            $check = menu::where('slug_mon',$request->slug_mon)
                          ->where('id' , '<>', $request ->id)
                          ->first();
        } else {
            $check = menu::where('slug_mon',$request->slug_mon)->first();
        }

        $check = menu::where('slug_mon',$request->slug_mon)->first();
        if ($check){
            return response()->json([
                'status' => false,
                'message' => 'Món đã tồn tại'
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Tên Món có thể sử dụng '
            ]);
        }
    }
    
    //tìm kiếm của ban-hang
    public function search(Request $request){
        $data = menu::join('danhmucs','menus.id_danh_muc', 'danhmucs.id')
                      ->select('menus.*','danhmucs.ten_danh_muc')
                      ->where ('ten_mon' , 'like' , "%" . $request->timkiem . "%")
                      ->orwhere('danhmucs.ten_danh_muc' , 'like' , "%" . $request->timkiem . "%")
                      ->get();
        return response()->json([
            'data' => $data
        ]);
    }
}
