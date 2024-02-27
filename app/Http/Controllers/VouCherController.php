<?php

namespace App\Http\Controllers;

use App\Http\Requests\VouCher\CapNhapVouCherRequest;
use App\Http\Requests\VouCher\NhapVouCherRequest;
use App\Models\voucher;
use Illuminate\Http\Request;

class VouCherController extends Controller
{
    public function index(){
        return view('Admin.Page.VouCher.index');
    }
    public function getDaTa()
    {
        $data = voucher::get();
        return response()->json([
            'data' => $data
        ]);

        
    }



    //---------nhap---------
    public function nhap(NhapVouCherRequest $request)
    {
        $data = $request->all();
        voucher::create($data);

        return response()->json([
            'status' => true,
            'message'  => 'Đã tạo voucher thành công '
        ]);
    }

    //----------xoa-----------
    public function xoa(Request $request)
    {
        $voucher =voucher::find($request->id);
        if ($voucher) {
            $voucher->delete();
            return response()->json([
                'status'   => true,
                'message'  => 'Đã xóa voucher thành công !'
            ]);
        } else {
            return response()->json([
                'status'   => false,
                'message'  => 'Voucher không tồn tại! '
            ]);
        }

    }

    //----cập nhập----
    public function capnhapvoucher(CapNhapVouCherRequest $request)
    {
        $voucher = voucher::where('id', $request->id)->first();
        $data = $request->all();
        $voucher->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Đã cập nhập được voucher'
        ]);
    }

}
