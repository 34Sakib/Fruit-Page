@extends('backend.layouts.master')

@section('title', 'Create Return Policy')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create Return Policy</h3>
                </div>

                <form action="{{ route('admin.return-policy.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <!-- Hero Section -->
                        <h5 class="text-primary mb-3">Hero Section</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hero_title">Hero Title <span class="text-danger">*</span></label>
                                    <input type="text" name="hero_title" id="hero_title" class="form-control @error('hero_title') is-invalid @enderror" value="{{ old('hero_title', 'Return Policy') }}" required>
                                    @error('hero_title')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hero_subtitle">Hero Subtitle</label>
                                    <input type="text" name="hero_subtitle" id="hero_subtitle" class="form-control @error('hero_subtitle') is-invalid @enderror" value="{{ old('hero_subtitle') }}">
                                    @error('hero_subtitle')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Introduction -->
                        <h5 class="text-primary mb-3">Introduction</h5>
                        <div class="form-group">
                            <label for="introduction">Our Return Promise</label>
                            <textarea name="introduction" id="introduction" class="form-control tinymce-editor @error('introduction') is-invalid @enderror" rows="5">{{ old('introduction') }}</textarea>
                            @error('introduction')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <!-- Return Eligibility -->
                        <h5 class="text-primary mb-3">Return Eligibility</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fresh_produce_eligibility">Fresh Produce (Fruits & Vegetables)</label>
                                    <textarea name="fresh_produce_eligibility" id="fresh_produce_eligibility" class="form-control tinymce-editor @error('fresh_produce_eligibility') is-invalid @enderror" rows="5">{{ old('fresh_produce_eligibility') }}</textarea>
                                    @error('fresh_produce_eligibility')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dairy_perishables_eligibility">Dairy & Perishables</label>
                                    <textarea name="dairy_perishables_eligibility" id="dairy_perishables_eligibility" class="form-control tinymce-editor @error('dairy_perishables_eligibility') is-invalid @enderror" rows="5">{{ old('dairy_perishables_eligibility') }}</textarea>
                                    @error('dairy_perishables_eligibility')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="packaged_foods_eligibility">Packaged & Processed Foods</label>
                                    <textarea name="packaged_foods_eligibility" id="packaged_foods_eligibility" class="form-control tinymce-editor @error('packaged_foods_eligibility') is-invalid @enderror" rows="5">{{ old('packaged_foods_eligibility') }}</textarea>
                                    @error('packaged_foods_eligibility')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="non_returnable_items">Non-Returnable Items</label>
                                    <textarea name="non_returnable_items" id="non_returnable_items" class="form-control tinymce-editor @error('non_returnable_items') is-invalid @enderror" rows="5">{{ old('non_returnable_items') }}</textarea>
                                    @error('non_returnable_items')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Return Process -->
                        <h5 class="text-primary mb-3">Return Process</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact_customer_service">Step 1: Contact Customer Service</label>
                                    <textarea name="contact_customer_service" id="contact_customer_service" class="form-control tinymce-editor @error('contact_customer_service') is-invalid @enderror" rows="5">{{ old('contact_customer_service') }}</textarea>
                                    @error('contact_customer_service')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="documentation_required">Step 2: Documentation Required</label>
                                    <textarea name="documentation_required" id="documentation_required" class="form-control tinymce-editor @error('documentation_required') is-invalid @enderror" rows="5">{{ old('documentation_required') }}</textarea>
                                    @error('documentation_required')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="return_approval">Step 3: Return Approval</label>
                                    <textarea name="return_approval" id="return_approval" class="form-control tinymce-editor @error('return_approval') is-invalid @enderror" rows="5">{{ old('return_approval') }}</textarea>
                                    @error('return_approval')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="product_return_step">Step 4: Product Return</label>
                                    <textarea name="product_return_step" id="product_return_step" class="form-control tinymce-editor @error('product_return_step') is-invalid @enderror" rows="5">{{ old('product_return_step') }}</textarea>
                                    @error('product_return_step')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Refund Options -->
                        <h5 class="text-primary mb-3">Refund Options</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="full_refund">Full Refund</label>
                                    <textarea name="full_refund" id="full_refund" class="form-control tinymce-editor @error('full_refund') is-invalid @enderror" rows="5">{{ old('full_refund') }}</textarea>
                                    @error('full_refund')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="store_credit">Store Credit</label>
                                    <textarea name="store_credit" id="store_credit" class="form-control tinymce-editor @error('store_credit') is-invalid @enderror" rows="5">{{ old('store_credit') }}</textarea>
                                    @error('store_credit')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="product_exchange">Product Exchange</label>
                                    <textarea name="product_exchange" id="product_exchange" class="form-control tinymce-editor @error('product_exchange') is-invalid @enderror" rows="5">{{ old('product_exchange') }}</textarea>
                                    @error('product_exchange')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Special Circumstances -->
                        <h5 class="text-primary mb-3">Special Circumstances</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="wrong_item_delivered">Wrong Item Delivered</label>
                                    <textarea name="wrong_item_delivered" id="wrong_item_delivered" class="form-control tinymce-editor @error('wrong_item_delivered') is-invalid @enderror" rows="5">{{ old('wrong_item_delivered') }}</textarea>
                                    @error('wrong_item_delivered')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="quality_issues">Quality Issues</label>
                                    <textarea name="quality_issues" id="quality_issues" class="form-control tinymce-editor @error('quality_issues') is-invalid @enderror" rows="5">{{ old('quality_issues') }}</textarea>
                                    @error('quality_issues')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="delivery_delays">Delivery Delays</label>
                                    <textarea name="delivery_delays" id="delivery_delays" class="form-control tinymce-editor @error('delivery_delays') is-invalid @enderror" rows="5">{{ old('delivery_delays') }}</textarea>
                                    @error('delivery_delays')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Return Timeframes -->
                        <h5 class="text-primary mb-3">Return Timeframes</h5>

                        <!-- Fresh Produce -->
                        <div class="row border-bottom pb-3 mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Category</label>
                                    <input type="text" class="form-control" value="Fresh Produce" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fresh_produce_timeframe">Return Window</label>
                                    <input type="text" name="fresh_produce_timeframe" id="fresh_produce_timeframe" class="form-control @error('fresh_produce_timeframe') is-invalid @enderror" value="{{ old('fresh_produce_timeframe', '24 Hours') }}" placeholder="e.g. 24 Hours">
                                    @error('fresh_produce_timeframe')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fresh_produce_conditions">Conditions</label>
                                    <input type="text" name="fresh_produce_conditions" id="fresh_produce_conditions" class="form-control @error('fresh_produce_conditions') is-invalid @enderror" value="{{ old('fresh_produce_conditions', 'Quality issues only') }}" placeholder="e.g. Quality issues only">
                                    @error('fresh_produce_conditions')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Dairy & Perishables -->
                        <div class="row border-bottom pb-3 mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Category</label>
                                    <input type="text" class="form-control" value="Dairy & Perishables" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="dairy_timeframe">Return Window</label>
                                    <input type="text" name="dairy_timeframe" id="dairy_timeframe" class="form-control @error('dairy_timeframe') is-invalid @enderror" value="{{ old('dairy_timeframe', '48 Hours') }}" placeholder="e.g. 48 Hours">
                                    @error('dairy_timeframe')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="dairy_conditions">Conditions</label>
                                    <input type="text" name="dairy_conditions" id="dairy_conditions" class="form-control @error('dairy_conditions') is-invalid @enderror" value="{{ old('dairy_conditions', 'Unopened, before expiry') }}" placeholder="e.g. Unopened, before expiry">
                                    @error('dairy_conditions')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Packaged Foods -->
                        <div class="row border-bottom pb-3 mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Category</label>
                                    <input type="text" class="form-control" value="Packaged Foods" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="packaged_foods_timeframe">Return Window</label>
                                    <input type="text" name="packaged_foods_timeframe" id="packaged_foods_timeframe" class="form-control @error('packaged_foods_timeframe') is-invalid @enderror" value="{{ old('packaged_foods_timeframe', '7 Days') }}" placeholder="e.g. 7 Days">
                                    @error('packaged_foods_timeframe')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="packaged_foods_conditions">Conditions</label>
                                    <input type="text" name="packaged_foods_conditions" id="packaged_foods_conditions" class="form-control @error('packaged_foods_conditions') is-invalid @enderror" value="{{ old('packaged_foods_conditions', 'Unopened packaging') }}" placeholder="e.g. Unopened packaging">
                                    @error('packaged_foods_conditions')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Wrong Items -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Category</label>
                                    <input type="text" class="form-control" value="Wrong Items" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="wrong_items_timeframe">Return Window</label>
                                    <input type="text" name="wrong_items_timeframe" id="wrong_items_timeframe" class="form-control @error('wrong_items_timeframe') is-invalid @enderror" value="{{ old('wrong_items_timeframe', '48 Hours') }}" placeholder="e.g. 48 Hours">
                                    @error('wrong_items_timeframe')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="wrong_items_conditions">Conditions</label>
                                    <input type="text" name="wrong_items_conditions" id="wrong_items_conditions" class="form-control @error('wrong_items_conditions') is-invalid @enderror" value="{{ old('wrong_items_conditions', 'Any condition accepted') }}" placeholder="e.g. Any condition accepted">
                                    @error('wrong_items_conditions')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Customer Responsibilities -->
                        <h5 class="text-primary mb-3">Customer Responsibilities</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="product_inspection">Product Inspection</label>
                                    <textarea name="product_inspection" id="product_inspection" class="form-control tinymce-editor @error('product_inspection') is-invalid @enderror" rows="5">{{ old('product_inspection') }}</textarea>
                                    @error('product_inspection')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="return_preparation">Return Preparation</label>
                                    <textarea name="return_preparation" id="return_preparation" class="form-control tinymce-editor @error('return_preparation') is-invalid @enderror" rows="5">{{ old('return_preparation') }}</textarea>
                                    @error('return_preparation')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="communication">Communication</label>
                                    <textarea name="communication" id="communication" class="form-control tinymce-editor @error('communication') is-invalid @enderror" rows="5">{{ old('communication') }}</textarea>
                                    @error('communication')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Return Support -->
                        <h5 class="text-primary mb-3">Return Support</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="return_hotline">Return Hotline</label>
                                    <input type="text" name="return_hotline" id="return_hotline" class="form-control @error('return_hotline') is-invalid @enderror" value="{{ old('return_hotline') }}">
                                    @error('return_hotline')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="return_email">Return Email</label>
                                    <input type="email" name="return_email" id="return_email" class="form-control @error('return_email') is-invalid @enderror" value="{{ old('return_email') }}">
                                    @error('return_email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="support_hours">Support Hours</label>
                                    <input type="text" name="support_hours" id="support_hours" class="form-control @error('support_hours') is-invalid @enderror" value="{{ old('support_hours') }}">
                                    @error('support_hours')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="live_chat">Live Chat</label>
                                    <input type="text" name="live_chat" id="live_chat" class="form-control @error('live_chat') is-invalid @enderror" value="{{ old('live_chat') }}">
                                    @error('live_chat')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="whatsapp">WhatsApp</label>
                                    <input type="text" name="whatsapp" id="whatsapp" class="form-control @error('whatsapp') is-invalid @enderror" value="{{ old('whatsapp') }}">
                                    @error('whatsapp')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Status -->
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="is_active" id="is_active" class="custom-control-input" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">Active</label>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Create Return Policy</button>
                        <a href="{{ route('admin.return-policy.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/trumbowyg@2.27.3/dist/ui/trumbowyg.min.css">
<script src="https://cdn.jsdelivr.net/npm/trumbowyg@2.27.3/dist/trumbowyg.min.js"></script>

<script>
$(document).ready(function() {
    $('.tinymce-editor').trumbowyg({
        btns: [
            ['viewHTML'],
            ['undo', 'redo'],
            ['formatting'],
            ['strong', 'em', 'del'],
            ['sup', 'sub'],
            ['link'],
            ['insertImage'],
            ['justifyLeft', 'justifyCenter', 'justifyRight'],
            ['unorderedList', 'orderedList'],
            ['horizontalRule'],
            ['removeformat'],
            ['fullscreen']
        ],
        autogrow: true,
        autogrowOnEnter: true,
        removeformatPasted: true,
        semantic: true,
        resetCss: true,
        tagsToRemove: ['script', 'style'],
        tagsToKeep: ['p', 'br', 'strong', 'em', 'u', 'ul', 'ol', 'li'],
        minimalLinks: true,
        imgWidthModalEdit: true
    });
});
</script>
@endsection
