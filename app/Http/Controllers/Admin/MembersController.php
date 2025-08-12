<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Member;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MembersController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('member_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $members = Member::paginate(10);

        return view('admin.members.index', compact('members'));
    }

    
    public function create()
    {
        abort_if(Gate::denies('member_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.members.create');
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('member_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'username' => 'bail|required|max:255|min:4',
            'email' => 'bail|required|email|unique:members|max:255',
            'phone_number' => 'bail|required',
        ]);

        Member::create($request->all());

        return redirect()->route('members.index')->withStatus(__('Member is added successfully.'));
    }
}