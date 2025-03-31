@extends('app.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">ข้อมูล CT - MRI</li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('ctmri.index') }}">
                                ลูกหนี้ CT - MRI
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            รายงานข้อมูล
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
                                <i class="fa-regular fa-calendar"></i>
                                ข้อมูลวันที่ : {{ date("d/m/Y", strtotime($_REQUEST['dstart']))." - ".date("d/m/Y", strtotime($_REQUEST['dend']))}}
                            </h5>
                        </div>
                        <div class="card-body">
                            <table id="nhso_table" class="table table-striped table-bordered nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">วันที่</th>
                                        <th class="text-center">สถานบริการหลัก</th>
                                        <th class="text-center">HN</th>
                                        <th class="">ผู้รับบริการ</th>
                                        <th class="text-center">ICD10</th>
                                        <th class="text-center">ICD9</th>
                                        <th class="">รายการ</th>
                                        <th class="text-center">ค่าใช้จ่ายจริง</th>
                                        <th class="text-center">Point</th>
                                        <th class="text-center">ค่าชดเชย</th>
                                        <th class="text-center">ค่าฉีดสี</th>
                                        <th class="text-center">รายละเอียด</th>
                                        <th class="text-center">รวม</th>
                                        <th class="text-center">สถานะ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $all_cash = 0;
                                        $all_payment = 0;
                                        $all_contrast = 0;
                                        $all_total = 0;
                                    @endphp
                                    @foreach ($data as $rs)
                                    @php
                                        $all_cash += $rs->total_cash;
                                        $all_payment += $rs->total_payment;
                                        $all_contrast += $rs->total_contrast;
                                        $all_total += $rs->total_payment + $rs->total_contrast;
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ date("d/m/Y", strtotime($rs->visitdate)) }}</td>
                                        <td class="">{{ $rs->hospmain." : ".$rs->h_name }}</td>
                                        <td class="text-center">{{ $rs->hn }}</td>
                                        <td class="">{{ $rs->name }}</td>
                                        <td class="text-center">{{ $rs->icd10 }}</td>
                                        <td class="text-center">{{ $rs->icd9 }}</td>
                                        <td class="">{{ $rs->red }}</td>
                                        <td class="text-end">{{ number_format($rs->total_cash,2) }}</td>
                                        <td class="text-center">{{ $rs->point }}</td>
                                        <td class="text-end">{{ number_format($rs->total_payment,2) }}</td>
                                        <td class="text-end">{{ number_format($rs->total_contrast,2) }}</td>
                                        <td class="">{{ $rs->contrast_description }}</td>
                                        <td class="text-end text-primary">
                                            {{ number_format($rs->total_payment + $rs->total_contrast,2) }}
                                        </td>
                                        <td class="text-center {{ $rs->p_text_color }}">
                                            {{ $rs->p_name }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td style="text-decoration-line: underline">
                                            {{ number_format($all_cash,2) }}
                                        </td>
                                        <td></td>
                                        <td style="text-decoration-line: underline">
                                            {{ number_format($all_payment,2) }}
                                        </td>
                                        <td style="text-decoration-line: underline">
                                            {{ number_format($all_contrast,2) }}
                                        </td>
                                        <td></td>
                                        <td style="text-decoration-line: underline" class="text-primary">
                                            {{ number_format($all_total,2) }}
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Modal Search -->
<div class="modal fade" id="search" tabindex="-1" aria-labelledby="searchLabel" aria-hidden="true">
    <form action="{{ route('ctmri.search') }}" method="GET">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="searchLabel">ค้นหาข้อมูลเรียกเก็บ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">
                            <i class="fa-regular fa-calendar"></i>
                            เริ่มวันที่
                        </label>
                        <input type="text" name="dstart" class="form-control flatpickr">
                    </div>
                    <div class="form-group">
                        <label for="">
                            <i class="fa-regular fa-calendar"></i>
                            ถึงวันที่
                        </label>
                        <input type="text" name="dend" class="form-control flatpickr">
                    </div>
                    <div class="form-group">
                        <label for="">
                            <i class="fa-regular fa-hospital"></i>
                            หน่วยบริการ
                        </label>
                        <select name="hos" class="select-hos">
                            <option value="0">เลือกทั้งหมด</option>
                            @foreach ($hos as $rs)
                            <option value="{{ $rs->h_code }}">
                                {{ $rs->h_code." : ".$rs->h_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="text-center">
                        <small class="text-danger">ข้อมูลจะถูกค้นหาจากวันที่ Visit</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-search"></i>
                        ค้นหา
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@section('script')
<script>
    flatpickr('.flatpickr', {
        "locale": "th"
    });

    $(document).ready(function () {
        $('.select2').select2({
            width: '100%',
        });

        $('.select-hos').select2({
            width: '100%',
            dropdownParent: $('#search')
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
                    {
                        text: '<i class="fa-solid fa-search text-info"></i> ค้นหาข้อมูล',
                        action: function (e, dt, node, config) {
                            $('#search').modal('show')
                        }
                    }
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
                .columns([1,13])
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
