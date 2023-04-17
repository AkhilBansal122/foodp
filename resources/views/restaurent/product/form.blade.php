
<div class="col-md-3">
    <div class="form-group">
        <label for="title" class="form-label">Product Name: <span style="color:red">*</span></label>
        <input type="text" name="title" 
        value="{{(isset($data ) && !empty($data->product_name)) ? $data->product_name:''}}" 
        class="form-control" placholder="Please Enter Name" placeholder="Please enter name" required id="product_name">
        @if($errors->has('product_name'))<div class="error">{{ $errors->first('product_name') }}</div>@endif
    </div>
</div>
<div class="col-12">
    <button type="submit" class="btn btn-light px-5"> {{isset($data->id) ? 'Update' :'Save' }}</button>
    <a href="{{route('restaurent.product')}}" class="btn btn-primary px-5">Back</a>
</div>
		