<div class="form-group">
    <button type="button" class="btn btn-border" data-toggle="collapse"
            data-target="#cities">Bericht doorplaatsen op:
    </button>
    <div class="collapse mt-2" id="cities">
        @php
            $count = count(config('cities'));
            $rows = ($count / 2) - 1;
        @endphp
        <div class="row">
            <div class="col-12 col-md-6">
                @foreach(config('cities') as $city)
                    @if(config('siteName') == $city->name)
                        @continue
                    @endif
                    <input type="checkbox" name="cities[]" value="{{$city->id}}"
                           @if($mode == 'edit') @if(in_array($city->id, $doorgeplaatstIds)) checked="checked" @endif @endif>
                    <label for="cities[]">{{$city->name}}</label>
                    <br>
                    @if($rows == $loop->index)
            </div>
            <div class="col-12 col-md-6">
                @endif
                @endforeach
            </div>
        </div>
    </div>
</div>