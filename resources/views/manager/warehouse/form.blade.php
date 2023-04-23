<div class="col-md-4">
    <div class="form-group">
        <label for="title" class="form-label">Select Product:  <span class="text-danger">*</span></label>
        
        <select class="form-control" name="product_id" required>
               <option value="">Select Product</option> 
               @if(!empty($product))
                    @foreach($product as $row)
                        <option value="{{$row->productDetails->id}}" {{ (isset($data->product_id) && $row->productDetails->id == $data->product_id) ? 'selected' : '' }} >{{$row->productDetails->product_name}} ( {{$row->qty_opt}} ) </option>
                    @endforeach
                @endif
        </select>
        @if($errors->has('product_id'))<div class="error">{{ $errors->first('product_id') }}</div>@endif
    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        <label for="qty" class="form-label">Qty Number : <span style="color:red">*</span></label>
        <input type="text" name="qty" 
        value="{{(isset($data ) && !empty($data->qty)) ? $data->qty:''}}" 
        class="form-control qty" placholder="Please Enter Qty in Number" required id="qty">
        @if($errors->has('qty'))<div class="error">{{ $errors->first('qty') }}</div>@endif
    </div>
</div>
<div class="col-md-4">
    <div class="form-group" style="margin-top: 17px;"><button type="submit" class="btn btn-light px-5"> {{isset($data->id) ? 'Update' :'Save' }}</button>
    </div>
</div>

		