@extends('admin.share.master')
@section('noi_dung')
    <div class="container">
        <div class="row" id="app">
            <div class="pagetitle">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Trang Chủ</a></li>
                        <li class="breadcrumb-item active">Menu</li>
                    </ol>
                </nav>
              </div>
            <div class="card">
                <div class="card-body">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Danh Sách Menu</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#themmoimenu"><i class="fa-solid fa-plus"></i> Thêm Mới</button>
                    </div>

                    <div style="overflow-x: auto;">
                        <table class="table table-bordered border-primary">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Tên Món</th>
                                    <th class="text-center">Slug Món</th>
                                    <th class="text-center">Danh Mục</th>
                                    <th class="text-center">Hình Ảnh</th>
                                    <th class="text-center">Giá Bán</th>
                                    <th class="text-center">Tình Trạng</th>
                                    <th class="text-center">action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(value, key) in data">
                                    <tr>
                                        <th class=" align-middle text-center">@{{ key + 1 }}</th>
                                        <td class=" align-middle text-center">@{{ value.ten_mon }}</td>
                                        <td class=" align-middle text-center">@{{ value.slug_mon }}</td>
                                        <td class=" align-middle text-center">@{{ value.ten_danh_muc }}</td>
                                        <td class=" align-middle text-center">
                                            <img v-bind:src=" '/hinh-mon/' + value.hinh_anh" alt="" style="max-width: 100%; max-height: 50px; display: block; margin: 0 auto;">
                                        </td>
                                        <td class=" align-middle text-center">@{{ number_format(value.gia_ban) }}</td>
                                        <td class=" align-middle text-center">
                                            <i v-on:click="doitinhtrang(value)" v-if="value.tinh_trang_m ==0" class="fa-solid fa-eye-slash maudo"  style="font-size: 20px;"></i>
                                            <i v-on:click="doitinhtrang(value)" v-else class="fa-solid fa-eye mauxanh"  style="font-size: 20px;"></i>
                                        </td>
                                        <td class="align-middle text-center">
                                            <i v-on:click="capnhap_menu = Object.assign({}, value); edit_file = value.hinh_anh" data-bs-toggle="modal" data-bs-target="#capnhapmenu" class="fa-solid fa-pen-to-square mauxanh" style="font-size: 1.2em;"></i>
                                            <i v-on:click="xoa_menu = value" data-bs-toggle="modal" data-bs-target="#xoamenu" class="fa-solid fa-trash maudo" style="font-size: 1.2em;"></i>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    {{-- -------------------------------- --}}
                    <div class="modal fade" id="themmoimenu" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm Mới Menu</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Tên Món</label>
                                        <input v-model="add_menu.ten_mon" v-on:keyup="createSlug()" v-on:blur="checkSlug()" type="text" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Slug Món</label>
                                        <input v-model="add_menu.slug_mon" type="text" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tên Danh Mục</label>
                                        <select v-model="add_menu.id_danh_muc" class="form-control">
                                            <option value="0">vui lòng chọn danh mục</option>
                                            @foreach ( $danhmuc as $key => $value)
                                                <option value="{{ $value->id }}">{{ $value->ten_danh_muc }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Hình Ảnh</label>
                                        <input type="file" class="form-control" ref="file" v-on:change="uploadfile()" accept="image/png , image/jpg , image/jpeg">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Giá Bán</label>
                                        <input v-model="add_menu.gia_ban" type="text" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tình Trạng</label>
                                            <select v-model="add_menu.tinh_trang_m" class="form-control">
                                                <option value="1">Có Món</option>
                                                <option value="0">Hết Món</option>
                                            </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                                    <button id="add" v-on:click="themmenu()" type="button" class="btn btn-primary">Lưu</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- -------------------------------- --}}
                    <div class="modal fade" id="xoamenu" tabindex="-1" aria-labelledby="exampleModalLabel"aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Xóa Menu</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" class="form-control" id="id_delete">
                                    <div class="alert alert-primary" role="alert">
                                        Bạn Có Chắc Muốn Xóa : <b class="text-danger text-uppercase"> @{{ xoa_menu.ten_mon }} </b> này không
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
                     <div class="modal fade" id="capnhapmenu" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Cập Nhập Menu</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Tên Món</label>
                                        <input v-model="capnhap_menu.ten_mon" v-on:keyup="createSlugedit()" type="text" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Slug Món</label>
                                        <input v-model="capnhap_menu.slug_mon" type="text" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tên Danh Mục</label>
                                        <select v-model="capnhap_menu.id_danh_muc" class="form-control">
                                            <option value="0">vui lòng chọn danh mục</option>
                                            @foreach ( $danhmuc as $key => $value)
                                                <option value="{{ $value->id }}">{{ $value->ten_danh_muc }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Hình Ảnh</label>
                                        <input type="file" class="form-control" ref="editFile" v-on:change="uploadEditFile()" accept="image/png , image/jpg , image/jpeg">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Giá Bán</label>
                                        <input v-model="capnhap_menu.gia_ban" type="text" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tình Trạng</label>
                                            <select v-model="capnhap_menu.tinh_trang_m" class="form-control">
                                                <option value="1">Có Món</option>
                                                <option value="0">Hết Món</option>
                                            </select>
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
                data            : [],
                xoa_menu        : {},
                add_menu        : { "ten_mon" : "" , "slug_mon" : "" , "id_danh_muc" : 0 , "gia_ban" : "" , "tinh_trang_m" : 1},
                file            : '',
                capnhap_menu    : '',
                edit_file       : '',
            },
            created() {
                this.loadData();
            },
            methods: {

                loadData() {
                    axios
                       .get('{{ Route('datamenu') }}')
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


                //----đổi tình trạng-----------
                doitinhtrang(abcxyz) {
                    axios
                        .post('{{ Route('tinhtrangmenu') }}', abcxyz)
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
                        .post('{{ Route('xoamenu') }}', this.xoa_menu)
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


                //----Thêm menu-----------
                themmenu() {
                    $("#add").prop('disabled', true);
                    var formData = new FormData();
                    formData.append('ten_mon',this.add_menu.ten_mon);
                    formData.append('slug_mon',this.add_menu.slug_mon);
                    formData.append('gia_ban',this.add_menu.gia_ban);
                    formData.append('hinh_anh',this.file);
                    formData.append('id_danh_muc',this.add_menu.id_danh_muc);
                    formData.append('tinh_trang_m',this.add_menu.tinh_trang_m);
                    axios
                        .post('{{ Route('nhapmenu') }}', formData, {
                            headers:{
                                'Content-Type' : 'nultipart/form-data'
                            }
                        })
                        .then((res) => {
                            if (res.data.status == 1) {
                                toastr.success(res.data.message);
                                this.loadData();
                                this.add_menu = {
                                    "ten_mon": "",
                                    "slug_mon": "",
                                    "id_danh_muc": 0,
                                    "gia_ban": "",
                                    "tinh_trang_m": 1,
                                };
                                $('#add').removeAttr('disabled');
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

                //hình ảnh
                uploadfile(){
                    this.file = this.$refs.file.files[0];
                    console.log(this.file);
                },

                //----checkslug-----------
                createSlug() {
                    var slug = this.toSlug(this.add_menu.ten_mon);
                    this.add_menu.slug_mon = slug;
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

                //----------edit----------
                capnhap() {
                    // Tạo một formData mới
                    var formData = new FormData();
                    // Đẩy dữ liệu của capnhap_menu vào formData
                    formData.append('id', this.capnhap_menu.id);
                    formData.append('ten_mon', this.capnhap_menu.ten_mon);
                    formData.append('slug_mon', this.capnhap_menu.slug_mon);
                    formData.append('gia_ban', this.capnhap_menu.gia_ban);
                    formData.append('hinh_anh', this.edit_file); // Đẩy hình ảnh mới vào formData
                    formData.append('id_danh_muc', this.capnhap_menu.id_danh_muc);
                    formData.append('tinh_trang_m', this.capnhap_menu.tinh_trang_m);
                    // Gửi yêu cầu cập nhật thông tin món với hình ảnh mới
                    axios.post('{{ Route('capnhapmenu') }}', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then((res) => {
                        if (res.data.status) {
                            toastr.success(res.data.message);
                            this.loadData();
                            $('#capnhapmenu').modal('hide');
                        } else if (res.data.status == 0) {
                            toastr.error(res.data.message);
                        }
                    }).catch((res) => {
                        $.each(res.response.data.errors, function(k, v) {
                            toastr.error(v[0]);
                        });
                    });
                },
                uploadEditFile(){
                    this.edit_file = this.$refs.editFile.files[0];
                    // console.log(this.$refs.editFile.files[0]);
                },
                createSlugedit(){
                    var slug = this.toSlug(this.capnhap_menu.ten_mon);
                    this.capnhap_menu.slug_mon = slug;
                },

                //-------checkSlug-----------
                checkSlug(){
                    var payload = {
                        'slug_mon': this.add_menu.slug_mon
                    };
                    axios
                        .post('{{ Route('checkslugmenu') }}', payload)
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
