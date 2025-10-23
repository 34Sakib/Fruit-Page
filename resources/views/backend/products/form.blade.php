@if(isset($product))
    {!! Form::model($product, ['route' => ['admin.products.update', $product->id], 'method' => 'PUT', 'files' => true]) !!}
@else
    {!! Form::open(['route' => 'admin.products.store', 'method' => 'POST', 'files' => true]) !!}
@endif

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    {!! Form::label('name', 'Product Name *') !!}
                    {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'required']) !!}
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    {!! Form::label('description', 'Description') !!}
                    {!! Form::textarea('description', null, ['class' => 'form-control' . ($errors->has('description') ? ' is-invalid' : ''), 'rows' => 4]) !!}
                    @error('description')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('price', 'Price *') !!}
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                {!! Form::number('price', null, ['class' => 'form-control' . ($errors->has('price') ? ' is-invalid' : ''), 'step' => '0.01', 'min' => '0', 'required']) !!}
                                @error('price')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('sale_price', 'Sale Price') !!}
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                {!! Form::number('sale_price', null, ['class' => 'form-control' . ($errors->has('sale_price') ? ' is-invalid' : ''), 'step' => '0.01', 'min' => '0']) !!}
                                @error('sale_price')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('quantity', 'Quantity *') !!}
                            {!! Form::number('quantity', null, ['class' => 'form-control' . ($errors->has('quantity') ? ' is-invalid' : ''), 'min' => '0', 'required']) !!}
                            @error('quantity')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('status', 'Status *') !!}
                            {!! Form::select('status', ['active' => 'Active', 'inactive' => 'Inactive'], null, ['class' => 'form-control' . ($errors->has('status') ? ' is-invalid' : ''), 'required']) !!}
                            @error('status')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                {!! Form::checkbox('is_featured', 1, isset($product) ? $product->is_featured : false, ['class' => 'custom-control-input', 'id' => 'is_featured']) !!}
                                {!! Form::label('is_featured', 'Mark as Featured', ['class' => 'custom-control-label']) !!}
                            </div>
                            <small class="form-text text-muted">Featured products will be shown on the homepage.</small>
                            @error('is_featured')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                {!! Form::checkbox('is_seasonal', 1, isset($product) ? $product->is_seasonal : false, ['class' => 'custom-control-input', 'id' => 'is_seasonal']) !!}
                                {!! Form::label('is_seasonal', 'Mark as Seasonal', ['class' => 'custom-control-label']) !!}
                            </div>
                            <small class="form-text text-muted">Seasonal products will be shown in the seasonal section.</small>
                            @error('is_seasonal')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('category_id', 'Category *') !!}
                    {!! Form::select('category_id', $categories, null, ['class' => 'form-control' . ($errors->has('category_id') ? ' is-invalid' : ''), 'placeholder' => 'Select Category', 'required']) !!}
                    @error('category_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('image', 'Product Image') !!}
                    <div class="custom-file">
                        {!! Form::file('image', ['class' => 'custom-file-input', 'id' => 'customFile']) !!}
                        <label class="custom-file-label" for="customFile">Choose file</label>
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    @if(isset($product) && $product->image)
                        <div class="mt-2">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="img-thumbnail" style="max-width: 200px;">
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Save Product
        </button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Cancel
        </a>
    </div>
</div>

{!! Form::close() !!}

@push('scripts')
<script>
    // Update the file input label with the selected file name
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        var fileName = e.target.files[0]?.name || 'Choose file';
        var nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
    });
</script>
@endpush
