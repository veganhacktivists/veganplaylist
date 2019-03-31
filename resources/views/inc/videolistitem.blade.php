<li class="list-group-item" id="list_item_{{ $video->id }}">
    <div class="d-flex align-items-center flex-row">
        <div class="mr-2">@include('inc.videothumb')</div>
        <div class="font-weight-bold text-wrap title">{{ $video->title }}</div>
        <a href="#" data-id="{{ $video->id }}" class="remove text-danger ml-2">
            <i class="fas fa-trash-alt"></i>
        </a>
    </div>
</li>
