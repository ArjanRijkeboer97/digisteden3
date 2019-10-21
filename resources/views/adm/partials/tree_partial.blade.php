<li style="list-style-type:none">
    <a class="clickable folder-item" data-id="{{ $directory['name'] }}">
        <i class="fa fa-folder"></i> {{ $directory['name'] }}
    </a>
</li>
	@if (count($directory['subfolders']) > 0)
	    <ul style="padding-left:25px">
	    @foreach($directory['subfolders'] as $directory)
	        @include('adm.partials.tree_partial', $directory)
	    @endforeach
	    </ul>
	@endif