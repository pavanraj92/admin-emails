@extends('admin::admin.layouts.master')

@section('title', 'Emails Management')

@section('page-title', 'Manage Emails')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Manage Emails</li>
@endsection

@section('content')
    <!-- Container fluid  -->
    <div class="container-fluid">
        <!-- Start Email Content -->
        <div class="row">
            <div class="col-12">
                <div class="card card-body">
                    <h4 class="card-title">Filter</h4>
                    <form action="{{ route('admin.emails.index') }}" method="GET" id="filterForm">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="keyword" id="keyword" class="form-control"
                                        value="{{ app('request')->query('keyword') }}" placeholder="Enter title">                                   
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control select2">
                                        <option value="">All</option>
                                        <option value="0" {{ app('request')->query('status') == '0' ? 'selected' : '' }}>Inactive</option>
                                        <option value="1" {{ app('request')->query('status') == '1' ? 'selected' : '' }}>Active</option>
                                    </select>                                   
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" form="filterForm" class="btn btn-primary mb-3">Filter</button>
                            <a href="{{ route('admin.emails.index') }}" class="btn btn-secondary mb-3">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="text-right">
                            <a href="{{ route('admin.emails.create') }}" class="btn btn-primary mb-3">Create New Email Template</a>
                        </div>
                    
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Subject</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($emails) && $emails->count() > 0)
                                        @php
                                            $i = ($emails->currentPage() - 1) * $emails->perPage() + 1;
                                        @endphp
                                        @foreach ($emails as $email)
                                            <tr>
                                                <th scope="row">{{ $i }}</th>
                                                <td>{{ $email->title }}</td>
                                                <td>{{ $email->subject }}</td>
                                                <td>
                                                    <!-- create update status functionality-->
                                                    @if ($email->status == '1')
                                                        <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top"
                                                            title="Click to change status to inactive"
                                                            data-url="{{ route('admin.emails.updateStatus') }}"
                                                            data-method="POST" data-status="0" data-id="{{ $email->id }}"
                                                            class="btn btn-success btn-sm update-status">Active</a>
                                                    @else
                                                        <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top"
                                                            title="Click to change status to active"
                                                            data-url="{{ route('admin.emails.updateStatus') }}"
                                                            data-method="POST" data-status="1"
                                                            data-id="{{ $email->id }}"
                                                            class="btn btn-warning btn-sm update-status">InActive</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $email->created_at->format('Y-m-d H:i:s') }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.emails.edit', $email) }}"
                                                        data-toggle="tooltip"
                                                        data-placement="top"
                                                        title="Edit this record"
                                                        class="btn btn-success btn-sm"><i class="mdi mdi-pencil"></i></a>
                                                    <a href="{{ route('admin.emails.show', $email) }}" 
                                                        data-toggle="tooltip"
                                                        data-placement="top"
                                                        title="View this record"
                                                        class="btn btn-warning btn-sm"><i class="mdi mdi-eye"></i></a>
                                                    <a href="javascript:void(0)" 
                                                        data-toggle="tooltip" 
                                                        data-placement="top"
                                                        title="Delete this record" 
                                                        data-url="{{ route('admin.emails.destroy', $email) }}"
                                                        data-text="Are you sure you want to delete this record?"                                                    
                                                        data-method="DELETE"
                                                        class="btn btn-danger btn-sm delete-record" ><i class="mdi mdi-delete"></i></a>
                                                </td>
                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center">No emails found.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                            <!--pagination move the right side-->
                            @if ($emails->count() > 0)
                                {{ $emails->links('admin::pagination.custom-admin-pagination') }}
                            @endif                        
                            
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!-- End email Content -->
    </div>
    <!-- End Container fluid  -->
@endsection
