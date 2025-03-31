@extends('app.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">ข้อมูลรอประมวลผล</li>
                        <li class="breadcrumb-item active">ข้อมูล CT - MRI</li>
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
                            <h5 class="card-title">รายการส่งข้อมูลแยกหน่วยบริการ</h5>
                        </div>
                        <div class="card-body">
                            <table id="nhso_table" class="table table-striped table-borderless table-bordered nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>หน่วยบริการ</th>
                                        <th class="text-center">จำนวนที่ส่ง</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 0; @endphp
                                    @foreach ($data as $rs)
                                    @php $i++; @endphp
                                    <tr>
                                        <td class="text-center">{{ $i }}</td>
                                        <td>{{ $rs->hcode." - ".$rs->h_name }}</td>
                                        <td class="text-center">{{ $rs->total." รายการ" }}</td>
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
                        text: '<i class="fa-solid fa-spinner fa-spin text-primary"></i> ประมวลผลข้อมูล',
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
                                title: 'ยืนยันการประมวลผลข้อมูล ?',
                                text: 'ประมวลผลข้อมูลเฉพาะข้อมูลที่นำส่ง',
                                showCancelButton: true,
                                confirmButtonText: "ประมวลผลข้อมูล",
                                cancelButtonText: "ยกเลิก",
                                confirmButtonColor: "#3085d6",
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        url:"{{ route('cmpho.ctmri.process') }}",
                                        method:'GET',
                                        success:function(data){
                                            let timerInterval
                                            Swal.fire({
                                                timer: 3000,
                                                timerProgressBar: true,
                                                title: 'กำลังประมวลผลข้อมูล',
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
                                                        title: 'ประมวลผลข้อมูลสำเร็จ',
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
