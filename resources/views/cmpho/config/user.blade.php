@extends('app.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">ตั้งค่าระบบ</li>
                        <li class="breadcrumb-item active">ข้อมูลผู้ใช้งาน</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="fa-solid fa-user-cog"></i>
                                ข้อมูลผู้ใช้งาน
                            </h5>
                        </div>
                        <div class="card-body">
                            <table id="nhso_table" class="table table-striped table-bordered table-borderless nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th class="text-center">รหัสหน่วยบริการ</th>
                                        <th>หน่วยบริการ</th>
                                        <th>Username</th>
                                        <th class="text-center">ประเภทหน่วยบริการ</th>
                                        <th class="text-center"><i class="fa-solid fa-bars"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $rs)
                                    <tr>
                                        <td class="text-center">{{ $rs->id }}</td>
                                        <td class="text-center">{{ $rs->hcode }}</td>
                                        <td>{{ $rs->name }}</td>
                                        <td>{{ $rs->email }}</td>
                                        <td class="text-center">{{ $rs->h_type_name }}</td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-default btn-sm">
                                                <i class="fa-solid fa-edit text-primary"></i>
                                                แก้ไขข้อมูล
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal -->
<div class="modal fade" id="addUser" tabindex="-1" aria-labelledby="addUserLabel" aria-hidden="true">
    <form action="{{ route('config.user.create') }}" method="POST">
        @csrf
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserLabel">
                        <i class="fa-solid fa-user-plus"></i>
                        เพิ่มผู้ใช้งาน
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>หน่วยบริการ</label>
                        <select class="hospital-select" name="hcode">
                            <option></option>
                            @foreach ($hosp as $rs)
                            <option value="{{ $rs->h_code }}">
                                {{ $rs->h_code.' - '.$rs->h_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>ชื่อผู้ใช้งาน</label>
                        <input type="text" class="form-control" name="name" placeholder="ระบุชื่อ Username">
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="email" class="form-control" name="email" placeholder="ระบุชื่อ Username">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-default" id="btnConfirm"
                        onclick="
                        Swal.fire({
                            icon: 'question',
                            title: 'ยืนยันการเพิ่มผู้ใช้งาน ?',
                            showCancelButton: true,
                            confirmButtonText: 'บันทึก',
                            cancelButtonText: 'ยกเลิก'
                            }).then((result) => {
                            if (result.isConfirmed) {
                                document.getElementById('btnConfirm').disabled = true;
                                form.submit()
                            }
                        });">
                        <i class="fa-solid fa-save text-success"></i>
                        บันทึกข้อมูล
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@section('script')
<script>
    new DataTable('#nhso_table', {
        layout: {
            topStart: {
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa-solid fa-file-excel text-success"></i> Export Excel',
                        customize: function (xlsx) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            sheet.querySelectorAll('row c[r^="C"]').forEach((el) => {
                                el.setAttribute('s', '2');
                            });
                        }
                    },
                    {
                        text: '<i class="fa-solid fa-user-plus text-primary"></i> เพิ่มผู้ใช้งาน',
                        action: function (e, dt, node, config) {
                            $('#addUser').modal('show')
                        }
                    }
                ]
            }
        },
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        responsive: true,
        // scrollX: true,
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        oLanguage: {
            oPaginate: {
                sFirst: '<small>หน้าแรก</small>',
                sLast: '<small>หน้าสุดท้าย</small>',
                sNext: '<small>ถัดไป</small>',
                sPrevious: '<small>กลับ</small>'
            },
            sSearch: '<small><i class="fa fa-search"></i> ค้นหา</small>',
            sInfo: '<small>ทั้งหมด _TOTAL_ รายการ</small>',
            sLengthMenu: '<small>แสดง _MENU_ รายการ</small>',
            sInfoEmpty: '<small>ไม่มีข้อมูล</small>'
        },
    });

    $(document).ready(function() {
        $('.hospital-select').select2(
            {
                placeholder: 'กรุณาเลือกหน่วยบริการ',
                width: '100%',
                dropdownParent: $("#addUser")
            }
        );
    });
</script>
@endsection
