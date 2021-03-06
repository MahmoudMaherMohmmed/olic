<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.suppliers.name')<span class="text-danger">*</span></label>
    <div class="col-sm-9 col-lg-10 controls">
      <select class="form-control chosen-rtl" name="supplier_id" required>
        @foreach($suppliers as $supplier)
            <option value="{{$supplier->id}}">{{$supplier->name}}</option>
        @endforeach
      </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 col-lg-2 control-label">@lang('messages.oils.oils')<span class="text-danger">*</span></label>
    <div class="col-sm-9 col-lg-10">
        <div id="supplies_div" class="row">
        </div>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 col-md-2 control-label">@lang('messages.Image.Image') <span
            class="text-danger">*</span></label>
    <div class="col-sm-9 col-md-8 controls">
        <div class="fileupload fileupload-new" data-provides="fileupload">
            <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                @if($supply)
                    <img src="{{url($supply->image)}}" alt="" />
                @else
                    <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
                @endif
            </div>
            <div class="fileupload-preview fileupload-exists img-thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
            <div>
                <span class="btn btn-file"><span class="fileupload-new">@lang('messages.select_image')</span>
                    <span class="fileupload-exists">Change</span>
                    {!! Form::file('image',["accept"=>"image/*" ,"class"=>"default"]) !!}
                </span>
                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
            </div>
        </div>
        <span class="label label-important">NOTE!</span>
        <span>Only extensions supported png, jpg, and jpeg</span>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
        {!! Form::submit($buttonAction,['class'=>'btn btn-primary']) !!}
    </div>
</div>

@section('script')
    <script>
        $(document).ready(function(){
            var supply_html = createSuppliesDivHTML();
                
            $("#supplies_div").append( supply_html );
        });

        function createSuppliesDivHTML(){
            var supply_html = '<div id="supply_div">';
                supply_html +='    <div class="col-sm-8 col-lg-8 controls" style="padding-bottom: 7px;">';
                supply_html +='        <select class="form-control chosen-rtl" name="oil_ids[]" required>';
                                @foreach($oils as $oil)
                supply_html +='            <option value="{{$oil->id}}">{{$oil->getTranslation("name", Session::get("applocale"))}}</option>';
                                @endforeach
                supply_html +='        </select>';
                supply_html +='    </div>';
                supply_html +='    <div class="col-sm-3 col-lg-3 controls" style="padding-bottom: 7px;">';
                supply_html +='        <input type="number" class="form-control" name="quantities[]" placeholder="Quantity"/>';
                supply_html +='    </div>';
                supply_html +='    <div class="col-sm-1 col-lg-1" style="padding-bottom: 7px;">';
                supply_html +='        <a class="btn btn-success" onclick="addSupplyDiv(this)" data-original-title="Create New Supply"><i class="fa fa-plus"></i></a>';
                supply_html +='    </div>';
                supply_html +='</div>';


            return supply_html;
        }

        function addSupplyDiv(element){
            var supply_html = createSuppliesDivHTML();
           
            $("#supplies_div").append( supply_html );

            updateSupplyDiv(element);
        }

        function updateSupplyDiv(element){
            var supply_div = $(element).parent().parent();

            $(element).parent().remove();

            var remove_supply_button_html = removeSupplyButtonHTML();
                
            supply_div.append( remove_supply_button_html );
        }

        function removeSupplyButtonHTML(){
            var button_html  ='    <div class="col-sm-1 col-lg-1" style="padding-bottom: 7px;">';
                button_html +='        <a class="btn btn-danger" onclick="removeSupplyDiv(this)" data-original-title="Remove Supply"><i class="fa fa-trash"></i></a>';
                button_html +='    </div>';

            return button_html;
        }

        function removeSupplyDiv(element){
            $(element).parent().parent().remove();
        }
    </script>
@endsection
