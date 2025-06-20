<?php

namespace admin\emails\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use admin\emails\Requests\EmailCreateRequest;
use admin\emails\Requests\EmailUpdateRequest;
use admin\emails\Models\Email;

class EmailController extends Controller
{
    public function index(Request $request)
    {
        try {
            $emails = Email::
                filter($request->query('keyword'))
                ->filterByStatus($request->query('status'))
                ->latest()
                ->paginate(5)
                ->withQueryString();

            return view('email::admin.index', compact('emails'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load emails: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            return view('email::admin.createOrEdit');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load emails: ' . $e->getMessage());
        }
    }

    public function store(EmailCreateRequest $request)
    {
        try {
            $requestData = $request->validated();

            Email::create($requestData);
            return redirect()->route('admin.emails.index')->with('success', 'Email created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load emails: ' . $e->getMessage());
        }
    }

    /**
     * show email details
     */
    public function show(Email $email)
    {
        try {
            return view('email::admin.show', compact('email'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load emails: ' . $e->getMessage());
        }
    }

    public function edit(Email $email)
    {
        try {
            return view('email::admin.createOrEdit', compact('email'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load email for editing: ' . $e->getMessage());
        }
    }

    public function update(EmailUpdateRequest $request, Email $email)
    {
        try {
            $requestData = $request->validated();

            $email->update($requestData);
            return redirect()->route('admin.emails.index')->with('success', 'Email updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load email for editing: ' . $e->getMessage());
        }
    }

    public function destroy(Email $email)
    {
        try {
            $email->delete();
            return response()->json(['success' => true, 'message' => 'Record deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete record.', 'error' => $e->getMessage()], 500);
        }
    }

    public function updateStatus(Request $request)
    {
        try {
            $email = Email::findOrFail($request->id);
            $email->status = $request->status;
            $email->save();

            // create status html dynamically        
            $dataStatus = $email->status == '1' ? '0' : '1';
            $label = $email->status == '1' ? 'Active' : 'InActive';
            $btnClass = $email->status == '1' ? 'btn-success' : 'btn-warning';
            $tooltip = $email->status == '1' ? 'Click to change status to inactive' : 'Click to change status to active';

            $strHtml = '<a href="javascript:void(0)"'
                . ' data-toggle="tooltip"'
                . ' data-placement="top"'
                . ' title="' . $tooltip . '"'
                . ' data-url="' . route('admin.emails.updateStatus') . '"'
                . ' data-method="POST"'
                . ' data-status="' . $dataStatus . '"'
                . ' data-id="' . $email->id . '"'
                . ' class="btn ' . $btnClass . ' btn-sm update-status">' . $label . '</a>';

            return response()->json(['success' => true, 'message' => 'Status updated to '.$label, 'strHtml' => $strHtml]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete record.', 'error' => $e->getMessage()], 500);
        }
    }
}
