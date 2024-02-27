<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ban\CapNhapBanRequest;
use App\Http\Requests\Ban\NhapBanRequest;
use App\Models\ban;
use App\Models\khuvuc;
use Illuminate\Http\Request;

class BanController extends Controller
{

    public function index()
    {
        $khuvuc = khuvuc::all();
        return view('Admin.Page.Ban.index', compact('khuvuc'));
    }


    public function getDaTa(){
        $data = ban::join('khuvucs', 'bans.id_khu_vuc', 'khuvucs.id')
                    ->select('bans.*', 'khuvucs.ten_khu', 'khuvucs.tinh_trang_kv')
                    ->get();

        return response()->json([
            'data' => $data
        ]);
    }

    //---------nhap---------
    public function nhap(NhapBanRequest $request)
    {
        $data = $request->all();
        ban::create($data);
        return response()->json([
            'status' => true,
            'message'  => 'Đã tạo bàn thành công '
        ]);
    }

    //-----------tinhtrangban-------
    public function tinhtrangban(Request $request)
    {
        $ban = ban::find($request->id);
        if ($ban) {
            $ban->tinh_trang_b = !$ban->tinh_trang_b;
            $ban->save();

            return response()->json([
                'status'   => true,
                'message'  => 'Đã đổi trạng thái thành công! '
            ]);
        } else {
            return response()->json([
                'status'   => false,
                'message'  => 'Bàn không tồn tại! '
            ]);
        }
    }

    public function xoa(Request $request)
    {
        $ban =ban::find($request->id);
        if ($ban) {
            $ban->delete();
            return response()->json([
                'status'   => true,
                'message'  => 'Đã xóa bàn thành công !'
            ]);
        } else {
            return response()->json([
                'status'   => false,
                'message'  => 'Bàn không tồn tại! '
            ]);
        }
    }

    //--------
    public function capnhapban(CapNhapBanRequest $request){
        $ban = ban::where('id',$request->id)->first();
        $data = $request->all();
        $ban->update($data);
        return response()->json([
            'status' => true,
            'message' => 'đã cập nhập được thông tin'
        ]);
    }

    //------check-slug-----
    public function checkslug(Request $request)
    {
        if (isset($request->id)) {
            $check = ban::where('slug_ban', $request->slug_ban)
                ->where('id', '<>', $request->id)
                ->first();
        } else {
            $check = ban::where('slug_ban', $request->slug_ban)->first();
        }

        $check = ban::where('slug_ban', $request->slug_ban)->first();
        if ($check) {
            return response()->json([
                'status' => false,
                'message' => 'Tên bàn đã tồn tại'
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Tên bàn có thể sử dụng '
            ]);
        }
    }

    
}
