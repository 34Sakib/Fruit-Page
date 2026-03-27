@extends('backend.layouts.master')

@section('title', 'Create Privacy Policy')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create Privacy Policy</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.privacy-policy.index') }}" class="btn btn-default btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.privacy-policy.store') }}?_method=POST">
                    @csrf

                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- Hero Section --}}
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="hero_title">Hero Title *</label>
                                    <input type="text" class="form-control" id="hero_title" name="hero_title"
                                           value="{{ old('hero_title', 'Privacy Policy') }}" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="is_active">Status</label>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1"
                                               {{ old('is_active', 1) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_active">Active</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="hero_subtitle">Hero Subtitle *</label>
                            <textarea class="form-control" id="hero_subtitle" name="hero_subtitle" rows="2" required>{{ old('hero_subtitle', 'Your privacy is important to us. This policy explains how we collect, use, and protect your information.') }}</textarea>
                        </div>

                        <hr>

                        {{-- Content Sections --}}
                        <div class="form-group">
                            <label for="introduction">Introduction</label>
                            <textarea class="form-control tinymce-editor" id="introduction" name="introduction" rows="6">{{ old('introduction') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="personal_info">Personal Information</label>
                                    <textarea class="form-control tinymce-editor" id="personal_info" name="personal_info" rows="8">{{ old('personal_info') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="auto_collected_info">Automatically Collected Information</label>
                                    <textarea class="form-control tinymce-editor" id="auto_collected_info" name="auto_collected_info" rows="8">{{ old('auto_collected_info') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="information_usage">Information Usage</label>
                                    <textarea class="form-control tinymce-editor" id="information_usage" name="information_usage" rows="8">{{ old('information_usage') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="data_sharing">Data Sharing</label>
                                    <textarea class="form-control tinymce-editor" id="data_sharing" name="data_sharing" rows="8">{{ old('data_sharing') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="data_security">Data Security</label>
                                    <textarea class="form-control tinymce-editor" id="data_security" name="data_security" rows="8">{{ old('data_security') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cookies_tracking">Cookies & Tracking</label>
                                    <textarea class="form-control tinymce-editor" id="cookies_tracking" name="cookies_tracking" rows="8">{{ old('cookies_tracking') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="privacy_rights">Privacy Rights</label>
                                    <textarea class="form-control tinymce-editor" id="privacy_rights" name="privacy_rights" rows="8">{{ old('privacy_rights') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="third_party_links">Third-Party Links</label>
                                    <textarea class="form-control tinymce-editor" id="third_party_links" name="third_party_links" rows="8">{{ old('third_party_links') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="children_privacy">Children's Privacy</label>
                                    <textarea class="form-control tinymce-editor" id="children_privacy" name="children_privacy" rows="8">{{ old('children_privacy') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="policy_changes">Policy Changes</label>
                                    <textarea class="form-control tinymce-editor" id="policy_changes" name="policy_changes" rows="8">{{ old('policy_changes') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <hr>

                        {{-- Contact Information --}}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="contact_email">Contact Email *</label>
                                    <input type="email" class="form-control" id="contact_email" name="contact_email"
                                           value="{{ old('contact_email', 'privacy@fruitmart.com') }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="contact_phone">Contact Phone *</label>
                                    <input type="text" class="form-control" id="contact_phone" name="contact_phone"
                                           value="{{ old('contact_phone', '+8801641555173') }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="contact_address">Contact Address *</label>
                                    <input type="text" class="form-control" id="contact_address" name="contact_address"
                                           value="{{ old('contact_address', 'Kuril, Dhaka, Bangladesh') }}" required>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Create Privacy Policy
                        </button>
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