@extends('backend.layouts.master')

@section('title', 'Edit Shipping Policy')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-truck mr-2"></i>
                        Edit Shipping Policy
                    </h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.shipping-policy.update', $shippingPolicy->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hero_title">Hero Title</label>
                                    <input type="text" class="form-control" id="hero_title" name="hero_title"
                                           value="{{ old('hero_title', $shippingPolicy->hero_title) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hero_subtitle">Hero Subtitle</label>
                                    <textarea class="form-control" id="hero_subtitle" name="hero_subtitle" rows="3" required>{{ old('hero_subtitle', $shippingPolicy->hero_subtitle) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <h5 class="text-primary mb-3">Our Shipping Commitment</h5>
                        <div class="form-group">
                            <label for="introduction">Introduction</label>
                            <textarea class="form-control tinymce-editor" id="introduction" name="introduction" rows="6">{{ old('introduction', $shippingPolicy->introduction) }}</textarea>
                        </div>

                        <hr>
                        <h5 class="text-primary mb-3">Delivery Areas</h5>
                        <div class="form-group">
                            <label for="current_coverage">Current Coverage</label>
                            <textarea class="form-control tinymce-editor" id="current_coverage" name="current_coverage" rows="6">{{ old('current_coverage', $shippingPolicy->current_coverage) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="expansion_plans">Expansion Plans</label>
                            <textarea class="form-control tinymce-editor" id="expansion_plans" name="expansion_plans" rows="6">{{ old('expansion_plans', $shippingPolicy->expansion_plans) }}</textarea>
                        </div>

                        <hr>
                        <h5 class="text-primary mb-3">Delivery Timeframes</h5>
                        <div class="form-group">
                            <label for="standard_delivery_time">Standard Delivery</label>
                            <textarea class="form-control tinymce-editor" id="standard_delivery_time" name="standard_delivery_time" rows="6">{{ old('standard_delivery_time', $shippingPolicy->standard_delivery_time) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="express_delivery_time">Express Delivery</label>
                            <textarea class="form-control tinymce-editor" id="express_delivery_time" name="express_delivery_time" rows="6">{{ old('express_delivery_time', $shippingPolicy->express_delivery_time) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="scheduled_delivery">Scheduled Delivery</label>
                            <textarea class="form-control tinymce-editor" id="scheduled_delivery" name="scheduled_delivery" rows="6">{{ old('scheduled_delivery', $shippingPolicy->scheduled_delivery) }}</textarea>
                        </div>

                        <hr>
                        <h5 class="text-primary mb-3">Shipping Charges</h5>
                        <div class="form-group">
                            <label for="standard_delivery_rates">Standard Delivery Rates</label>
                            <textarea class="form-control tinymce-editor" id="standard_delivery_rates" name="standard_delivery_rates" rows="6">{{ old('standard_delivery_rates', $shippingPolicy->standard_delivery_rates) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="additional_services">Additional Services</label>
                            <textarea class="form-control tinymce-editor" id="additional_services" name="additional_services" rows="6">{{ old('additional_services', $shippingPolicy->additional_services) }}</textarea>
                        </div>

                        <hr>
                        <h5 class="text-primary mb-3">Order Processing</h5>
                        <div class="form-group">
                            <label for="order_confirmation">Order Confirmation</label>
                            <textarea class="form-control tinymce-editor" id="order_confirmation" name="order_confirmation" rows="6">{{ old('order_confirmation', $shippingPolicy->order_confirmation) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="quality_assurance">Quality Assurance</label>
                            <textarea class="form-control tinymce-editor" id="quality_assurance" name="quality_assurance" rows="6">{{ old('quality_assurance', $shippingPolicy->quality_assurance) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="dispatch_process">Dispatch Process</label>
                            <textarea class="form-control tinymce-editor" id="dispatch_process" name="dispatch_process" rows="6">{{ old('dispatch_process', $shippingPolicy->dispatch_process) }}</textarea>
                        </div>

                        <hr>
                        <h5 class="text-primary mb-3">Packaging Standards</h5>
                        <div class="form-group">
                            <label for="fresh_produce_packaging">Fresh Produce</label>
                            <textarea class="form-control tinymce-editor" id="fresh_produce_packaging" name="fresh_produce_packaging" rows="6">{{ old('fresh_produce_packaging', $shippingPolicy->fresh_produce_packaging) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="dairy_perishables_packaging">Dairy & Perishables</label>
                            <textarea class="form-control tinymce-editor" id="dairy_perishables_packaging" name="dairy_perishables_packaging" rows="6">{{ old('dairy_perishables_packaging', $shippingPolicy->dairy_perishables_packaging) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="packaged_goods_packaging">Packaged Goods</label>
                            <textarea class="form-control tinymce-editor" id="packaged_goods_packaging" name="packaged_goods_packaging" rows="6">{{ old('packaged_goods_packaging', $shippingPolicy->packaged_goods_packaging) }}</textarea>
                        </div>

                        <hr>
                        <h5 class="text-primary mb-3">Delivery Process</h5>
                        <div class="form-group">
                            <label for="before_delivery">Before Delivery</label>
                            <textarea class="form-control tinymce-editor" id="before_delivery" name="before_delivery" rows="6">{{ old('before_delivery', $shippingPolicy->before_delivery) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="during_delivery">During Delivery</label>
                            <textarea class="form-control tinymce-editor" id="during_delivery" name="during_delivery" rows="6">{{ old('during_delivery', $shippingPolicy->during_delivery) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="after_delivery">After Delivery</label>
                            <textarea class="form-control tinymce-editor" id="after_delivery" name="after_delivery" rows="6">{{ old('after_delivery', $shippingPolicy->after_delivery) }}</textarea>
                        </div>

                        <hr>
                        <h5 class="text-primary mb-3">Special Circumstances</h5>
                        <div class="form-group">
                            <label for="weather_conditions">Weather Conditions</label>
                            <textarea class="form-control tinymce-editor" id="weather_conditions" name="weather_conditions" rows="6">{{ old('weather_conditions', $shippingPolicy->weather_conditions) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="product_unavailability">Product Unavailability</label>
                            <textarea class="form-control tinymce-editor" id="product_unavailability" name="product_unavailability" rows="6">{{ old('product_unavailability', $shippingPolicy->product_unavailability) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="failed_delivery_attempts">Failed Delivery Attempts</label>
                            <textarea class="form-control tinymce-editor" id="failed_delivery_attempts" name="failed_delivery_attempts" rows="6">{{ old('failed_delivery_attempts', $shippingPolicy->failed_delivery_attempts) }}</textarea>
                        </div>

                        <hr>
                        <h5 class="text-primary mb-3">International Shipping</h5>
                        <div class="form-group">
                            <label for="international_shipping">International Shipping Content</label>
                            <textarea class="form-control tinymce-editor" id="international_shipping" name="international_shipping" rows="6">{{ old('international_shipping', $shippingPolicy->international_shipping) }}</textarea>
                        </div>

                        <hr>
                        <h5 class="text-primary mb-3">Shipping Support</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="shipping_hotline">Shipping Hotline</label>
                                    <input type="text" class="form-control" id="shipping_hotline" name="shipping_hotline"
                                           value="{{ old('shipping_hotline', $shippingPolicy->shipping_hotline) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="shipping_email">Email</label>
                                    <input type="email" class="form-control" id="shipping_email" name="shipping_email"
                                           value="{{ old('shipping_email', $shippingPolicy->shipping_email) }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="support_hours">Support Hours</label>
                                    <input type="text" class="form-control" id="support_hours" name="support_hours"
                                           value="{{ old('support_hours', $shippingPolicy->support_hours) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="live_chat">Live Chat</label>
                                    <input type="text" class="form-control" id="live_chat" name="live_chat"
                                           value="{{ old('live_chat', $shippingPolicy->live_chat) }}" required>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1"
                                       {{ old('is_active', $shippingPolicy->is_active) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">Active</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Shipping Policy
                            </button>
                            <a href="{{ route('admin.shipping-policy.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>

                    </form>
                </div>
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