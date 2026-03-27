@extends('backend.layouts.master')

@section('title', 'Edit Terms & Conditions')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Terms & Conditions</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.terms-conditions.index') }}" class="btn btn-default btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>

                <form action="{{ route('admin.terms-conditions.update', $termsConditions) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Hero Section -->
                        <h5>Hero Section</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hero_title">Hero Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="hero_title" name="hero_title" 
                                           value="{{ old('hero_title', $termsConditions->hero_title) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hero_subtitle">Hero Subtitle <span class="text-danger">*</span></label>
                                    <textarea class="form-control tinymce-editor" id="hero_subtitle" name="hero_subtitle" rows="2" required>{{ old('hero_subtitle', $termsConditions->hero_subtitle) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Content Sections -->
                        <h5>Content Sections</h5>
                        
                        <div class="form-group">
                            <label for="introduction">Introduction</label>
                            <textarea class="form-control tinymce-editor" id="introduction" name="introduction" rows="6">{{ old('introduction', $termsConditions->introduction) }}</textarea>
                            <small class="form-text text-muted">Use editor to format your content. You can create lists, add formatting, etc.</small>
                        </div>

                        <div class="form-group">
                            <label for="definitions">Definitions</label>
                            <textarea class="form-control tinymce-editor" id="definitions" name="definitions" rows="6">{{ old('definitions', $termsConditions->definitions) }}</textarea>
                            <small class="form-text text-muted">Use editor to format your content. You can create lists, add formatting, etc.</small>
                        </div>

                        <div class="form-group">
                            <label for="acceptance_of_terms">Acceptance of Terms</label>
                            <textarea class="form-control tinymce-editor" id="acceptance_of_terms" name="acceptance_of_terms" rows="6">{{ old('acceptance_of_terms', $termsConditions->acceptance_of_terms) }}</textarea>
                            <small class="form-text text-muted">Use editor to format your content. You can create lists, add formatting, etc.</small>
                        </div>

                        <!-- User Account Section -->
                        <h6 class="text-muted mb-3">User Account</h6>
                        <div class="form-group">
                            <label for="registration">Registration</label>
                            <textarea class="form-control tinymce-editor" id="registration" name="registration" rows="6">{{ old('registration', $termsConditions->registration) }}</textarea>
                            <small class="form-text text-muted">Use editor to format your content. You can create lists, add formatting, etc.</small>
                        </div>

                        <div class="form-group">
                            <label for="account_termination">Account Termination</label>
                            <textarea class="form-control tinymce-editor" id="account_termination" name="account_termination" rows="6">{{ old('account_termination', $termsConditions->account_termination) }}</textarea>
                            <small class="form-text text-muted">Use editor to format your content. You can create lists, add formatting, etc.</small>
                        </div>

                        <!-- Products and Services Section -->
                        <h6 class="text-muted mb-3 mt-4">Products and Services</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="product_information">Product Information</label>
                                    <textarea class="form-control tinymce-editor" id="product_information" name="product_information" rows="6">{{ old('product_information', $termsConditions->product_information) }}</textarea>
                                    <small class="form-text text-muted">Use editor to format your content. You can create lists, add formatting, etc.</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="order_processing">Order Processing</label>
                                    <textarea class="form-control tinymce-editor" id="order_processing" name="order_processing" rows="6">{{ old('order_processing', $termsConditions->order_processing) }}</textarea>
                                    <small class="form-text text-muted">Use editor to format your content. You can create lists, add formatting, etc.</small>
                                </div>
                            </div>
                        </div>

                        <!-- Pricing and Payment Section -->
                        <h6 class="text-muted mb-3 mt-4">Pricing and Payment</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pricing">Pricing</label>
                                    <textarea class="form-control tinymce-editor" id="pricing" name="pricing" rows="6">{{ old('pricing', $termsConditions->pricing) }}</textarea>
                                    <small class="form-text text-muted">Use editor to format your content. You can create lists, add formatting, etc.</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="payment_methods">Payment Methods</label>
                                    <textarea class="form-control tinymce-editor" id="payment_methods" name="payment_methods" rows="6">{{ old('payment_methods', $termsConditions->payment_methods) }}</textarea>
                                    <small class="form-text text-muted">Use editor to format your content. You can create lists, add formatting, etc.</small>
                                </div>
                            </div>
                        </div>

                        <!-- Shipping and Delivery Section -->
                        <h6 class="text-muted mb-3 mt-4">Shipping and Delivery</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="delivery_areas">Delivery Areas</label>
                                    <textarea class="form-control tinymce-editor" id="delivery_areas" name="delivery_areas" rows="6">{{ old('delivery_areas', $termsConditions->delivery_areas) }}</textarea>
                                    <small class="form-text text-muted">Use editor to format your content. You can create lists, add formatting, etc.</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="delivery_time">Delivery Time</label>
                                    <textarea class="form-control tinymce-editor" id="delivery_time" name="delivery_time" rows="6">{{ old('delivery_time', $termsConditions->delivery_time) }}</textarea>
                                    <small class="form-text text-muted">Use editor to format your content. You can create lists, add formatting, etc.</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="delivery_charges">Delivery Charges</label>
                                    <textarea class="form-control tinymce-editor" id="delivery_charges" name="delivery_charges" rows="6">{{ old('delivery_charges', $termsConditions->delivery_charges) }}</textarea>
                                    <small class="form-text text-muted">Use editor to format your content. You can create lists, add formatting, etc.</small>
                                </div>
                            </div>
                        </div>

                        <!-- Returns and Refunds Section -->
                        <h6 class="text-muted mb-3 mt-4">Returns and Refunds</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="return_policy">Return Policy</label>
                                    <textarea class="form-control tinymce-editor" id="return_policy" name="return_policy" rows="6">{{ old('return_policy', $termsConditions->return_policy) }}</textarea>
                                    <small class="form-text text-muted">Use editor to format your content. You can create lists, add formatting, etc.</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="refund_process">Refund Process</label>
                                    <textarea class="form-control tinymce-editor" id="refund_process" name="refund_process" rows="6">{{ old('refund_process', $termsConditions->refund_process) }}</textarea>
                                    <small class="form-text text-muted">Use editor to format your content. You can create lists, add formatting, etc.</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="intellectual_property">Intellectual Property</label>
                            <textarea class="form-control tinymce-editor" id="intellectual_property" name="intellectual_property" rows="6">{{ old('intellectual_property', $termsConditions->intellectual_property) }}</textarea>
                            <small class="form-text text-muted">Use editor to format your content. You can create lists, add formatting, etc.</small>
                        </div>

                        <div class="form-group">
                            <label for="user_conduct">User Conduct</label>
                            <textarea class="form-control tinymce-editor" id="user_conduct" name="user_conduct" rows="6">{{ old('user_conduct', $termsConditions->user_conduct) }}</textarea>
                            <small class="form-text text-muted">Use editor to format your content. You can create lists, add formatting, etc.</small>
                        </div>

                        <div class="form-group">
                            <label for="limitation_of_liability">Limitation of Liability</label>
                            <textarea class="form-control tinymce-editor" id="limitation_of_liability" name="limitation_of_liability" rows="6">{{ old('limitation_of_liability', $termsConditions->limitation_of_liability) }}</textarea>
                            <small class="form-text text-muted">Use editor to format your content. You can create lists, add formatting, etc.</small>
                        </div>

                        <div class="form-group">
                            <label for="termination">Termination</label>
                            <textarea class="form-control tinymce-editor" id="termination" name="termination" rows="6">{{ old('termination', $termsConditions->termination) }}</textarea>
                            <small class="form-text text-muted">Use editor to format your content. You can create lists, add formatting, etc.</small>
                        </div>

                        <div class="form-group">
                            <label for="changes_to_terms">Changes to Terms</label>
                            <textarea class="form-control tinymce-editor" id="changes_to_terms" name="changes_to_terms" rows="6">{{ old('changes_to_terms', $termsConditions->changes_to_terms) }}</textarea>
                            <small class="form-text text-muted">Use editor to format your content. You can create lists, add formatting, etc.</small>
                        </div>

                        <hr>

                        <!-- Contact Information -->
                        <h5>Contact Information</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="contact_email">Contact Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="contact_email" name="contact_email" 
                                           value="{{ old('contact_email', $termsConditions->contact_email) }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="contact_phone">Contact Phone <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="contact_phone" name="contact_phone" 
                                           value="{{ old('contact_phone', $termsConditions->contact_phone) }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="contact_address">Contact Address <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="contact_address" name="contact_address" 
                                           value="{{ old('contact_address', $termsConditions->contact_address) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ $termsConditions->is_active ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Terms & Conditions
                        </button>
                        <a href="{{ route('admin.terms-conditions.index') }}" class="btn btn-default">
                            <i class="fas fa-times"></i> Cancel
                        </a>
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

<style>
/* Fix Trumbowyg conflicts with AdminLTE */
.content-wrapper {
    overflow-x: hidden !important;
}

.card {
    overflow: hidden;
}

.card-body {
    padding: 1rem;
    overflow-x: hidden;
}

.form-group {
    margin-bottom: 1.5rem;
}

.tinymce-editor {
    margin-bottom: 1rem;
    max-width: 100%;
    box-sizing: border-box;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    background: #fff;
}

/* Responsive fixes */
@media (max-width: 768px) {
    .tinymce-editor {
        min-height: 150px;
        padding: 8px;
    }
    
    .card-body {
        padding: 0.75rem;
    }
    
    .tinymce-editor .button-pane {
        width: 100%;
    }
}

@media (max-width: 576px) {
    .tinymce-editor {
        min-height: 120px;
        padding: 6px;
    }
    
    .card-body {
        padding: 0.5rem;
    }
    
    .tinymce-editor .button-pane {
        width: 100%;
        left: 0 !important;
    }
    
    .form-group {
        margin-bottom: 1rem;
    }
}
</style>
@endsection
