@extends('app.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">ตั้งค่าระบบ</li>
                        <li class="breadcrumb-item active">ข้อมูลหน่วยบริการ</li>
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
                                <i class="fa-solid fa-hospital"></i>
                                ข้อมูลหน่วยบริการ
                            </h5>
                        </div>
                        <div class="card-body">
                            <table id="nhso_table" class="table table-striped table-bordered table-borderless nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">รหัสหน่วยบริการ</th>
                                        <th>หน่วยบริการ</th>
                                        <th class="text-center">ประเภทหน่วยบริการ</th>
                                        <th class="text-center"><i class="fa-solid fa-bars"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 0; @endphp
                                    @foreach ($data as $rs)
                                    @php $i++; @endphp
                                    <tr>
                                        <td class="text-center">{{ $i }}</td>
                                        <td class="text-center">{{ $rs->h_code }}</td>
                                        <td>{{ $rs->h_name }}</td>
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
<div class="modal fade" id="addHospital" tabindex="-1" aria-labelledby="addHospitalLabel" aria-hidden="true">
    <form action="{{ route('config.hospital.create') }}" method="POST">
        @csrf
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addHospitalLabel">
                        <i class="fa-solid fa-plus-circle"></i>
                        เพิ่มหน่วยบริการ
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>รหัสหน่วยบริการ</label>
                        <input type="text" class="form-control" name="h_code" placeholder="ระบุรหัส 5 หลักของหน่วยบริการ">
                    </div>
                    <div class="form-group">
                        <label>หน่วยบริการ</label>
                        <input type="text" class="form-control" name="h_name" placeholder="ระบุชื่อหน่วยบริการ">
                    </div>
                    <div class="form-group">
                        <label>ประเภทหน่วยบริการ</label>
                        <select class="custom-select" name="h_type">
                            <option value="">กรุณาเลือก</option>
                            @foreach ($type as $rs)
                            <option value="{{ $rs->h_type_id }}">
                                {{ $rs->h_type_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-default" id="btnConfirm"
                        onclick="
                        Swal.fire({
                            icon: 'question',
                            title: 'ยืนยันการเพิ่มหน่วยบริการ ?',
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
                        text: '<i class="fa-solid fa-plus-circle text-primary"></i> เพิ่มหน่วยบริการ',
                        action: function (e, dt, node, config) {
                            $('#addHospital').modal('show')
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
</script>
@endsection
