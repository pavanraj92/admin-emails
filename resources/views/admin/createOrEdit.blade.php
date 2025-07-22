@extends('admin::admin.layouts.master')

@section('title', 'Emails Management')

@section('page-title', isset($email) ? 'Edit Email' : 'Create Email')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.emails.index') }}">Email Template Manager</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{isset($email) ? 'Edit Email' : 'Create Email'}}</li>
@endsection


@section('content')
    <div class="container-fluid">
        <!-- Start email Content -->
        <div class="row">
            <div class="col-12">
                <div class="card card-body">
                    <form action="{{ isset($email) ? route('admin.emails.update', $email->id) : route('admin.emails.store') }}"
                        method="POST" id="emailForm">
                        @if (isset($email))
                            @method('PUT')
                        @endif
                        @csrf
                        <div class="row">
                            <div class="col-md-6">                                
                                <div class="form-group">
                                    <label>Title<span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control alphabets-only"
                                        value="{{ $email?->title ?? old('title') }}" required>
                                    @error('title')
                                        <div class="text-danger validation-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">                                
                                <div class="form-group">
                                    <label>Subject<span class="text-danger">*</span></label>
                                    <input type="text" name="subject" class="form-control"
                                        value="{{ $email?->subject ?? old('subject') }}" required>
                                    @error('subject')
                                        <div class="text-danger validation-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status<span class="text-danger">*</span></label>
                                    <select name="status" class="form-control select2" required>
                                        <option value="0" {{ (($page?->status ?? old('status')) == '0') ? 'selected' : '' }}>InActive</option>
                                        <option value="1" {{ (($page?->status ?? old('status')) == '1') ? 'selected' : '' }}>Active</option>
                                    </select>
                                    @error('status')
                                        <div class="text-danger validation-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Description<span class="text-danger">*</span></label>
                            <textarea name="description" id="description" class="form-control description-editor">{{ $email?->description ?? old('description') }}</textarea>
                            @error('description')
                                <div class="text-danger validation-error">{{ $message }}</div>
                            @enderror
                        </div>
                       
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="saveBtn">{{isset($email) ? 'Update' : 'Save'}}</button>
                            <a href="{{ route('admin.emails.index') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End email Content -->
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.css">
    <!-- Select2 CSS & JS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Custom CSS for the email -->
    <link rel="stylesheet" href="{{ asset('backend/custom.css') }}">           
@endpush

@push('scripts')
    <!-- Then the jQuery Validation plugin -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <!-- Include the CKEditor script -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
    <!-- Select2 CSS & JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Initialize CKEditor -->
    <script>
    let ckEditorInstance;

    ClassicEditor
    .create(document.querySelector('#description'))
    .then(editor => {
        ckEditorInstance = editor;

        // optional styling
        editor.ui.view.editable.element.style.minHeight = '250px';
        editor.ui.view.editable.element.style.maxHeight = '250px';
        editor.ui.view.editable.element.style.overflowY = 'auto';

        // 🔥 Trigger validation on typing
        editor.model.document.on('change:data', () => {
            const descriptionVal = editor.getData();
            $('#description').val(descriptionVal); // keep textarea updated
            $('#description').trigger('keyup'); // trigger validation manually
        });
    })
    .catch(error => {
        console.error(error);
    });
    </script>

    <script>
        $(document).ready(function() {
            // Initialize Select2 for any select elements with the class 'select2'
            $('.select2').select2();

            $.validator.addMethod(
                "alphabetsOnly",
                function (value, element) {
                    return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
                },
                "Please enter letters only"
            );

            //jquery validation for the form
            $('#emailForm').validate({
                ignore: [],
                rules: {
                    title: {
                        required: true,
                        minlength: 3,
                        alphabetsOnly: true
                    },
                    subject: {
                        required: true,
                        minlength: 3
                    },
                    description: {
                        required: true,
                        minlength: 3
                    }
                },
                messages: {
                    title: {
                        required: "Please enter a title",
                        minlength: "Title must be at least 3 characters long"
                    },
                    subject: {
                       required: "Please enter a subject",
                       minlength: "Subject must be at least 3 characters long"
                    },
                    description: {
                        required: "Please enter description",
                        minlength: "Description must be at least 3 characters long"
                    }
                },
                submitHandler: function(form) {
                    // Update textarea before submit
                    if (ckEditorInstance) {
                        $('#description').val(ckEditorInstance.getData());
                    }
                    
                    const $btn = $('#saveBtn');
                    if ($btn.text().trim().toLowerCase() === 'update') {
                        $btn.prop('disabled', true).text('Updating...');
                    } else {
                        $btn.prop('disabled', true).text('Saving...');
                    }
                    // Now submit
                    form.submit();
                },
                errorElement: 'div',
                errorClass: 'text-danger custom-error',
                errorPlacement: function(error, element) {
                    $('.validation-error').hide(); // hide blade errors
                    if (element.attr("id") === "description") {
                        error.insertAfter($('.ck-editor')); // show below CKEditor UI
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
        });
    </script>
@endpush
