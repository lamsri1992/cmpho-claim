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
                        <li class="breadcrumb-item">
                            <a href="{{ route('ct.hospital') }}">
                                เจ้าหนี้แยกรายโรงพยาบาล
                            </a>
                        </li>
                        <li class="breadcrumb-item active">{{ $id }}</li>
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
                               REF_ID : {{ $id }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <table id="nhso_table" class="table table-striped table-bordered nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">วันที่</th>
                                        <th class="text-center">รพ.เจ้าหนี้</th>
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
                                    @if ($rs->ct_status == 3)
                                    @php $vs = '' @endphp
                                    @else
                                    @php $vs = 'disabled' @endphp
                                    @endif
                                    <tr>
                                        <td class="text-center">{{ date("d/m/Y", strtotime($rs->visitdate)) }}</td>
                                        <td class="text-center">{{ $rs->hospmain." : ".$rs->h_name }}</td>
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
    var check = {{ $check }};
    if(check == 1){
        Swal.fire({
            title: "รายการนี้ถูกดำเนินการแล้ว",
            text: "{{ $id }}",
            icon: "warning",
            allowOutsideClick: false,
            allowEscapeKey: false,
            confirmButtonText: 'เข้าใจแล้ว'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/credit/ct/hospital';
            }
        });
    }

    $(document).ready(function () {
        $('.select2').select2({
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
                    {
                        text: '<i class="fa-solid fa-folder-plus text-primary"></i> สร้าง Transaction',
                        action: function (e, dt, node, config) {
                            var count = {{ count($data) }};
                            var check = {{ $check }};
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
                                title: 'ยืนยันการสร้าง Transaction ?',
                                text: 'ดำเนินการข้อมูลทั้งหมดที่อยู่ในหน้านี้',
                                showCancelButton: true,
                                confirmButtonText: "ยืนยัน",
                                cancelButtonText: "ยกเลิก",
                                confirmButtonColor: "#3085d6",
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    var tcode = '{{ $id }}';
                                    $.ajax({
                                        url:"{{ route('ct.transaction.create') }}",
                                        method:'GET',
                                        data: {
                                            tcode : tcode
                                        },
                                        success:function(data){
                                            let timerInterval
                                            Swal.fire({
                                                timer: 3000,
                                                timerProgressBar: true,
                                                title: 'กำลังสร้าง Transaction',
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
                                                        title: 'สร้าง Transaction สำเร็จ',
                                                        showConfirmButton: false,
                                                        allowOutsideClick: false,
                                                        allowEscapeKey: false,
                                                        timer: 10000
                                                    })
                                                    window.setTimeout(function () {
                                                        window.location.replace("/transaction/ct");
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
        }
    });
</script>
@endsection
