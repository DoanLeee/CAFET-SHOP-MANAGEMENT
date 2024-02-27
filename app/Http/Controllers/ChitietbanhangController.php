<?php

namespace App\Http\Controllers;

use App\Http\Requests\HoaDon\UpdateChiTietBanHangRequest;
use App\Models\chitietbanhang;
use App\Models\hoadonbanhang;
use Illuminate\Http\Request;
use Carbon\Carbon;
class ChitietbanhangController extends Controller
{

    public function index()
    {
        return view('Admin.Page.PhaChe.index');
    }
    public function getdataphache()
    {
        $data = chitietbanhang::where('is_in_bep',1 )
                              ->where('is_che_bien', 0)
                              ->join('hoadonbanhangs','chitietbanhangs.id_hoa_don_ban_hang','hoadonbanhangs.id')
                              ->join('bans','hoadonbanhangs.id_ban','bans.id')
                              ->join('khuvucs', 'bans.id_khu_vuc', 'khuvucs.id')
                              ->select('chitietbanhangs.*', 'bans.ten_ban', 'khuvucs.ten_khu')
                              ->get();

        return response()->json([
            'status'    => 1,
            'data'   => $data,
        ]);
    }

    public function updatephache(Request $request){
        $check = chitietbanhang::find($request->id);

        if($check && $check->is_che_bien == 0) {
            $check->is_che_bien         = 1;

            $check->save();

            return response()->json([
                'status'    => true,
                'message'   => 'Đã hoàn thành món ',
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Hệ thống đã có sự cố',
            ]);
        }
    }
    // ------------------------------------------------------------------------------------------------------------------
    //UpdateChietKhau
    public function UpdateChietKhau(UpdateChiTietBanHangRequest $request)
    {
        $chitietbanhang  = chitietbanhang::find($request->id);
        $hoadonbanhang   = hoadonbanhang::find($request->id_hoa_don_ban_hang);

        if ($hoadonbanhang && $hoadonbanhang->trang_thai == 0) {
            $thanh_tien = $chitietbanhang->so_luong_ban * $chitietbanhang->don_gia_ban;
            $chitietbanhang->tien_chiet_khau = $request->tien_chiet_khau;

            if ($request->tien_chiet_khau < 0) {
                return response()->json([
                    'status'  => 0,
                    'message' => 'Tiền chiết khấu không được là số âm!',
                ]);
            }

            if ($request->tien_chiet_khau > $thanh_tien) {
                return response()->json([
                    'status'  => 0,
                    'message' => 'Tiền chiết khấu chỉ được tối đa: ' . number_format($thanh_tien, 0, '.', '.') . 'đ',
                ]);
            } else {
                $chitietbanhang->thanh_tien = $thanh_tien - $request->tien_chiet_khau;
                $chitietbanhang->save();

                return response()->json([
                    'status'  => 1,
                    'message' => 'Đã cập nhật số lượng!',
                ]);
            }
        } else {
            return response()->json([
                'status'  => 0,
                'message' => 'Có lỗi không mong muốn xảy ra!',
            ]);
        }
    }

    //getDanhSachMonTheoIdBan
    public function getDanhSachMonTheoIdBan(Request $request)
    {
        $hoaDon     = HoaDonBanHang::where('id_ban', $request->id_ban)->where('trang_thai', 0)->first();
        if($hoaDon) {
            $data   = ChiTietBanHang::where('id_hoa_don_ban_hang', $hoaDon->id)->get();

            return response()->json([
                'status'    => 1,
                'data'      => $data,
                'id_hd'     => $hoaDon->id,
            ]);

        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Hóa đơn này đã tính tiền!',
            ]);
        }
    }

    public function chuyenMonQuaBanKhac(Request $request)
    {
        $so_luong_chuyen    =   $request->so_luong_chuyen;
        $id_hoa_don_nhan    =   $request->id_hoa_don_nhan;

        $hoaDon = hoadonbanhang::find($request->id_hoa_don_ban_hang);

        if($hoaDon && $hoaDon->trang_thai == 0) {

            if($so_luong_chuyen > 0 && $so_luong_chuyen == $request->so_luong_ban) {
                $chitietbanhang                         = chitietbanhang::find($request->id);
                $chitietbanhang->id_hoa_don_ban_hang    = $id_hoa_don_nhan;
                $dau_cach                               =  $chitietbanhang->ghi_chu ? ": " : '';
                $chitietbanhang->ghi_chu                =  'Chuyển món từ hóa đơn ' . $chitietbanhang->id_hoa_don_ban_hang . ' sang' . $dau_cach .  $chitietbanhang->ghi_chu;
                $chitietbanhang->save();

                return response()->json([
                    'status'    => 1,
                    'message'   => 'Đã chuyển món thành công!',
                ]);
            } else if($so_luong_chuyen > 0 && $so_luong_chuyen < $request->so_luong_ban) {
                $chitietbanhang                         = chitietbanhang::find($request->id);

                $don_gia                                = $chitietbanhang->don_gia_ban;
                $tien_giam_gia_1_phan                   = $chitietbanhang->tien_chiet_khau / $chitietbanhang->so_luong_ban;

                $chitietbanhang->so_luong_ban          -= $so_luong_chuyen;
                $tien_chiet_khau                        = $tien_giam_gia_1_phan * $chitietbanhang->so_luong_ban;
                $chitietbanhang->thanh_tien             = $chitietbanhang->so_luong_ban * $don_gia - $tien_chiet_khau;
                $chitietbanhang->tien_chiet_khau        = $tien_chiet_khau;
                $chitietbanhang->save();

                $dau_cach       =  $chitietbanhang->ghi_chu ? ": " : '';

                chitietbanhang::create([
                    'id_hoa_don_ban_hang'       =>  $id_hoa_don_nhan,
                    'id_menu'                   =>  $chitietbanhang->id_menu,
                    'ten_mon'                   =>  $chitietbanhang->ten_mon,
                    'so_luong_ban'              =>  $so_luong_chuyen,
                    'don_gia_ban'               =>  $chitietbanhang->don_gia_ban,
                    'tien_chiet_khau'           =>  $tien_giam_gia_1_phan * $so_luong_chuyen,
                    'thanh_tien'                =>  $so_luong_chuyen * $chitietbanhang->don_gia_ban - $tien_giam_gia_1_phan * $so_luong_chuyen,
                    'ghi_chu'                   =>  'Chuyển món từ hóa đơn ' . $chitietbanhang->id_hoa_don_ban_hang . ' sang' . $dau_cach .  $chitietbanhang->ghi_chu,
                    'is_che_bien'               =>  $chitietbanhang->is_che_bien,
                    'is_in_bep'                 =>  $chitietbanhang->is_in_bep,
                ]);

                return response()->json([
                    'status'    => 1,
                    'message'   => 'Đã chuyển món thành công!',
                ]);

            } else {
                return response()->json([
                    'status'    => 0,
                    'message'   => 'Dữ liệu không chính xác!',
                ]);
            }

        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Hóa đơn này đã tính tiền!',
            ]);
        }
    }
}
