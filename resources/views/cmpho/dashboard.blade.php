@extends('app.main')
@section('content')
<div class="content-wrapper">
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ number_format($opae) }} <sup style="font-size: 20px">รายการ</sup></h3>
                            <p>ข้อมูล OPAE รอประมวลผล</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-rotate"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3>{{ number_format($sopae) }} <sup style="font-size: 20px">รายการ</sup></h3>
                            <p>ข้อมูล OPAE เสร็จสิ้น</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-file-circle-check"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ number_format($ctmri) }} <sup style="font-size: 20px">รายการ</sup></h3>
                            <p>ข้อมูล CT - MRI รอประมวลผล</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-rotate"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3>{{ number_format($sctmri) }} <sup style="font-size: 20px">รายการ</sup></h3>
                            <p>ข้อมูล CT - MRI เสร็จสิ้น</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-file-circle-check"></i>
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
