@extends('admin::admin.layouts.master')

@section('title', 'Emails Management')

@section('page-title', isset($email) ? 'Edit Email' : 'Create Email')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.emails.index') }}">Email Template
            Manager</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ isset($email) ? 'Edit Email' : 'Create Email' }}</li>
@endsection


@section('content')
    <div class="container-fluid">
        <!-- Start email Content -->
        <div class="row">
            <div class="col-12">
                <div class="card card-body">
                    <form
                        action="{{ isset($email) ? route('admin.emails.update', $email->id) : route('admin.emails.store') }}"
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
                                    <label>Status<span class="text-danger">*</span></label>
                                    <select name="status" class="form-control select2" required>
                                        @foreach (config('email.constants.status', []) as $key => $label)
                                            <option value="{{ $key }}"
                                                {{ (isset($email) && (string) $email?->status === (string) $key) || old('status') === (string) $key ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status')
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

                        <div class="form-group">
                            <label>Description<span class="text-danger">*</span></label>
                            <textarea name="description" id="description" class="form-control description-editor">{{ $email?->description ?? old('description') }}</textarea>
                            @error('description')
                                <div class="text-danger validation-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"
                                id="saveBtn">{{ isset($email) ? 'Update' : 'Save' }}</button>
                            <a href="{{ route('admin.emails.index') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End email Content -->
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#description').summernote({
                height: 250, // ✅ editor height
                minHeight: 250,
                maxHeight: 250,
                toolbar: [
                    // ✨ Add "code view" toggle button
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture']],
                    ['view', ['codeview']] // ✅ source code button
                ],
                callbacks: {
                    onChange: function(contents, $editable) {
                        // keep textarea updated
                        $('#description').val(contents);
                        // trigger validation if needed
                        $('#description').trigger('keyup');
                    }
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Initialize Select2 for any select elements with the class 'select2'
            $('.select2').select2();

            $.validator.addMethod(
                "alphabetsOnly",
                function(value, element) {
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
                    $('#description').val($('#description').summernote('code'));

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
                        error.insertAfter($('.note-editor'));
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
        });
    </script>
@endpush
