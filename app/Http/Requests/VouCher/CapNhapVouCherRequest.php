<?php

namespace App\Http\Requests\VouCher;

use Illuminate\Foundation\Http\FormRequest;

class CapNhapVouCherRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id'                =>  'required|exists:vouchers,id',
            'ten_voucher'           =>  'required|min:5|max:30',
            'tien_voucher'           =>  'required|numeric|min:0',

        ];
    }

    public function messages()
    {
        return [
            'id.*'                   =>  'voucher không tồn tại!',
            'ten_voucher.required'  =>  'Yêu cầu phải nhập tên voucher',
            'ten_voucher.min'       =>  'Tên voucher phải từ 5 ký tự',
            'ten_voucher.max'       =>  'Tên voucher tối đa được 30 ký tự',
            'tien_voucher.*'         =>  'Voucher ít nhất là 0đ',
        ];
    }
}
