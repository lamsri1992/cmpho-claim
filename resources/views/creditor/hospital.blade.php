@extends('app.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">เจ้าหนี้ OPAE</li>
                        <li class="breadcrumb-item active">เจ้าหนี้แยกโรงพยาบาล</li>
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
                                        ข้อมูลเจ้าหนี้แยกรายโรงพยาบาล
                                    </h5>
                                </div>
                                <div class="col-md-6 text-right">
                                    <?php
                                    $currentMonth = date('m');
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
                                        {{ "ข้อมูลเดือน".$thaiMonthName." พ.ศ. ".date('Y') + 543 }}
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
                                        <th class="">รพ.เจ้าหนี้</th>
                                        <th class="text-center">จำนวน</th>
                                        <th class="text-right">ค่าใช้จ่ายจริง</th>
                                        <th class="text-right">เรียกเก็บตามเกณฑ์</th>
                                        <th class="text-right">ส่วนต่าง</th>
                                        <th class="text-center"><i class="fa-solid fa-bars"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $diff = 0; @endphp
                                    @php $total = 0; @endphp
                                    @php $paid = 0; @endphp
                                    @php $tdiff = 0; @endphp
                                    @foreach ($data as $rs)
                                    @php $diff = ($rs->nh_cost + $rs->d_cost) - $rs->total @endphp
                                    @php $tdiff += ($rs->nh_cost + $rs->d_cost) - $rs->total @endphp
                                    @php $total += $rs->total @endphp
                                    @php $paid += ($rs->nh_cost + $rs->d_cost) @endphp
                                    <tr>
                                        <td class="text-center">{{ $rs->hcode }}</td>
                                        <td class="">{{ $rs->h_name }}</td>
                                        <td class="text-center">{{ number_format($rs->count)." รายการ" }}</td>
                                        <td class="text-primary text-right">{{ number_format($rs->total,2)." ฿" }}</td>
                                        <td class="text-right">{{ number_format($rs->nh_cost + $rs->d_cost,2)." ฿" }}</td>
                                        <td class="text-right">
                                            @if ($diff <= 0)
                                            @php $text = 'text-success'; @endphp
                                            @else
                                            @php $text = 'text-danger'; @endphp
                                            @endif
                                            <span class="{{ $text }}">
                                                {{ number_format($diff,2)." ฿" }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('creditor.hospital.list',['id' => $rs->hcode, 'month' => date('m')]) }}" class="btn btn-secondary btn-sm">
                                                <i class="fa-solid fa-clipboard"></i>
                                                รายละเอียด
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-center" colspan="3">รวม</td>
                                        <td class="text-right text-primary">
                                            <span style="text-decoration-line: underline">
                                                {{ number_format($total,2)." ฿" }}
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <span style="text-decoration-line: underline">
                                                {{ number_format($paid,2)." ฿" }}
                                            </span>
                                        </td>
                                        <td class="text-right text-danger">
                                            <span style="text-decoration-line: underline">
                                                {{ number_format($tdiff,2)." ฿" }}
                                            </span>
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
<!-- Modal -->
<div class="modal fade" id="monthList" tabindex="-1" aria-labelledby="monthListLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('creditor.hospital.month') }}" method="GET">
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
