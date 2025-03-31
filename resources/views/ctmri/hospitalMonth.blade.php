@extends('app.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">ลูกหนี้ CT - MRI</li>
                        <li class="breadcrumb-item active">ลูกหนี้แยกโรงพยาบาล</li>
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
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="card-title">
                                        <i class="fa-regular fa-hospital"></i>
                                        ข้อมูลลูกหนี้แยกรายโรงพยาบาล
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
                        </div>
                        <div class="card-body">
                            <table id="nhso_table" class="table table-striped table-borderless table-bordered nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">รหัสหน่วยบริการ</th>
                                        <th class="">หน่วยบริการ</th>
                                        <th class="text-right">ค่าบริการ</th>
                                        <th class="text-center">เคส</th>
                                        <th class="text-center"><i class="fa-solid fa-bars"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $rs)
                                    <tr>
                                        <td class="text-center">{{ $rs->hospmain }}</td>
                                        <td class="">{{ $rs->h_name }}</td>
                                        <td class="text-success text-right">{{ number_format($rs->total_p + $rs->total_c,2)." ฿" }}</td>
                                        <td class="text-center">{{ number_format($rs->num) }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('ctmri.hospital.list',['id' => $rs->hospmain, 'month' => $_REQUEST['month']]) }}" class="btn btn-secondary btn-sm">
                                                <i class="fa-solid fa-clipboard"></i>
                                                รายละเอียด
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
<div class="modal fade" id="monthList" tabindex="-1" aria-labelledby="monthListLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('ctmri.hospital.month') }}" method="GET">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="monthListLabel">
                        <i class="fa-regular fa-calendar-check text-primary"></i>
                        เลือกข้อมูลรายเดือน
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>เลือกเดือน</label>
                            <select name="month" class="custom-select" @required(true)>
                                <option value="">-- เลือกเดือน --</option>
                                <option value="01">มกราคม</option>
                                <option value="02">กุมภาพันธ์</option>
                                <option value="03">มีนาคม</option>
                                <option value="04">เมษายน</option>
                                <option value="05">พฤษภาคม</option>
                                <option value="06">มิถุนายน</option>
                                <option value="07">กรกฏาคม</option>
                                <option value="08">สิงหาคม</option>
                                <option value="09">กันยายน</option>
                                <option value="10">ตุลาคม</option>
                                <option value="11">พฤศจิกายน</option>
                                <option value="12">ธันวาคม</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label>ระบุปี พ.ศ.</label>
                            <input type="text" class="form-control" name="year" @required(true) placeholder="กรุณาระบุปี พ.ศ.">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fa-solid fa-search"></i>
                        ค้นหาข้อมูล
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('script')
<script>
     new DataTable('#nhso_table', {
        layout: {
            topStart: {
                buttons: [
                    {
                        text: '<i class="fa-regular fa-calendar-check text-primary"></i> เลือกข้อมูลรายเดือน',
                        action: function (e, dt, node, config) {
                            $('#monthList').modal('show')
                        }
                    },
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
