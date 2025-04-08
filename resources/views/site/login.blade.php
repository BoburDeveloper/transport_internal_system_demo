<!DOCTYPE html>
<html lang="en">
@include('parts.head')
<body class="wrapper1">

<?php
use App\Models\Data;
?>
<style>
    .wrapper1{
        background-image: url({{asset('/img/bg2.jpg')}});
    }
</style>

<div class="row">
    <div class="col-lg-4 col-xs-12 offset-lg-4 form-box card-body login-panel">
        <div class="form-group">
            <div class="col-12 text-center">
                <h3 class="mb-0"><b>
                    {{__('messages.sign_in')}}
                    </b></h3>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                @php
                    $i=0;
                @endphp
                    @foreach ($errors->all() as $error)
                    @php
                        $i++;
                    @endphp
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <style>
            .login-footer{
                bottom: {{$i==1 ? -60 : -100}}px;
            }
            </style>
        @endif

        @if(session()->has('msg'))
            <div class="alert alert-{{session()->get('css_class')}}">{{session('msg')}}</div>
        @endif
        <form action="" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form-group">
                <label for="inputName">{{__('messages.username')}}</label>
                <input type="text" name="signin[username]" id="inputName" class="form-control" required1>
            </div>
            <div class="form-group">
                <label for="inputEmail">{{__('messages.password')}}</label>
                <input type="password" name="signin[password]" id="inputEmail" class="form-control" required1>
            </div>
            <div class="form-group">
                <label for="inputEmail">{{__('messages.captcha')}}</label>
                <div class="row">
                    <div id="captcha-img" class="col-4"> {!!captcha_img()!!}
                        <a href="javascript:void(0)" class="captcha-refresh-btn" onclick="refreshCaptcha()"><i class="fa fa-sync"></i></a>
                    </div>
                    <div class="col-4">
                        <input type="number" name="captcha" class="form-control" required1>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">{{__('messages.sign_in')}}</button>
            </div>
        </form>
    </div>
    <div class="clearfix"></div>
</div>
<div class="clearfix"></div>
<footer class="main-footer login-footer row col-12">
    @include('layouts.copyright')
    &nbsp;
    @include('layouts.version')
    <div class="clearfix"></div>
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
