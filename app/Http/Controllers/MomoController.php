<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MomoController extends Controller
{


    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }

    public function momo_payment(Request $request){

        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";


        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán qua MoMo";
        $amount = "10000";
        // $amount = $_POST["thanh_tien"];
        $orderId = time() ."";
        $redirectUrl = "https://webhook.site/b3088a6a-2d17-4f8d-a383-71389a6c600b";
        $ipnUrl = "https://webhook.site/b3088a6a-2d17-4f8d-a383-71389a6c600b";
        $extraData = "";





            $requestId = time() . "";
            $requestType = "payWithATM";
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
                'signature' => $signature);

            $result = $this->execPostRequest($endpoint, json_encode($data));
            // dd($result);
            $jsonResult = json_decode($result, true);  // decode json

            //Just a example, please check more in there
            return redirect()->to($jsonResult['payUrl']);
            // header('Location: ' . $jsonResult['payUrl']);
        }

}

public function momo_payment(Request $request)
{
    dd($request->id_hoa_don_ban_hang);
    $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

    $partnerCode = 'MOMOBKUN20180529';
    $accessKey = 'klm05TvNBzhg7h7j';
    $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
    $orderInfo = "Thanh toán qua MoMo";
    $redirectUrl = "https://webhook.site/b3088a6a-2d17-4f8d-a383-71389a6c600b";
    $ipnUrl = "https://webhook.site/b3088a6a-2d17-4f8d-a383-71389a6c600b";
    $extraData = "";

    // Retrieve thanh_tien based on id_hoa_don_ban_hang
    $hoadonbanhang = hoadonbanhang::find($request->id_hoa_don_ban_hang);
    if (!$hoadonbanhang || $hoadonbanhang->trang_thai == 0) {
        return response()->json([
            'status' => 0,
            'message' => 'Hóa đơn không tồn tại hoặc đã tính tiền!',
        ]);
    }

    $data = chitietbanhang::where('id_hoa_don_ban_hang', $request->id_hoa_don_ban_hang)->get();
    $tong_tien = 0;

    foreach ($data as $key => $value) {
        $tong_tien += $value->thanh_tien;
        $this->tinhTongDaBanTheoIdMonAn($value->id_menu);
    }

    // Check if giam_gia exceeds total amount
    $giam_gia = $hoadonbanhang->giam_gia;
    if ($giam_gia > $tong_tien) {
        return response()->json([
            'status' => 0,
            'message' => 'Giảm giá không được vượt quá tổng giá trị đơn hàng!',
        ]);
    }

    $amount = $tong_tien - $giam_gia;
    $orderId = time() . "";
    $requestId = time() . "";
    $requestType = "captureWallet";

    // Before sign HMAC SHA256 signature
    $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
    $signature = hash_hmac("sha256", $rawHash, $secretKey);

    $data = [
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
    ];

    $result = $this->execPostRequest($endpoint, json_encode($data));
    $jsonResult = json_decode($result, true);

    // Redirect to the MoMo payment page
    return redirect()->to($jsonResult['payUrl']);
}
