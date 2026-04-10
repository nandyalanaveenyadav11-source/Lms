<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    public function index()
    {
        $domains = Domain::withCount(['courses', 'trainees'])->get();
        return view('admin.domains.index', compact('domains'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:domains,name',
        ]);

        Domain::create($request->all());

        return back()->with('success', 'Domain created successfully.');
    }

    public function update(Request $request, Domain $domain)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:domains,name,' . $domain->id,
        ]);

        $domain->update($request->all());

        return back()->with('success', 'Domain updated successfully.');
    }

    public function destroy(Domain $domain)
    {
        if ($domain->courses()->count() > 0 || $domain->trainees()->count() > 0) {
            return back()->with('error', 'Cannot delete domain that has courses or trainees assigned to it.');
        }

        $domain->delete();
        return back()->with('success', 'Domain deleted successfully.');
    }
}
