@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
	<strong><span style="font-size:14px;">Success !</span></strong> 
	<br>
  <span style="font-size:14px;">{{session('success')}}</span>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">×</span>
  </button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
	<strong><span style="font-size:14px;">Error !</span></strong> 
	<br>
  <span style="font-size:14px;">{{session('error')}}</span>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">×</span>
  </button>
</div>
@endif

@if (count($errors) > 0)
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong><span style="font-size:14px;">Error !</span></strong> 
	<ul class="mb-0" style="font-size:14px;">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">×</span>
    </button>
		@foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
@endif