@extends('admin::admin.layouts.master')

@section('title', 'Emails Management')

@section('page-title', 'Email Details')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">
        <a href="{{ route('admin.emails.index') }}">Email Template Manager</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Email Details</li>
@endsection

@section('content')
    <!-- Container fluid  -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Header with Back button -->
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h4 class="card-title mb-0">{{ $email->title ?? 'N/A' }} - Email #{{ $email->id }}</h4>
                            <div>
                                <a href="{{ route('admin.emails.index') }}" class="btn btn-secondary ml-2">
                                    Back
                                </a>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Email Information -->
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header bg-primary">
                                        <h5 class="mb-0 text-white font-bold">Email Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Title:</label>
                                            <p>{{ $email->title ?? 'N/A' }}</p>
                                        </div>

                                        <div class="form-group">
                                            <label class="font-weight-bold">Subject:</label>
                                            <p>{{ $email->subject ?? 'N/A' }}</p>
                                        </div>

                                        <div class="form-group">
                                            <label class="font-weight-bold">Description:</label>
                                            <p>{!! $email->description ?? 'N/A' !!}</p>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Status:</label>
                                                    <p>{!! config('email.constants.aryStatusLabel.' . $email->status, 'N/A') !!}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Created At:</label>
                                                    <p>
                                                        {{ $email->created_at
                                                            ? $email->created_at->format(config('GET.admin_date_time_format') ?? 'Y-m-d H:i:s')
                                                            : '—' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header bg-primary">
                                        <h5 class="mb-0 text-white font-bold">Quick Actions</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex flex-column">
                                            @admincan('emails_manager_edit')
                                            <a href="{{ route('admin.emails.edit', $email) }}" class="btn btn-warning mb-2">
                                                <i class="mdi mdi-pencil"></i> Edit Email
                                            </a>
                                            @endadmincan

                                            @admincan('emails_manager_delete')
                                                <button type="button" class="btn btn-danger delete-btn delete-record"
                                                    title="Delete this record"
                                                    data-url="{{ route('admin.emails.destroy', $email) }}"
                                                    data-redirect="{{ route('admin.emails.index') }}"
                                                    data-text="Are you sure you want to delete this record?"
                                                    data-method="DELETE">
                                                    <i class="mdi mdi-delete"></i> Delete Email
                                                </button>
                                            @endadmincan
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- row end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Container fluid  -->
@endsection
