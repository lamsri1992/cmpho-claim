@extends('app.main')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item active">
                            <h3>
                                <i class="nav-icon fa-solid fa-clipboard-list"></i>
                                ข้อมูลบัญชียา GPU
                            </h3>
                        </li>
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
                                <i class="fa-regular fa-file-lines"></i>
                                ข้อมูลบัญชียา GPU
                            </h5>
                        </div>
                        <div class="card-body">
                            <table id="drug_table" class="table table-striped table-borderless table-bordered nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">GPU:ID</th>
                                        <th class="text-center">TPU:ID</th>
                                        <th class="text-center">รายการ</th>
                                        <th class="text-center">ความแรง</th>
                                        <th class="text-center">หน่วยนับ</th>
                                        <th class="text-center">อัตราจ่าย</th>
                                        <th class="text-center">ปีที่ใช้</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $rs)
                                    <tr>
                                        <td class="text-center">{{ $rs->gid }}</td>
                                        <td class="text-center">{{ $rs->tid }}</td>
                                        <td class="text-center">{{ $rs->dname }}</td>
                                        <td class="text-center">{{ $rs->dpotency }}</td>
                                        <td class="text-center">{{ $rs->dunit }}</td>
                                        <td class="text-center">{{ number_format($rs->rate,2) }}</td>
                                        <td class="text-center">{{ $rs->dyear }}</td>
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
@endsection
@section('script')
<script>
    new DataTable('#drug_table', {
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
                    }
                ]
            }
        },
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        scrollX: true,
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
