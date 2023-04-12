<div class="row">
<input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <div class="col-xl-12">
        <div class="mb-3 row">
            <label class="col-lg-4 col-form-label" for="validationCustom01">Select Menu
                <span class="text-danger">*</span>
            </label>
            <div class="col-lg-6">
               <select class="form-control ms-0 wide" name="category_id" required>
               <option value="">Select Menu</option> 
               @if(!empty($menu))
                    @foreach($menu as $row)
                        <option value="{{$row->id}}" {{ (isset($data->category_id) && $row->id == $data->category_id) ? 'selected' : '' }} >{{$row->name}}</option>
                    @endforeach
                @endif
               </select>
                    @if ($errors->has('category_id'))
                       <span class="text-danger text-left">{{$errors->first('category_id')}}</span>
                    @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-lg-4 col-form-label" for="validationCustom01">Name
                <span class="text-danger">*</span>
            </label>
            <div class="col-lg-6">
                <input type="text" 
                    class="form-control" 
                    value="{{ old('name',(isset($data->name) && $data->name) ? $data->name : '') }}" 
                    placeholder="Enter a name.." 
                    name="name"
                    <?php echo isset($data) ? '' : 'required'   ?>
                    title="This field should not be left blank."
                    >
                    @if ($errors->has('name'))
                       <span class="text-danger text-left">{{$errors->first('name')}}</span>
                    @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-lg-4 col-form-label" for="validationCustom02">Menu Image (One)
                <span class="text-danger">*</span>
            </label>
            <div class="col-lg-6">
                <input 
                type="file" 
                class="form-control" 
                name="image"
               <?php echo isset($data->image) ? '' : 'required'   ?>>
                    @if ($errors->has('image'))
                       <span class="text-danger text-left">{{$errors->first('image')}}</span>
                    @endif

            </div>
        </div>
        @if(!empty($data->image))
            <div class="mb-3 row">
            <label class="col-lg-4 col-form-label" for="validationCustom02">Menu Image Preview
                <span class="text-danger">*</span>
            </label>
            <div class="col-lg-6">
              <img src="{{asset('public/')}}/{{$data->image}}" width="200" height="100"/>
            </div>
            </div>
        @endif
        <div class="mb-3 row">
            <label class="col-lg-4 col-form-label" for="validationCustom02">Menu Multiple
                <span class="text-danger">*</span>
            </label>
            <div class="col-lg-6">
                <input 
                type="file" 
                class="form-control" 
                name="images[]"
                multiple=""
               <?php echo isset($data->images) ? '' : 'required'   ?>>
                    @if ($errors->has('images'))
                       <span class="text-danger text-left">{{$errors->first('images')}}</span>
                    @endif
            </div>
        </div>
        @if(!empty($data->images))
            <div class="mb-3 row">
            <label class="col-lg-4 col-form-label" for="validationCustom02">Menu Image Preview
                <span class="text-danger">*</span>
            </label>
            <div class="col-lg-6">
           
            @foreach(explode(",",rtrim($data->images,",")) as $img)  
            <img src="{{asset('public/')}}/{{$img}}" width="100" height="100"/>
            @endforeach
            </div>
           
            </div>
        @endif
        
        <div class="mb-3 row">
            <label class="col-lg-4 col-form-label" for="validationCustom01">Price
                <span class="text-danger">*</span>
            </label>
            <div class="col-lg-6">
            <input type="text" 
                    class="form-control" 
                    value="{{ old('price',(isset($data->price) && $data->price) ? $data->price : '') }}" 
                    id="validationCustom01" 
                    placeholder="Enter a price.." 
                    name="price"
                    <?php echo isset($data) ? '' : 'required'   ?>
                    title="This field should not be left blank."
                    >
                    @if ($errors->has('price'))
                       <span class="text-danger text-left">{{$errors->first('price')}}</span>
                    @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-lg-4 col-form-label" for="validationCustom01">Discount
                <span class="text-danger">*</span>
            </label>
            <div class="col-lg-6">
            <input type="text" 
                    class="form-control" 
                    value="{{ old('discount',(isset($data->discount) && $data->discount) ? $data->discount : '') }}" 
                    id="validationCustom01" 
                    placeholder="Enter a discount.." 
                    name="discount"
                    title="This field should not be left blank.">
                    @if ($errors->has('discount'))
                       <span class="text-danger text-left">{{$errors->first('discount')}}</span>
                    @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-lg-4 col-form-label" for="validationCustom01">Description
                <span class="text-danger">*</span>
            </label>
            <div class="col-lg-6">
                <textarea placeholder="Enter a description.." name="description"  class="form-control" >{{ old('description',(isset($data->description) && $data->description) ? $data->description : '') }}</textarea>
                    @if ($errors->has('description'))
                       <span class="text-danger text-left">{{$errors->first('description')}}</span>
                    @endif
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-lg-8 ms-auto">
                <button type="submit" class="btn btn-primary">{{isset($data) ? 'Update' :'Save' }}</button>
                <a href="{{route('restaurent.sub_menu')}}" class="btn  btn-light">Back</a>
            </div>
        </div>
    </div>
</div>