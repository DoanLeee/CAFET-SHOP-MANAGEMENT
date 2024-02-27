<?php

namespace App\Http\Requests\HoaDon;

use Illuminate\Foundation\Http\FormRequest;

class addmenuchitiethoadonRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id_menu'              => 'required|exists:menus,id',
            'id_hoa_don_ban_hang'  => 'required|exists:hoadonbanhangs,id',
        ];
    }
    public function messages()
    {
        return[
            'id_menu.*'              => 'món ăn không tồn tại',
            'id_hoa_don_ban_hang.*'  => 'hóa đơn bán hàng không tồn tại',
        ];
    }
}
