<!DOCTYPE html>
<html lang="en">
@include('parts.head')
<body class="wrapper1">

<?php
use App\Models\Data;
?>
<div class="row">
    <div class="col-4 offset-4 form-box card-body login-panel">
        <div class="form-group">
            <div class="col-12 text-center">
                <h3 class="mb-4"><b>
                    {{__('messages.sign_in')}}
                    </b></h3>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session()->has('msg'))
            <div class="alert alert-{{session()->get('css_class')}}">{{session('msg')}}</div>
        @endif
        <form action="" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form-group">
                <label for="inputName">Login</label>
                <input type="text" name="signin[username]" id="inputName" class="form-control" required1>
            </div>
            <div class="form-group">
                <label for="inputEmail">Password</label>
                <input type="password" name="signin[password]" id="inputEmail" class="form-control" required1>
            </div>
            <div class="form-group">
                <label for="inputEmail">Verification code</label>
                <div class="row">
                    <div id="captcha-img" class="col-3"> {!!captcha_img()!!}
                        <a href="javascript:void(0)" class="captcha-refresh-btn" onclick="refreshCaptcha()"><i class="fa fa-sync"></i></a>
                    </div>
                    <div class="col-4">
                        <input type="text" name="captcha" class="form-control" required1>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">{{__('messages.sign_in')}}</button>
            </div>
        </form>
    </div>
</div>
<footer class="main-footer login-footer">
    <strong>Copyright &copy; 2024 -  Разработано в «OOO QQM-IT SOLUTION»</strong>
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0</strong>
    </div>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
<script type="text/javascript">



    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    var lang_url = '{{url('/'.app()->getLocale())}}';
</script>
@include('parts.footer_scripts')
</body>
</html>
