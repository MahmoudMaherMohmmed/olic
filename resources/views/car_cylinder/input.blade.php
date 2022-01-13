<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.name') <span class="text-danger">*</span></label>
    <div class="col-sm-9 col-lg-10 controls">
        <ul id="myTab1" class="nav nav-tabs">
            <?php $i = 0; ?>
            @foreach ($languages as $language)
                <li class="{{ $i++ ? '' : 'active' }}"><a href="#name{{ $language->short_code }}"
                        data-toggle="tab">
                        {{ $language->title }}</a></li>
            @endforeach
        </ul>
        <div class="tab-content">
            <?php $i = 0; ?>
            @foreach ($languages as $language)
                <div class="tab-pane fade in {{ $i++ ? '' : 'active' }}" id="name{{ $language->short_code }}">
                    <input class="form-control" name="name[{{ $language->short_code }}]" value="@if ($car_cylinder) {!! $car_cylinder->getTranslation('name', $language->short_code) !!} @endif" />
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.description') <span
            class="text-danger">*</span></label>
    <div class="col-sm-9 col-lg-10 controls">
        <ul id="myTab1" class="nav nav-tabs">
            <?php $i = 0; ?>
            @foreach ($languages as $language)
                <li class="{{ $i++ ? '' : 'active' }}"><a href="#description{{ $language->short_code }}"
                        data-toggle="tab"> {{ $language->title }}</a></li>
            @endforeach
        </ul>
        <div class="tab-content">
            <?php $i = 0; ?>
            @foreach ($languages as $language)
                <div class="tab-pane fade in {{ $i++ ? '' : 'active' }}"
                    id="description{{ $language->short_code }}">
                    <textarea class="form-control col-md-12"
                        name="description[{{ $language->short_code }}]" 
                        rows="6">{{ $car_cylinder!=null ? $car_cylinder->getTranslation('description', $language->short_code) : old('description.' . $language->short_code)}}
                    </textarea>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
        {!! Form::submit($buttonAction,['class'=>'btn btn-primary']) !!}
    </div>
</div>
