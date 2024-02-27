@extends('admin.share.master')
@section('noi_dung')
    <div class="container">
        <div class="row" id="app">
            <div class="pagetitle">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Trang Chủ</a></li>
                        <li class="breadcrumb-item active">VouCher</li>
                    </ol>
                </nav>
              </div>
            <div class="card">
                <div class="card-body">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Danh Sách VouCher</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#themmoivoucher"><i class="fa-solid fa-plus"></i> Thêm Mới</button>
                    </div>

                    <div style="overflow-x: auto;">
                        <table class="table table-bordered border-primary">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Tên VouCher</th>
                                    <th class="text-center">tiền VouCher</th>
                                    <th class="text-center">Action VouCher</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(value, key) in data">
                                    <tr>
                                        <th class=" align-middle text-center">@{{ key + 1}}</th>
                                        <td class=" align-middle text-center">@{{ value.ten_voucher }}</td>
                                        <td class=" align-middle text-center">@{{ number_format(value.tien_voucher) }}</td>
                                        <td class="align-middle text-center">
                                            <i v-on:click="capnhap_voucher = Object.assign({}, value)" data-bs-toggle="modal" data-bs-target="#capnhapvoucher" class="fa-solid fa-pen-to-square mauxanh" style="font-size: 1.2em;"></i>
                                            <i v-on:click="xoa_voucher = value" data-bs-toggle="modal" data-bs-target="#xoavoucher" class="fa-solid fa-trash maudo" style="font-size: 1.2em;"></i> </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- -------------------------------- --}}
                <div class="modal fade" id="themmoivoucher" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm Mới Menu</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Tên VouCher</label>
                                    <input v-model="add_voucher.ten_voucher" type="text" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tiền VouCher</label>
                                    <input v-model="add_voucher.tien_voucher" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                                <button id="add" v-on:click="themvoucher()" type="button" class="btn btn-primary">Lưu</button>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- -------------------------------- --}}
                <div class="modal fade" id="xoavoucher" tabindex="-1" aria-labelledby="exampleModalLabel"aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Xóa voucher</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" class="form-control" id="id_delete">
                                <div class="alert alert-primary" role="alert">
                                    Bạn Có Chắc Muốn Xóa : <b class="text-danger text-uppercase"> @{{ xoa_voucher.ten_voucher }} </b> này không
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" v-on:click="xoa()">xác nhận xóa</button>
                            </div>
                        </div>
                    </div>
                </div>

                 {{-- -------------------------------- --}}
                 <div class="modal fade" id="capnhapvoucher" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Cập Nhập VouCher</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <label class="mt-3">Tên VouCher</label>
                                <input v-model="capnhap_voucher.ten_voucher" class="form-control mt-1" type="text">
                                <label class="mt-3">Tiền VouCher</label>
                                <input v-model="capnhap_voucher.tien_voucher" class="form-control mt-1" type="text">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                                <button type="button" class="btn btn-danger" v-on:click="capnhap()" >Lưu</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        new Vue({
            el: "#app",
            data: {
                data: [],
                add_voucher     : {
                                    'ten_voucher': '',
                                    'tien_voucher': '',
                                    },
                xoa_voucher     : {},
                capnhap_voucher : {},
            },
            created() {
                this.loadData();
            },
            methods: {
                loadData() {
                    axios
                        .get('{{ Route('datavoucher') }}')
                        .then((res) => {
                            this.data = res.data.data;
                        });
                },
                //----------- vnd ------------
                number_format(number) {
                    return new Intl.NumberFormat('vi-VI', {
                        style: 'currency',
                        currency: 'VND'
                    }).format(number);
                },

                //----Thêm voucher-----------
                themvoucher() {
                    axios
                        .post('{{ Route('nhapvoucher') }}', this.add_voucher)
                        .then((res) => {
                            if (res.data.status == 1) {
                                toastr.success(res.data.message);
                                this.loadData();
                                this.add_voucher = {
                                    'ten_voucher': '',
                                    'tien_voucher': '',
                                    },
                                $('#themmoivoucher').modal('hide');
                            } else if (res.data.status == 0) {
                                toastr.error(res.data.message);
                            } else if (res.data.status == 2) {
                                toastr.warning(res.data.message);
                            }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors , function(k,v){
                                toastr.error(v[0]);
                            })
                            $('#add').removeAttr('disabled');
                        });
                },

                //------Xóa -----
                xoa() {
                    axios
                        .post('{{ Route('xoavoucher') }}', this.xoa_voucher)
                        .then((res) => {
                            if (res.data.status == 1) {
                                toastr.success(res.data.message);
                                this.loadData();
                            } else if (res.data.status == 0) {
                                toastr.error(res.data.message);
                            } else if (res.data.status == 2) {
                                toastr.warning(res.data.message);
                            }
                        });
                },

                //------cập nhập -----
                capnhap() {
                    axios
                        .post('{{ Route('capnhapvoucher') }}', this.capnhap_voucher)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message);
                                this.loadData();
                                $('#capnhapvoucher').modal('hide');
                            } else if (res.data.status == 0) {
                                toastr.error(res.data.message);
                            }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            })
                            $("#add").removeAttr("disabled");
                        });
                },
            }
        });
    </script>
@endsection
