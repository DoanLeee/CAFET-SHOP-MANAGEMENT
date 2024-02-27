<?php

namespace App\Http\Controllers;

use App\Http\Requests\DanhMuc\CapNhapDanhMucRequest;
use App\Http\Requests\DanhMuc\NhapDanhMucRequest;
use App\Models\danhmuc;
use Illuminate\Http\Request;

class DanhMucController extends Controller
{
    public function index(){
        return view('Admin.Page.DanhMuc.index');
    }

    public function getDaTa()
    {
        $data = danhmuc::get();
        return response()->json([
            'data' => $data
        ]);
    }

    //---------nhap---------
    public function nhap(NhapDanhMucRequest $request)
    {
        $data = $request->all();
        danhmuc::create($data);

        return response()->json([
            'status' => true,
            'message'  => 'Đã tạo khu vực mới thành công '
        ]);
    }

    //-----------tinhtrangdanhmuc-------
    public function tinhtrangdanhmuc(Request $request)
    {
        $danhmuc = danhmuc::find($request->id);

        if ($danhmuc) {
            $danhmuc->tinh_trang_dm = !$danhmuc->tinh_trang_dm;
            $danhmuc->save();

            return response()->json([
                'status'   => true,
                'message'  => 'Đã đổi trạng thái thành công! '
            ]);
        } else {
            return response()->json([
                'status'   => false,
                'message'  => 'Danh Muc không tồn tại! '
            ]);
        }
    }

    public function xoa(Request $request)
    {
        $danhmuc =danhmuc::find($request->id);
        if ($danhmuc) {
            $danhmuc->delete();
            return response()->json([
                'status'   => true,
                'message'  => 'Đã xóa danh mục thành công !'
            ]);
        } else {
            return response()->json([
                'status'   => false,
                'message'  => 'Danh mục không tồn tại! '
            ]);
        }
        // $danhmuc = danhmuc::find($request->id);

        // if($danhmuc) {
        //     $menu = menu::where('id_khu_vuc', $request->id)->first();

        //     if($menu) {
        //         return response()->json([
        //             'status'    => 2,
        //             'message'   => 'Khu vực này đang có bàn, bạn không thể xóa!'
        //         ]);
        //     } else {
        //         $danhmuc->delete();

        //         return response()->json([
        //             'status'    => true,
        //             'message'   => 'Đã xóa khu vực thành công!'
        //         ]);
        //     }
        // } else {
        //     return response()->json([
        //         'status'    => false,
        //         'message'   => 'Khu vực không tồn tại!'
        //     ]);
        // }
    }

    //----cập nhập----
    public function capnhapdanhmuc(CapNhapDanhMucRequest $request)
    {
        $danhmuc = danhmuc::where('id', $request->id)->first();
        $data = $request->all();
        $danhmuc->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Đã cập nhập được danh mục'
        ]);
    }

    //------check-slug-----
    public function checkslug(Request $request)
    {
        if (isset($request->id)) {
            $check = danhmuc::where('slug_danh_muc', $request->slug_danh_muc)
                ->where('id', '<>', $request->id)
                ->first();
        } else {
            $check = danhmuc::where('slug_danh_muc', $request->slug_danh_muc)->first();
        }

        $check = danhmuc::where('slug_danh_muc', $request->slug_danh_muc)->first();
        if ($check) {
            return response()->json([
                'status' => false,
                'message' => 'Tên danh mục đã tồn tại'
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Tên danh mục có thể sử dụng '
            ]);
        }
    }

}
