@extends('app.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item active">
                            <i class="fa-solid fa-folder-open"></i>
                            ข้อมูล 12 แฟ้ม
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="fa-regular fa-file"></i>
                                นำเข้าข้อมูล 12 แฟ้ม
                            </h5>
                        </div>
                        <form action="{{ route('twfiles.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <p class="card-text">
                                    นำเข้าข้อมูล 12 แฟ้ม ตามชื่อไฟล์ <span class="text-danger">รองรับไฟล์ .txt เท่านั้น</span>
                                </p>
                                <table class="table table-striped table-borderless table-bordered text-center" style="width:100%">
                                    <tr>
                                        <td>ADP</td>
                                        <td>
                                            <input type="file" class="form-control-file" id="ADP" name="ADP">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>AER</td>
                                        <td>
                                            <input type="file" class="form-control-file" id="AER" name="AER">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>CHA</td>
                                        <td>
                                            <input type="file" class="form-control-file" id="CHA" name="CHA">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>CHT</td>
                                        <td>
                                            <input type="file" class="form-control-file" id="CHT" name="CHT">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>DRU</td>
                                        <td>
                                            <input type="file" class="form-control-file" id="DRU" name="DRU">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>INS</td>
                                        <td>
                                            <input type="file" class="form-control-file" id="INS" name="INS">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>LAB</td>
                                        <td>
                                            <input type="file" class="form-control-file" id="LAB" name="LAB">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>ODX</td>
                                        <td>
                                            <input type="file" class="form-control-file" id="ODX" name="ODX">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>OOP</td>
                                        <td>
                                            <input type="file" class="form-control-file" id="OOP" name="OOP">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>OPD</td>
                                        <td>
                                            <input type="file" class="form-control-file" id="OPD" name="OPD">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>ORF</td>
                                        <td>
                                            <input type="file" class="form-control-file" id="ORF" name="ORF">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>PAT</td>
                                        <td>
                                            <input type="file" class="form-control-file" id="PAT" name="PAT">
                                        </td>
                                    </tr>
                                </table>
                                <div class="mt-3">
                                    <button id="btnUpload" type="button" class="btn btn-success"
                                        onclick="
                                        Swal.fire({
                                            icon: 'question',
                                            title: 'ยืนยันการนำเข้าข้อมูล 12 แฟ้ม ?',
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
                                        <i class="fa-solid fa-upload"></i>
                                        นำเข้าข้อมูล
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="fa-solid fa-spinner fa-spin"></i>
                                ประมวลผลข้อมูล
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                นับจำนวนข้อมูลแยกตามแฟ้ม
                            </p>
                            <table class="table table-striped table-borderless table-bordered text-center" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ADP</th>
                                        <th>AER</th>
                                        <th>CHA</th>
                                        <th>CHT</th>
                                        <th>DRU</th>
                                        <th>INS</th>
                                        <th>LAB</th>
                                        <th>ODX</th>
                                        <th>OOP</th>
                                        <th>OPD</th>
                                        <th>ORF</th>
                                        <th>PAT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($count as $rs)
                                    <tr>
                                        <td>
                                            <a href="{{ route('twfiles.view','ADP') }}">
                                                {{ number_format($rs->ADP) }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('twfiles.view','AER') }}">
                                                {{ number_format($rs->AER) }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('twfiles.view','CHA') }}">
                                                {{ number_format($rs->CHA) }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('twfiles.view','CHT') }}">
                                                {{ number_format($rs->CHT) }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('twfiles.view','DRU') }}">
                                                {{ number_format($rs->DRU) }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('twfiles.view','INS') }}">
                                                {{ number_format($rs->INS) }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('twfiles.view','LAB') }}">
                                                {{ number_format($rs->LAB) }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('twfiles.view','ODX') }}">
                                                {{ number_format($rs->ODX) }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('twfiles.view','OOP') }}">
                                                {{ number_format($rs->OOP) }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('twfiles.view','OPD') }}">
                                                {{ number_format($rs->OPD) }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('twfiles.view','ORF') }}">
                                                {{ number_format($rs->ORF) }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('twfiles.view','PAT') }}">
                                                {{ number_format($rs->PAT) }}
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
@endsection
@section('script')

@endsection
