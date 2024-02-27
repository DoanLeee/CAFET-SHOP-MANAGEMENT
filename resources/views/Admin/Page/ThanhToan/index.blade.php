<!DOCTYPE html>
<html>
<head>
    <title>bill</title>
    <style>
            .bill {
            margin: 50px auto;
            width: 600px;
            font-family: Arial, sans-serif;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .bill-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
            margin-bottom: 20px;
        }

        .bill-header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .bill-date {
            margin: 0;
            font-size: 14px;
            color: #777;
        }

        .bill table {
            width: 100%;
            border-collapse: collapse;
        }

        .bill th, .bill td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            color: #333;
        }

        .bill th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .bill tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .bill tfoot td {
            text-align: right;
            font-weight: bold;
            color: #333;
        }

        .bill tfoot tr:first-child td {
            border-top: 2px solid #000;
        }

        .bill tfoot tr:last-child td {
            border-bottom: 2px solid #000;
        }

        .bill tfoot tr td:first-child {
            text-align: right;
        }

        .bill-footer {
            padding-top: 20px;
            text-align: right;
        }

        .bill-footer p {
            margin: 0;
            font-size: 14px;
            color: #777;
        }
        #top .logo {
    height: 60px;
    width: 60px;
    background: url(/td.png) no-repeat;

    background-size: 60px 60px;
}

    </style>
</head>
<body>
    <div class="bill">
        <center id="top">
            <div class="logo"></div>
            {{-- <div class="info">
                <h2>CaPhe TĐ</h2>
            </div> --}}
            <!--End Info-->
        </center>
        <div class="bill-header">
            <h1>BILL</h1><br>
            <p class="bill-date">sdt:0935874992</p><br>
            <p class="bill-date">Địa Chỉ:xxxxxxx</p><br>
            <p>{{ $ngay }}</p>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Tên</th>
                    <th>Số Lượng</th>
                    <th>Đơn Giá</th>
                    <th>Chiếc Khấu</th>
                    <th>Thành Tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($chitiet as $key => $value)
                    <tr class="service">
                        <td class="tableitem">
                            <p class="itemtext text-nowrap">{{ $value->ten_mon }}</p>
                        </td>
                        <td class="tableitem">
                            <p class="itemtext text-nowrap">{{ number_format($value->so_luong_ban, 2) }}</p>
                        </td>
                        <td class="tableitem">
                            <p class="itemtext text-nowrap">{{ number_format($value->don_gia_ban, 0) }}</p>
                        </td>
                        <td class="tableitem">
                            <p class="itemtext text-nowrap">{{ number_format($value->tien_chiet_khau, 0) }}</p>
                        </td>
                        <td class="tableitem">
                            <p class="itemtext text-nowrap">{{ number_format($value->thanh_tien, 0) }}</p>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4">Tổng:</td>
                    <td>{{ number_format($tong_tien, 0) }} đ</td>
                </tr>
                <tr>
                    <td colspan="4">Giảm Giá:</td>
                    <td>{{ number_format($giam_gia, 0) }} đ</td>
                </tr>
                <tr>
                    <td colspan="4">Thực Thu:</td>
                    <td>{{ number_format($thanh_tien, 0) }} đ</td>
                </tr>
            </tfoot>
        </table>
        <div class="bill-footer">
            <p>Thank you for your business!</p>
        </div>
    </div>
</body>
</html>


