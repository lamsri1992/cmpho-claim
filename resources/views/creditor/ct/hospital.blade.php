@extends('app.main')
@section('content')
@php
    $url = url()->current(); 
    $path = parse_url($url, PHP_URL_PATH);
    $segments = explode('/', $path);
    $val = end($segments);
@endphp
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">ข้อมูล CT - MRI</li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('ct.index') }}">
                                เจ้าหนี้ CT - MRI
                            </a>
                        </li>
                        <li class="breadcrumb-item active">เจ้าหนี้แยกรายโรงพยาบาล</li>
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
                                <i class="fa-regular fa-hospital"></i>
                                เจ้าหนี้ CT-MRI แยกรายโรงพยาบาล
                            </h5>
                        </div>
                        <div class="card-body">
                            <table id="nhso_table" class="table table-striped table-bordered nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">REF_ID</th>
                                        <th class="text-center">รหัสหน่วยบริการ</th>
                                        <th class="text-center">หน่วยบริการ</th>
                                        <th class="text-center">จำนวน</th>
                                        <th class="text-center">ค่าใช้จ่ายชดเชย</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $rs)
                                    <tr>
                                        <td class="text-center">
                                            <a href="{{ route('ct.hospital.view',$rs->trans_code) }}">
                                                {{ $rs->trans_code }}
                                            </a>
                                        </td>
                                        <td class="text-center">{{ $rs->hcode }}</td>
                                        <td class="text-center">{{ $rs->h_name }}</td>
                                        <td class="text-center">{{ $rs->count." รายการ" }}</td>
                                        <td class="text-center">{{ number_format($rs->t_pay + $rs->t_con,2) }}</td>
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
    $(document).ready(function () {
        $('.select2').select2({
            // placeholder: 'กรุณาเลือก',
            width: '100%',
        });
    });

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
                ]
            }
        },
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        // responsive: true,
        scrollX: true,
        // rowReorder: {
        //     selector: 'td:nth-child(2)'
        // },
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
        initComplete: function () {
            this.api()
                .columns([1])
                .every(function () {
                    var column = this;
                    var select = $(
                            '<select class="" style="width:100%;"><option value="">แสดงทั้งหมด</option></select>'
                        )
                        .appendTo($(column.footer()).empty())
                        .on('change', function () {
                            var val = DataTable.util.escapeRegex($(this).val());
                            column
                                .search(val ? '^' + val + '$' : '', true, false)
                                .draw();
                        });
                    column
                        .data()
                        .unique()
                        .sort()
                        .each(function (d, j) {
                            select.append('<option class="" value="' + d + '">' + d +
                                '</option>');
                        });
                });
        }
    });
</script>
@endsection
