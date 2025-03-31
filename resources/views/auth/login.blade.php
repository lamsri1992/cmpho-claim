<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ลงชื่อเข้าใช้งานระบบ</title>
    <link rel="stylesheet" href="{{ asset('template/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/dist/css/adminlte.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai&display=swap" rel="stylesheet">
</head>
<style>
    * {
        font-family: "Noto Sans Thai", sans-serif;
        font-optical-sizing: auto;
        font-weight: 400;
        font-style: normal;
        font-variation-settings:
        "wdth" 100;
    }
</style>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline card-success">
            <div class="card-header text-center">
                <div class="text-center">
                    <img src="{{ asset('img/logo_cmh.png') }}" width="60%">
                </div>
            </div>
            <div class="card-body">
                <p class="login-box-msg">กรุณาลงชื่อเข้าใช้งานระบบ</p>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="อีเมล์">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <small class="text-danger">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </small>
                    <div class="input-group mb-3">
                        <input type="password" id="password" name="password" class="form-control" placeholder="รหัสผ่าน">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <small class="text-danger">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </small>
                    <div class="row mb-2">
                        <div class="col-12">
                            <button type="submit" class="btn btn-success btn-block">เข้าสู่ระบบ</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-12 mt-4 text-center text-muted">
            <small>โปรแกรมการบริหารจัดการข้อมูลชดเชยค่าบริการทางการแพทย์ ระหว่างหน่วยบริการในจังหวัดเชียงใหม่</small>
        </div>
    </div>

    <script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('template/dist/js/adminlte.min.js') }}"></script>
</body>

</html>
