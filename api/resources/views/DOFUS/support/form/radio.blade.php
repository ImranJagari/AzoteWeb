<div class="form-group ">
    <label class="control-label">{{ $name }}</label>
    @if (isset($choice->child))
        <input type="radio" class="form-control" name="text|{{ $name }}" value="child|{{ $choice->value }}|{{ $choice->child }}"> {{ $choice->value }}<br>
    @else
        <input type="radio" class="form-control" name="text|{{ $name }}" value="final|{{ $choice->value }}"> {{ $choice->value }}<br>
    @endif
</div>