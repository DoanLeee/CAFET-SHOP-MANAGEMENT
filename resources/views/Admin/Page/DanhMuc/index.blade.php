@extends('admin.share.master')
@section('noi_dung')
    <div class="container">
        <div class="row" id="app">
            <div class="pagetitle">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Trang Chủ</a></li>
                        <li class="breadcrumb-item active">Danh Mục</li>
                    </ol>
                </nav>
              </div>
            <div class="card">
                <div class="card-body">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Danh Sách Danh Mục</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#themmoidanhmuc"><i class="fa-solid fa-plus"></i> Thêm Mới</button>
                    </div>
                    <div style="overflow-x: auto;">
                        <table class="table table-bordered border-primary">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Tên Danh Mục</th>
                                    <th class="text-center">Slug Danh Mục</th>
                                    <th class="text-center">Tình Trạng</th>
                                    <th class="text-center">action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(value, key) in data">
                                    <tr>
                                        <th class=" align-middle text-center"> @{{ key + 1}} </th>
                                        <td class=" align-middle text-center"> @{{ value.ten_danh_muc }} </td>
                                        <td class=" align-middle text-center"> @{{ value.slug_danh_muc }} </td>
                                        <td class=" align-middle text-center">
                                            <i v-on:click="doitinhtrang(value)" v-if="value.tinh_trang_dm ==0" class="fa-solid fa-eye-slash maudo"  style="font-size: 20px;"></i>
                                            <i v-on:click="doitinhtrang(value)" v-else class="fa-solid fa-eye mauxanh"  style="font-size: 20px;"></i>
                                        </td>
                                        <td class="align-middle text-center">
                                            <i v-on:click="capnhap_danh_muc = Object.assign({}, value)" data-bs-toggle="modal" data-bs-target="#capnhapdanhmuc" class="fa-solid fa-pen-to-square mauxanh" style="font-size: 1.2em;"></i>
                                            <i v-on:click="xoa_danh_muc = value" data-bs-toggle="modal" data-bs-target="#xoadanhmucmodel" class="fa-solid fa-trash maudo" style="font-size: 1.2em;"></i> </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    {{-- -------------------------------- --}}
                    <div class="modal fade" id="themmoidanhmuc" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm Mới Danh Mục</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Tên Danh Mục</label>
                                        <input v-model="add_danh_muc.ten_danh_muc" v-on:keyup="createSlug()" v-on:blur="checkSlug()" type="text" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Slug Danh Mục</label>
                                        <input v-model="add_danh_muc.slug_danh_muc" type="text" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        {{-- Switches --}}
                                        <div class="row">
                                            <div class="col-4">
                                                <label class="form-check-label" >Tình Trạng</label>
                                            </div>
                                            <div class="col-8" style="font-size: 1.5rem">
                                                <div class="form-check form-switch">
                                                    <i v-if="add_danh_muc.tinh_trang_dm" class="fa-solid fa-eye mauxanh"  style="font-size: 20px;"></i>
                                                    <input class="form-check-input" type="checkbox" v-model="add_danh_muc.tinh_trang_dm">
                                                    <i class="fa-solid fa-eye-slash maudo" v-if="!add_danh_muc.tinh_trang_dm" style="font-size: 20px;"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                                    <button id="add" v-on:click="themdanhmuc()" type="button" class="btn btn-primary">Lưu</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- -------------------------------- --}}
                    <div class="modal fade" id="xoadanhmucmodel" tabindex="-1" aria-labelledby="exampleModalLabel"aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Xóa Danh Mục</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" class="form-control" id="id_delete">
                                    <div class="alert alert-primary" role="alert">
                                        Bạn Có Chắc Muốn Xóa : <b class="text-danger text-uppercase"> @{{ xoa_danh_muc.ten_danh_muc }} </b> này không
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
                    <div class="modal fade" id="capnhapdanhmuc" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Cập Nhập Danh Mục</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <label class="mt-3">Tên Danh Mục</label>
                                    <input v-model="capnhap_danh_muc.ten_danh_muc"  v-on:keyup="createSlugedit()" class="form-control mt-1" type="text">
                                    <label class="mt-3">Slug Danh Mục</label>
                                    <input v-model="capnhap_danh_muc.slug_danh_muc" class="form-control mt-1" type="text">

                                    <div class="mt-3">
                                        {{-- Switches --}}
                                        <div class="row">
                                            <div class="col-4">
                                                <label class="form-check-label">Tình Trạng</label>
                                            </div>
                                            <div class="col-8" style="font-size: 1.5rem">
                                                <div class="form-check form-switch">
                                                    <i v-if="capnhap_danh_muc.tinh_trang_dm" class="fa-solid fa-eye mauxanh" style="font-size: 20px;"></i>
                                                    <input class="form-check-input " type="checkbox" v-model="capnhap_danh_muc.tinh_trang_dm">
                                                    <i class="fa-solid fa-eye-slash maudo" v-if="!capnhap_danh_muc.tinh_trang_dm" style="font-size: 20px;"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
    </div>
@endsection
@section('js')
    <script>
        new Vue({
            el: "#app",
            data: {
                data: [],
                add_danh_muc: {
                    'ten_danh_muc' : '',
                    'slug_danh_muc': '',
                    'tinh_trang_dm': 1
                },
                xoa_danh_muc : {},
                capnhap_danh_muc: {},
            },
            created() {
                this.loadData();
            },

            methods: {

                loadData() {
                    axios
                    .get('{{ Route('datadanhmuc') }}')
                        .then((res) => {
                            this.data = res.data.data;
                        });
                },

                //----Thêm danh mục-----------
                themdanhmuc() {
                    axios
                        .post('{{ Route('nhapdanhmuc') }}', this.add_danh_muc)
                        .then((res) => {
                            if (res.data.status == 1) {
                                toastr.success(res.data.message);
                                this.loadData();
                                this.add_danh_muc = {
                                    'ten_danh_muc': '',
                                    'slug_danh_muc': '',
                                    'tinh_trang_dm': 1
                                    },
                                $('#themmoidanhmuc').modal('hide');
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

                //----checkslug-----------
                createSlug() {
                    var slug = this.toSlug(this.add_danh_muc.ten_danh_muc);
                    this.add_danh_muc.slug_danh_muc = slug;
                },
                toSlug(str) {
                    str = str.toLowerCase();
                    str = str
                        .normalize('NFD')
                        .replace(/[\u0300-\u036f]/g, '');
                    str = str.replace(/[đĐ]/g, 'd');
                    str = str.replace(/([^0-9a-z-\s])/g, '');
                    str = str.replace(/(\s+)/g, '-');
                    str = str.replace(/-+/g, '-');
                    str = str.replace(/^-+|-+$/g, '');
                    return str;
                },

                //----đổi tình trạng-----------
                doitinhtrang(abcxyz) {
                    axios
                        .post('{{ Route('tinhtrangdanhmuc') }}', abcxyz)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message);
                                this.loadData();
                            } else if (res.data.status == 0) {
                                toastr.error(res.data.message);
                            }
                        });
                },

                //------Xóa -----
                xoa() {
                    axios
                        .post('{{ Route('xoadanhmuc') }}', this.xoa_danh_muc)
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
                        .post('{{ Route('capnhapdanhmuc') }}', this.capnhap_danh_muc)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message);
                                this.loadData();
                                $('#capnhapdanhmuc').modal('hide');
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
                createSlugedit() {
                    var slug = this.toSlug(this.capnhap_danh_muc.ten_danh_muc);
                    this.capnhap_danh_muc.slug_danh_muc = slug;
                },

                //------checkSlug-----------
                checkSlug() {
                    var payload = {
                        'slug_danh_muc': this.add_danh_muc.slug_danh_muc
                    };
                    axios
                        .post('{{ Route('checkslugdanhmuc') }}', payload)
                        .then((res) => {
                            if (res.data.status == 1) {
                                toastr.success(res.data.message);
                                $("#add").removeAttr("disabled");
                            } else if (res.data.status == 0) {
                                toastr.error(res.data.message);
                                $("#add").prop("disabled", true);
                            } else if (res.data.status == 2) {
                                toastr.warning(res.data.message);
                            }
                        });
                },

            }
        });
    </script>
@endsection
