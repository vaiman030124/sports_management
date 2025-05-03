<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;

class EmailTemplateController extends Controller
{
    public function index()
    {
        $emailTemplates = EmailTemplate::all();
        return view('admin.email_templates.index', compact('emailTemplates'));
    }

    public function show($id)
    {
        $emailTemplate = EmailTemplate::findOrFail($id);
        return view('admin.email_templates.show', compact('emailTemplate'));
    }

    public function create()
    {
        return view('admin.email_templates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|unique:email_templates,type',
            'slug' => 'required|string|unique:email_templates,slug',
            'subject' => 'required|string',
            'body' => 'required|string',
            'variables' => 'nullable|json',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->all();
        if (!empty($data['variables'])) {
            $data['variables'] = json_decode($data['variables'], true);
        }

        EmailTemplate::create($data);

        return redirect()->route('admin.email-templates.index')->with('success', 'Email template created successfully.');
    }

    public function edit($id)
    {
        $emailTemplate = EmailTemplate::findOrFail($id);
        return view('admin.email_templates.edit', compact('emailTemplate'));
    }

    public function update(Request $request, $id)
    {
        $emailTemplate = EmailTemplate::findOrFail($id);

        $request->validate([
            'type' => 'required|string|unique:email_templates,type,' . $emailTemplate->id,
            'slug' => 'required|string|unique:email_templates,slug,' . $emailTemplate->id,
            'subject' => 'required|string',
            'body' => 'required|string',
            'variables' => 'nullable|json',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->all();
        if (!empty($data['variables'])) {
            $data['variables'] = json_decode($data['variables'], true);
        }

        $emailTemplate->update($data);

        return redirect()->route('admin.email-templates.index')->with('success', 'Email template updated successfully.');
    }

    public function destroy($id)
    {
        $emailTemplate = EmailTemplate::findOrFail($id);
        $emailTemplate->delete();

        return redirect()->route('admin.email-templates.index')->with('success', 'Email template deleted successfully.');
    }
}
