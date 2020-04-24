<div class="filters-box row">

    @foreach ($filters as $f)

        @if ($f->type == 'select')
            @component('phpdt::filters.select',['data'=>$f->data])
                @slot('id') {{$f->id}}@endslot
                @slot('url') {{$f->url}}@endslot
                @slot('name') {{$f->name}}@endslot
                @slot('label') {{$f->label}}@endslot
                @slot('op') {{$f->op}}@endslot
            @endcomponent
        @endif
        @if ($f->type == 'text')
            @component('phpdt::filters.text',['data'=>$f->data])
                @slot('id') {{$f->id}}@endslot
                @slot('url') {{$f->url}}@endslot
                @slot('name') {{$f->name}}@endslot
                @slot('label') {{$f->label}}@endslot
                @slot('op') {{$f->op}}@endslot
            @endcomponent
        @endif
        @if ($f->type == 'hidden')
            @component('phpdt::filters.hidden',['data'=>$f->data])
                @slot('id') {{$f->id}}@endslot
                @slot('url') {{$f->url}}@endslot
                @slot('name') {{$f->name}}@endslot
                @slot('label') {{$f->label}}@endslot
                @slot('op') {{$f->op}}@endslot
            @endcomponent
        @endif
    @endforeach
<div class="clearfix"></div></div>
