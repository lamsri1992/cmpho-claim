@extends('app.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">ลูกหนี้ OPAE</li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('debtor.index') }}">
                                รายการลูกหนี้
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            รายการข้อมูลนำเข้า
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
                                <i class="fa-solid fa-spinner fa-spin"></i>
                                รายการข้อมูลนำเข้า
                            </h5>
                        </div>
                        <div class="card-body">
                            <table id="nhso_table" class="table table-striped table-bordered nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">วันที่</th>
                                        <th class="text-center">VN</th>
                                        <th class="text-center">สถานบริการหลัก</th>
                                        <th class="text-center">HN</th>
                                        <th class="text-center">รหัสบริการ</th>
                                        <th class="">รายละเอียด</th>
                                        <th class="text-center">ค่าใช้จ่ายจริง</th>
                                        <th class="text-center">ค่าใช้ตามเกณฑ์</th>
                                        <th class="text-center">จำนวน</th>
                                        <th class="text-center">รวม</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 0; @endphp
                                    @php $pass = 0; @endphp
                                    @php $deny = 0; @endphp
                                    @php $vns = ''; @endphp
                                    @foreach ($data as $rs)
                                    @php
                                        $vns = $vns.$rs->vn.',';
                                    @endphp
                                    @if ($rs->is_status == 'N')
                                        @php
                                            $bg = 'bg-danger';
                                            $deny++;
                                        @endphp
                                    @else
                                        @php
                                            $bg = 'bg-success';
                                            $pass++;
                                        @endphp
                                    @endif
                                    @php $i++; @endphp
                                    <tr>
                                        <td class="text-center">{{ $i }}</td>
                                        <td class="text-center">{{ date("d/m/Y", strtotime($rs->visitdate)) }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('debtor.show',$rs->vn) }}">
                                                {{ $rs->vn }}
                                            </a>
                                        </td>
                                        <td class="text-center {{ $bg }}">{{ $rs->hospmain." : ".$rs->h_name }}</td>
                                        <td class="text-center {{ $bg }}">{{ $rs->hn }}</td>
                                        <td class="text-center {{ $bg }} ">
                                            @if ($rs->nhso_code != "")
                                            {{ $rs->nhso_code }}
                                            @endif
                                            @if ($rs->tid != "")
                                            {{ $rs->tid }}
                                            @endif
                                            @if ($rs->nhso_code == "" && $rs->tid == "") 
                                            {{ $rs->fs_code }}
                                            @endif
                                        </td>
                                        <td class="{{ $bg }}">
                                            @if ($rs->nhso_code != "")
                                            {{ $rs->nhso_name }}
                                            @endif
                                            @if ($rs->tid != "")
                                            {{ $rs->dname }}
                                            @endif
                                            @if ($rs->nhso_code == "" && $rs->tid == "") 
                                            ไม่พบรหัสข้อมูล
                                            @endif
                                        </td>
                                        <td class="text-center {{ $bg }}">
                                            {{ number_format($rs->total,2) }}
                                        </td>
                                        <td class="text-center {{ $bg }}">
                                            @if (isset($rs->rate))
                                            {{ number_format($rs->rate,2) }}
                                            @else
                                            {{ number_format($rs->nhso_cost,2) }}
                                            @endif
                                        </td>
                                        <td class="text-center {{ $bg }}">
                                            {{ number_format($rs->num) }}
                                        </td>
                                        <td class="text-center {{ $bg }}">
                                            @if (isset($rs->rate))
                                            {{ number_format($rs->rate * $rs->num,2) }}
                                            @else
                                            {{ number_format($rs->nhso_cost * $rs->num,2) }}
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td></td>
                                        <td colspan="7"></td>
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
                        text: '<i class="fa-solid fa-square-arrow-up-right text-primary"></i> ส่งข้อมูลไปยัง สสจ.',
                        action: function (e, dt, node, config) {
                            var count = {{ $pass }};
                            if(count <= 0){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'ไม่มีข้อมูล',
                                    text: count + ' รายการ',
                                    showCancelButton: false,
                                });
                            }else{
                                Swal.fire({
                                icon: 'warning',
                                title: 'ยืนยันการส่งข้อมูล ?',
                                text: 'ส่งข้อมูลเฉพาะที่ผ่านการตรวจสอบ ' + '{{ number_format($pass) }}' + ' รายการ',
                                showCancelButton: true,
                                confirmButtonText: "ส่งข้อมูล",
                                cancelButtonText: "ยกเลิก",
                                confirmButtonColor: "#3085d6",
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    Swal.fire({
                                        title: "กำลังประมวลผล",
                                        text: "อย่าปิดหน้าจอนี้ขณะประมวลผลข้อมูล",
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        timerProgressBar: true,
                                        didOpen: () => {
                                            Swal.showLoading();
                                            const timer = Swal.getPopup().querySelector("b");
                                        }
                                    });
                                    $.ajax({
                                        url: "{{ route('debtor.send') }}",
                                        method: 'GET',
                                        // data: { vns: '{{ $vns }}' },
                                        success:function(data){
                                            let timerInterval
                                            Swal.fire({
                                                timer: 3000,
                                                timerProgressBar: true,
                                                title: 'กำลังส่งข้อมูล',
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timerProgressBar: true,
                                                didOpen: () => {
                                                    Swal.showLoading();
                                                    const timer = Swal.getPopup().querySelector("b");
                                                },
                                                willClose: () => {
                                                    clearInterval(timerInterval);
                                                }
                                            }).then((result) => {
                                                if (result.dismiss === Swal.DismissReason.timer) {
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: 'ส่งข้อมูลสำเร็จ',
                                                        text: '{{ number_format($pass) }}' + ' รายการ',
                                                        showConfirmButton: false,
                                                        allowOutsideClick: false,
                                                        allowEscapeKey: false,
                                                        timer: 10000
                                                    })
                                                    window.setTimeout(function () {
                                                        location.reload()
                                                    }, 3000);
                                                }
                                            })
                                        }
                                    });
                                }
                            });   
                            }
                        }
                    },
                    {
                        text: '<i class="fa-solid fa-xmark-circle text-danger"></i> ลบข้อมูลการนำเข้า',
                        action: function (e, dt, node, config) {
                            var count = {{ count($data) }};
                            if(count <= 0){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'ไม่มีข้อมูล',
                                    text: count + ' รายการ',
                                    showCancelButton: false,
                                });
                            }else{
                                Swal.fire({
                                icon: 'warning',
                                title: 'ยืนยันการลบข้อมูล ?',
                                text: 'ลบข้อมูลนำเข้าทั้งหมด',
                                showCancelButton: true,
                                confirmButtonText: "ลบข้อมูล",
                                cancelButtonText: "ยกเลิก",
                                confirmButtonColor: "#dc3545",
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    Swal.fire({
                                        title: "กำลังลบ",
                                        text: "อย่าปิดหน้าจอนี้ขณะลบข้อมูล",
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        timerProgressBar: true,
                                        didOpen: () => {
                                            Swal.showLoading();
                                            const timer = Swal.getPopup().querySelector("b");
                                        }
                                    });
                                    $.ajax({
                                        url: "{{ route('debtor.remove') }}",
                                        method: 'GET',
                                        // data: { vns: '{{ $vns }}' },
                                        success:function(data){
                                            let timerInterval
                                            Swal.fire({
                                                timer: 3000,
                                                timerProgressBar: true,
                                                title: 'กำลังลบข้อมูล',
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                timerProgressBar: true,
                                                didOpen: () => {
                                                    Swal.showLoading();
                                                    const timer = Swal.getPopup().querySelector("b");
                                                },
                                                willClose: () => {
                                                    clearInterval(timerInterval);
                                                }
                                            }).then((result) => {
                                                if (result.dismiss === Swal.DismissReason.timer) {
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: 'ลบข้อมูลสำเร็จ',
                                                        text: '{{ number_format(count($data)) }}' + ' รายการ',
                                                        showConfirmButton: false,
                                                        allowOutsideClick: false,
                                                        allowEscapeKey: false,
                                                        timer: 10000
                                                    })
                                                    window.setTimeout(function () {
                                                        location.reload()
                                                    }, 3000);
                                                }
                                            })
                                        }
                                    });
                                }
                            });   
                            }
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
        initComplete: function () {
            this.api()
                .columns([3])
                .every(function () {
                    var column = this;
                    var select = $(
                            '<select class="custom-select" style="width:100%;"><option value="">แสดงทั้งหมด</option></select>'
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
                            select.append('<option class="custom-select" value="' + d + '">' + d +
                                '</option>');
                        });
                });
        }
    });
</script>
@endsection
