<div class="col-md-3">
     <div class="form-group">
         <label class="" for="filter-{{$label}}">{{$name}}:</label>
        <select
                data-op="{{$op}}"
                data-fieldname="{{$name}}"
                type="text"
                name="{{$id }}"
                id="{{$id}}"
                class="form-control datatable_filters datatable_filters_select filterbox"
        >


            @foreach($data as $key => $value)
                <option value="{{$key}}">{{$value}}</option>
            @endforeach

        </select>
     </div>

 </div>