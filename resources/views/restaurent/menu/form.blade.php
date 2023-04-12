<div class="row">
<input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <div class="col-xl-12">
        <div class="mb-3 row">
            <label class="col-lg-3 col-form-label" for="validationCustom01">Please
                select type
                <span class="text-danger">*</span>
            </label>
            <div class="col-lg-6">
                <div class="d-flex align-items-center veg justify-content-center">
                    <div class="form-check me-3 ">
                        <input class="form-check-input" type="radio" value="non_veg" {{(isset($data) && $data->type == 'non_veg') ? 'checked' : '' }} name="type" id="flexRadioDefault1">
                        <label class="form-check-label" for="type">Non veg</label>
                    </div>
                    <div class="form-check style-1">
                        <input class="form-check-input" type="radio" value="veg" {{(isset($data) && $data->type == 'veg') ? 'checked' : 'checked' }} name="type" id="flexRadioDefault2">
                        <label class="form-check-label" for="type">Veg</label>
                    </div>
                </div>
                @if ($errors->has('type'))
                       <span class="text-danger text-left">$errors->first('type')</span>
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
                    value="{{ old('name',(isset($data) && $data->name) ? $data->name : '') }}" 
                    id="validationCustom01" 
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
            <label class="col-lg-4 col-form-label" for="validationCustom02">Menu Image
                <span class="text-danger">*</span>
            </label>
            <div class="col-lg-6">
                <input 
                type="file" 
                class="form-control" 
                id="validationCustom02" 
                name="image"
               <?php echo isset($data) ? '' : 'required'   ?>
                >
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
              <img src="{{asset('public/')}}/{{$data->image}}"/>
            </div>
        </div>
        @endif
        <div class="mb-3 row">
            <div class="col-lg-8 ms-auto">
                <button type="submit" class="btn btn-primary">{{isset($data) ? 'Update' :'Save' }}</button>
                <a href="{{url('restaurent/menus')}}" class="btn  btn-light">Back</a>
            </div>
        </div>
    </div>
</div>