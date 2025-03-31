@extends('app.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">ลูกหนี้ OPAE</li>
                        <li class="breadcrumb-item active">รายการลูกหนี้</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ number_format($sum_debtor->total,2) }} <sup style="font-size: 20px">บาท</sup></h3>
                            <p>ยอดลูกหนี้ทั้งหมด</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-list-check"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            รายละเอียด
                            <i class="fa-solid fa-search"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ number_format($count_check) }} <sup style="font-size: 20px">รายการ</sup></h3>
                            <p>ข้อมูลนำเข้ารอตรวจสอบ</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-clipboard"></i>
                        </div>
                        <a href="{{ route('debtor.list') }}" class="small-box-footer">
                            รายละเอียด
                            <i class="fa-solid fa-search"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3>{{ number_format($count_sents) }} <sup style="font-size: 20px">รายการ</sup></h3>
                            <p>รายการที่นำส่งแล้ว</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-file-import"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            รายละเอียด
                            <i class="fa-solid fa-search"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ number_format($count_deny) }} <sup style="font-size: 20px">รายการ</sup></h3>
                            <p>รายการถูกปฏิเสธ</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-file-circle-xmark"></i>
                        </div>
                        <a href="{{ route('debtor.deny') }}" class="small-box-footer">
                            รายละเอียด
                            <i class="fa-solid fa-search"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="card-title mt-2">
                                        <i class="fa-solid fa-history"></i>
                                        ประวัติการนำเข้าข้อมูล
                                    </h5>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="button" class="btn btn-success" data-toggle="modal"
                                        data-target="#importOpae">
                                        <i class="fa-solid fa-cloud-upload"></i>
                                        Import Excel
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="basicTable" class="table table-striped table-borderless table-bordered nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">ชื่อไฟล์</th>
                                        <th class="text-center">วันที่นำเข้า</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 0; @endphp
                                    @foreach ($history as $rs)
                                    @php $i++; @endphp
                                    <tr>
                                        <td class="text-center">{{ $i }}</td>
                                        <td class="text-center">
                                            <a href="{{ asset('uploads/'.$rs->ex_file) }}">
                                                {{ $rs->ex_file }}
                                            </a>
                                        </td>
                                        <td class="text-center">{{ date("d/m/Y", strtotime($rs->import_date)) }}</td>
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
<!-- Import Modal -->
<div class="modal fade" id="importOpae" tabindex="-1" aria-labelledby="importOpaeLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('debtor.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importOpaeLabel">
                        นำเข้าข้อมูล OPAE
                        <small class="text-danger">รองรับไฟล์ xls , xlsx เท่านั้น</small>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">เลือกไฟล์</label>
                        <input type="file" class="form-control-file" id="file" name="file">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    <button id="btnUpload" type="button" class="btn btn-success"
                        onclick="
                        Swal.fire({
                            icon: 'question',
                            title: 'ยืนยันการนำเข้าข้อมูล ?',
                            text: 'ข้อมูลจะถูกบันทึกในรายการลูกหนี้',
                            showCancelButton: true,
                            confirmButtonText: 'นำเข้า',
                            cancelButtonText: 'ยกเลิก'
                            }).then((result) => {
                            if (result.isConfirmed) {
                                document.getElementById('btnUpload').disabled = true;
                                let timerInterval;
                                form.submit()
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'กำลังนำเข้า',
                                    text: 'กรุณารอจนกว่าจะนำเข้าสำเร็จ ห้ามปิดหน้าจอนี้ !!',
                                    timerProgressBar: true,
                                    allowEscapeKey: false,
                                    allowOutsideClick: false,
                                    didOpen: () => {
                                        Swal.showLoading();
                                        const timer = Swal.getPopup().querySelector('b');
                                        timerInterval = setInterval(() => {
                                        timer.textContent = `${Swal.getTimerLeft()}`;
                                    }, 100);
                                },
                                willClose: () => {
                                    clearInterval(timerInterval);
                                }
                                }).then((result) => {
                                    if (result.dismiss === Swal.DismissReason.timer) {
                                        console.log('Import Success');
                                    }
                                });
                            }
                        });">
                        <i class="fa-solid fa-folder-plus"></i>
                        นำเข้าข้อมูล
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('script')

@endsection
