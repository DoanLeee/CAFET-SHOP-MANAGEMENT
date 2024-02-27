<?php

namespace App\Http\Controllers;

use App\Http\Requests\HoaDon\addmenuchitiethoadonRequest;
use App\Http\Requests\HoaDon\CheckidhoadonbanhangRequest;
use App\Http\Requests\HoaDon\getdanhsachmenutheohoadonRequest;
use App\Http\Requests\HoaDon\UpdateChiTietBanHangRequest;
use App\Models\ban;
use App\Models\chitietbanhang;
use App\Models\hoadonbanhang;
use App\Models\khuvuc;
use App\Models\menu;
use App\Models\voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PHPViet\NumberToWords\Transformer;
use Carbon\Carbon;
use Spatie\LaravelIgnition\Solutions\SolutionTransformers\LaravelSolutionTransformer;

class HoaDonBanHangController extends Controller
{
    public function index()
    {

        return view('Admin.Page.BanHang.index');
    }

    public function store(Request $request)
    {
        $ban = ban::find($request->id_ban);
        if ($ban && $ban->tinh_trang_b == 1 && $ban->trang_thai == 0) {
            $ban->trang_thai = 1; //lên màu xanh
            $ban->save();

            $hoadon = hoadonbanhang::create([
                'ma_hoa_don_ban_hang'       => Str::uuid(),
                'id_ban'                    => $request->id_ban,

            ]);
            return response()->json([
                'status'    => true,
                'message'   => 'Đã mở bàn',
                'id_hoa_don_ban_hang'  => $hoadon->id,
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Bàn không thể mở',
            ]);
        }
    }
    //id
    public function findidbyidban(Request $request)
    {

        $hoadon = hoadonbanhang::where('id_ban', $request->id_ban)->where('trang_thai', 0)->first();

        if ($hoadon) {
            return response()->json([
                'status'       => true,
                'id_hoa_don'   => $hoadon->id,
            ]);
        } else {
            return response()->json([
                'status'       => false,
                'id_hoa_don'   => 0,
            ]);
        }
    }

    public function addmenuchitiethoadon(addmenuchitiethoadonRequest $request)
    {
        // dd($request->all());
        $hoadon = hoadonbanhang::find($request->id_hoa_don_ban_hang);
        if ($hoadon->trang_thai) {
            return response()->json([
                'status'       => 0,
                'id_hoa_don'   => "hóa đơn này đã tính tiền",
            ]);
        } else {
            $menu = menu::find($request->id_menu);

            $check = chitietbanhang::where("id_hoa_don_ban_hang", $request->id_hoa_don_ban_hang)
                ->where("id_menu", $request->id_menu)
                ->first();
            if ($check && $check->is_in_bep == 0) {
                $check->so_luong_ban    = $check->so_luong_ban + 1;
                $check->thanh_tien      = $check->so_luong_ban * $check->don_gia_ban - $check->tien_chiet_khau;
                $check->save();
            } else {
                chitietbanhang::create([
                    'id_hoa_don_ban_hang'   => $request->id_hoa_don_ban_hang,
                    'id_menu'               => $request->id_menu,
                    'ten_mon'               => $menu->ten_mon,
                    'so_luong_ban'          => 1,
                    'don_gia_ban'           => $menu->gia_ban,
                    'tien_chiet_khau'       => 0,
                    'thanh_tien'            => $menu->gia_ban,
                ]);
            }
            return response()->json([
                'status'       => 1,
                'message'   => "đã thêm món thành công",
            ]);
        }
    }


    public function getdanhsachmenutheohoadon(getdanhsachmenutheohoadonRequest $request)
    {
        $hoadon = hoadonbanhang::find($request->id_hoa_don_ban_hang);
        if ($hoadon->trang_thai) {
            return response()->json([
                'status'       => 0,
                'id_hoa_don'   => "hóa đơn này đã tính tiền",
            ]);
        } else {
            $data = chitietbanhang::where('id_hoa_don_ban_hang', $request->id_hoa_don_ban_hang)->get();
            $tong_tien  = 0;
            foreach ($data as $key => $value) {
                $tong_tien += $value->thanh_tien;
            }
            $transformer = new Transformer();
            $giam_gia    = $hoadon->giam_gia;
            $thanh_tien  = $tong_tien - $giam_gia;


            return response()->json([
                'status'        => 1,
                'data'          => $data,
                'tong_tien'     => $tong_tien,
                'thanh_tien'    => $thanh_tien,
                'tt_chu'        => $transformer->toCurrency($thanh_tien),

            ]);
        }
    }

    //update
    public function update(updatechitietbanhangRequest $request)
    {
        $chitietbanhang = chitietbanhang::find($request->id);
        $hoadonbanhang  = hoadonbanhang::find($request->id_hoa_don_ban_hang);

        if ($hoadonbanhang && $hoadonbanhang->trang_thai == 0 && $chitietbanhang->is_in_bep == 0) {
            if ($request->so_luong_ban < 0) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Số lượng không được phép là số âm!',
                ]);
            }
            $chitietbanhang->so_luong_ban         = $request->so_luong_ban;
            $chitietbanhang->thanh_tien           = $chitietbanhang->so_luong_ban * $request->don_gia_ban;
            $chitietbanhang->ghi_chu              = $request->ghi_chu;
            $chitietbanhang->tien_chiet_khau      = $request->tien_chiet_khau;


            if ($request->tien_chiet_khau > $chitietbanhang->thanh_tien) {
                return response()->json([
                    'status'   => 0,
                    'message'  => 'tiền chiết khấu chỉ dc tối đa' . number_format($chitietbanhang->thanh_tien, 0, '.', '.') . 'đ',
                ]);
            } else {
                $chitietbanhang->thanh_tien = $chitietbanhang->thanh_tien - $request->tien_chiet_khau;
                $chitietbanhang->save();

                return response()->json([
                    'status'   => 1,
                    'message'  => 'đã cập nhập số lượng',
                ]);
            }
        } else {
            return response()->json([
                'status'   => 0,
                'message'  => 'có lỗi không mong muốn sảy ra',
            ]);
        }
    }

    //pha chế
    public function phache(CheckidhoadonbanhangRequest $request)
    {
        $hoadonbanhang   = hoadonbanhang::find($request->id_hoa_don_ban_hang);

        if ($hoadonbanhang && $hoadonbanhang->trang_thai == 0) {
            ChiTietBanHang::where('id_hoa_don_ban_hang', $request->id_hoa_don_ban_hang)
                ->update([
                    'is_in_bep'     => 1,
                ]);
            return response()->json([
                'status'    => 1,
                'message'   => 'Đã gửi pha chế thành công!',
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Hóa đơn này đã tính tiền!',
            ]);
        }
    }

    //xoa chi tiết
    public function xoachitietdonhang(updatechitietbanhangRequest $request)
    {
        $chitietbanhang = chitietbanhang::find($request->id);
        $hoadonbanhang  = hoadonbanhang::find($request->id_hoa_don_ban_hang);

        if ($hoadonbanhang && $hoadonbanhang->trang_thai == 0 && $chitietbanhang->is_in_bep == 0) {
            $chitietbanhang->delete();
            return response()->json([
                'status'   => 1,
                'message'  => 'đã xóa',
            ]);
        } else {
            return response()->json([
                'status'   => 0,
                'message'  => 'có lỗi không mong muốn sảy ra',
            ]);
        }
    }

    //voucher
    public function xacnhanvoucher(Request $request)
    {
        $hoadonbanhang   = hoadonbanhang::find($request->id);
        if ($hoadonbanhang && $hoadonbanhang->trang_thai == 0) {
            if ($hoadonbanhang->is_xac_nhan == 0) {
                $hoadonbanhang->id_voucher   = $request->id_voucher;
                $hoadonbanhang->is_xac_nhan     = 1;
                $hoadonbanhang->save();
                //

            }
            return response()->json([
                'status'    => 1,
                'message'   => 'Đã xác nhận voucher!',
                'data'      => $hoadonbanhang,
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'message' => 'Hóa đơn không tồn tại hoặc không thể xác nhận!',
            ]);
        }
    }

    public function updateHoaDon(Request $request)
    {
        $hoadonbanhang = hoadonbanhang::find($request->id);

        if ($hoadonbanhang && $hoadonbanhang->trang_thai == 0) {
            $giamGia = $request->giam_gia;
            if ($giamGia < 0) {
                $giamGia = 0;
                return response()->json([
                    'status' => 0,
                    'message' => 'Giảm gía không được là số âm!',
                ]);
            }
            $hoadonbanhang->giam_gia = $giamGia;
            $hoadonbanhang->save();

            return response()->json([
                'status' => 1,
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'message' => 'Hóa đơn này đã tính tiền!',
            ]);
        }
    }

    //thanh toán
    public function tinhTongDaBanTheoIdMonAn($id_menu)
    {
        $menu   =  chitietbanhang::join('hoadonbanhangs', 'id_hoa_don_ban_hang', 'hoadonbanhangs.id')
            ->where('id_menu', $id_menu)
            ->where('hoadonbanhangs.trang_thai', 1)
            ->sum('so_luong_ban');
        $menu = menu::find($id_menu);
        $menu->save();
    }

    public function inBill($id)
    {
        $chitiet = chitietbanhang::where('id_hoa_don_ban_hang', $id)->get();
        $tong_tien  = 0;
        foreach ($chitiet as $key => $value) {
            $tong_tien += $value->thanh_tien;
        }
        $hoadon      = hoadonbanhang::find($id);
        $giam_gia    = $hoadon->giam_gia;
        $thanh_tien  = $tong_tien - $giam_gia;
        $ngay        = $hoadon->ngay_thanh_toan ? Carbon::parse($hoadon->ngay_thanh_toan)->format('H:i d/m/Y')  : 'Hóa đơn tạm tính';
        return view('Admin.Page.ThanhToan.index', compact('chitiet', 'tong_tien', 'thanh_tien', 'giam_gia', 'ngay'));
    }


    public function thanhtoan(Request $request)
    {
        $hoadonbanhang = hoadonbanhang::find($request->id_hoa_don_ban_hang);
        if ($hoadonbanhang && $hoadonbanhang->trang_thai == 0) {
            $data = chitietbanhang::where('id_hoa_don_ban_hang', $request->id_hoa_don_ban_hang)->get();
            $tong_tien  = 0;
            foreach ($data as $key => $value) {
                $tong_tien += $value->thanh_tien;
                $this->tinhTongDaBanTheoIdMonAn($value->id_menu);
            }

            chitietbanhang::where('id_hoa_don_ban_hang', $request->id_hoa_don_ban_hang)
                ->update([
                    'is_che_bien'    =>  1,
                    'is_in_bep'      =>  1,
                ]);

            $hoadonbanhang->trang_thai = 1;
            $hoadonbanhang->ngay_thanh_toan = Carbon::now();
            $hoadonbanhang->tong_tien       = $tong_tien - $hoadonbanhang->tien_giam_gia;
            $hoadonbanhang->save();

            $ban                =   ban::find($request->id_ban);
            $ban->trang_thai    =   0;
            $ban->save();

            return response()->json([
                'status'    => 1,
                'message'   => 'Đã thanh toán thành công!',
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Hóa đơn này đã tính tiền!',
            ]);
        }
    }

    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }




    public function momo_payment(Request $request)
    {
        $data=$request->all();

        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán qua MoMo";
        // $amount = "100";
        $amount = $data['thanh_tien'];
        $orderId = time() . "";
        $redirectUrl = "http://127.0.0.1:8000/admin/ban-hang";
        $ipnUrl = "http://127.0.0.1:8000/admin/ban-hang";
        $extraData = "";

        $requestId = time() . "";
        $requestType = "captureWallet";
        // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
        //before sign HMAC SHA256 signature
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
        // dd($signature);
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );

        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);
        // dd($jsonResult);
        return redirect()->to($jsonResult['payUrl']);
    }
}
