<?php

namespace App\Http\Controllers;

use App\Http\Requests\KhuVuc\CapNhapKhuVucRequest;
use App\Http\Requests\KhuVuc\NhapKhuVucRequest;
use App\Models\ban;
use App\Models\khuvuc;
use Illuminate\Http\Request;

class KhuVucController extends Controller
{
    public function index(){
        return view('Admin.Page.KhuVuc.index');
    }

    public function getDaTa()
    {
        $data = khuvuc::get();
        return response()->json([
            'data' => $data
        ]);
    }

    //---------nhap---------
    public function nhap(NhapKhuVucRequest $request)
    {
        $data = $request->all();
        khuvuc::create($data);

        return response()->json([
            'status' => true,
            'message'  => 'Đã tạo khu vực mới thành công '
        ]);
    }

    //-----------tinhtrangkv-------
    public function tinhtrangkv(Request $request)
    {
        $khuvuc = khuvuc::find($request->id);

        if ($khuvuc) {
            $khuvuc->tinh_trang_kv = !$khuvuc->tinh_trang_kv;
            $khuvuc->save();

            return response()->json([
                'status'   => true,
                'message'  => 'Đã đổi trạng thái thành công! '
            ]);
        } else {
            return response()->json([
                'status'   => false,
                'message'  => 'Khu vực không tồn tại! '
            ]);
        }
    }

    public function xoa(Request $request)
    {
        // $khuvuc =khuvuc::find($request->id);
        // if ($khuvuc) {
        //     $khuvuc->delete();
        //     return response()->json([
        //         'status'   => true,
        //         'message'  => 'Đã xóa khu vực thành công !'
        //     ]);
        // } else {
        //     return response()->json([
        //         'status'   => false,
        //         'message'  => 'Khu vực không tồn tại! '
        //     ]);
        // }
        $khuvuc = khuvuc::find($request->id);

        if($khuvuc) {
            $ban = ban::where('id_khu_vuc', $request->id)->first();

            if($ban) {
                return response()->json([
                    'status'    => 2,
                    'message'   => 'Khu vực này đang có bàn, bạn không thể xóa!'
                ]);
            } else {
                $khuvuc->delete();

                return response()->json([
                    'status'    => true,
                    'message'   => 'Đã xóa khu vực thành công!'
                ]);
            }
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Khu vực không tồn tại!'
            ]);
        }
    }

    //----cập nhập----
    public function capnhapkv(CapNhapKhuVucRequest $request)
    {
        $khuvuc = khuvuc::where('id', $request->id)->first();
        $data = $request->all();
        $khuvuc->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Đã cập nhập được khu vực'
        ]);
    }

    //------check-slug-----
    public function checkslug(Request $request)
    {
        if (isset($request->id)) {
            $check = khuvuc::where('slug_khu', $request->slug_khu)
                ->where('id', '<>', $request->id)
                ->first();
        } else {
            $check = khuvuc::where('slug_khu', $request->slug_khu)->first();
        }

        $check = khuvuc::where('slug_khu', $request->slug_khu)->first();
        if ($check) {
            return response()->json([
                'status' => false,
                'message' => 'Tên khu vực đã tồn tại'
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Tên khu vực có thể sử dụng '
            ]);
        }
    }

}
