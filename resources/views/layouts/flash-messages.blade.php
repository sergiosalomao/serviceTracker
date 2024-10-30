@if (session()->has('message-success'))
<div id="msg" class="alert alert-success">
   <span class="fa fa-info mx-3"></span>  {{ session('message-success') }}
</div>
@endif

@if (session()->has('message-danger'))
<div id="msg" class="alert alert-danger">
   <span class="fa fa-info mx-3"></span> {{ session('message-danger') }}
</div>
@endif

@if (session()->has('message-warning'))
<div id="msg" class="alert alert-warning">
   <span class="fa fa-info mx-3"></span>{{ session('message-warning') }}
</div>
@endif

