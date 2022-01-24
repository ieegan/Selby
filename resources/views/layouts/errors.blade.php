@if (count($errors))
<div class="notification is-danger">
	<ul>
		@foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
@elseif (session('error'))
<div class="notification is-danger">
	<ul>
		@foreach (session('error') as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
@endif
