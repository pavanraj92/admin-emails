@extends('admin::admin.layouts.master')

@section('title', 'Emails Management')

@section('page-title', 'Email Details')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.emails.index') }}">Manage Emails</a></li>
    <li class="breadcrumb-item active" aria-current="page">Email Details</li>
@endsection

@section('content')
    <!-- Container fluid  -->
    <div class="container-fluid">
        <!-- Start Email Content -->
        <div class="row">
            <div class="col-12">
                <div class="card">                    
                    <div class="table-responsive">
                         <div class="card-body">      
                            <table class="table table-responsive-lg table-no-border">
                                <tbody>
                                    <tr>
                                        <th scope="row">Title</th>
                                        <td scope="col">{{ $email->title ?? 'N/A' }}</td>
                                    </tr>         
                                    <tr>
                                        <th scope="row">Subject</th>
                                        <td scope="col">{{ $email->subject ?? 'N/A' }}</td>
                                    </tr>                                
                                    <tr>
                                        <th scope="row">Description</th>
                                        <td scope="col">{!! $email->description ?? 'N/A' !!}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Status</th>
                                        <td scope="col"> {!! config('admin.constants.aryStatusLabel.' . $email->status, 'N/A') !!}</td>
                                    </tr>                                
                                    <tr>
                                        <th scope="row">Created At</th>
                                        <td scope="col">{{ $email->created_at
                                            ? $email->created_at->format(config('GET.admin_date_time_format') ?? 'Y-m-d H:i:s')
                                            : '—' }}</td>
                                    </tr>                                
                                </tbody>
                            </table>   
                                             
                            <a href="{{ route('admin.emails.index') }}" class="btn btn-secondary">Back</a> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Email Content -->
    </div>
    <!-- End Container fluid  -->
@endsection
