@if(isset($user['id']))
    @include('cabinet.document.content.info_authorized')
@else
    @include('cabinet.document.content.info_public')
@endif
