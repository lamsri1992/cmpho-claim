@extends('app.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">รายงานข้อมูล</li>
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
                        <div class="card-header row">
                            <div class="col-md-6">
                                <h5 class="card-title">
                                    <i class="fa-solid fa-print"></i>
                                    รายงานข้อมูลเรียกเก็บแยกหน่วยบริการ
                                </h5>
                            </div>
                            <div class="col-md-6 text-right">
                                <?php
                                $currentMonth = $_REQUEST['month'];
                                $thaiMonths = array(
                                    "มกราคม",
                                    "กุมภาพันธ์",
                                    "มีนาคม",
                                    "เมษายน",
                                    "พฤษภาคม",
                                    "มิถุนายน",
                                    "กรกฎาคม",
                                    "สิงหาคม",
                                    "กันยายน",
                                    "ตุลาคม",
                                    "พฤศจิกายน",
                                    "ธันวาคม"
                                );

                                $thaiMonthName = $thaiMonths[$currentMonth - 1];
                                ?>
                                <span>
                                    <i class="fa-regular fa-calendar"></i>
                                    {{ "ข้อมูลเดือน".$thaiMonthName." พ.ศ. ".$_REQUEST['year'] }}
                                    <small class="text-danger">
                                        แสดงเฉพาะข้อมูลที่ประมวลผลแล้ว
                                    </small>
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="nhso_table" class="table table-striped table-bordered nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">รหัส รพ.ลูกหนี้</th>
                                        <th class="text-start">ชื่อ รพ.ลูกหนี้</th>
                                        <th class="text-center">รหัส รพ.เจ้าหนี้</th>
                                        <th class="text-start">ชื่อ รพ. เจ้าหนี้</th>
                                        <th class="text-center">จำนวน</th>
                                        <th class="text-end">ค่าใช้จ่ายจริง</th>
                                        <th class="text-end">ค่าใช้จ่ายตามเกณฑ์</th>
                                        <th class="text-center">รหัสเดือน</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $res)
                                    <tr>
                                        <td class="text-center">{{ $res->hospmain }}</td>
                                        <td class="text-start">{{ $res->main_hospital }}</td>
                                        <td class="text-center">{{ $res->hcode }}</td>
                                        <td class="text-start">{{ $res->visit_hospital }}</td>
                                        <td class="text-center">{{ $res->cases }}</td>
                                        <td class="text-end fw-bold">{{ number_format($res->total,2) }}</td>
                                        <td class="text-end fw-bold">{{ number_format($res->total,2) }}</td>
                                        <td class="text-center">{{ $month }}</td>
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
                        extend: 'print',
                        text: '<i class="fa-solid fa-print text-primary"></i> พิมพ์รายงาน',
                    },
                ] 
            }
        },
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        responsive: true,
        ordering: false,
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
