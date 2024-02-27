<?php

namespace App\Http\Requests\VouCher;

use Illuminate\Foundation\Http\FormRequest;

class NhapVouCherRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ten_voucher'       =>'required|min:5|max:30',
            'tien_voucher'       =>'required|numeric|min:0',

        ];
    }

    public function messages()
    {
        return [
            'ten_voucher.required'  => 'vui lòng nhập tên voucher',
            'ten_voucher.min'       => 'tên voucher ít nhất 5 ký tự',
            'ten_voucher.max'       => 'tên voucher tối đa 30 ký tự',
            'tien_voucher.*'        => 'It nhất 0 đồng',

        ];
    }
}
