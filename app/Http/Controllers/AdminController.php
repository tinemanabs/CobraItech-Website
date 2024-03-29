<?php

namespace App\Http\Controllers;

use File;
use Hash;

use App\Models\Support;
use App\Models\Contact;
use App\Models\Career;
use App\Models\User;


use App\Mail\AcceptMail;
use App\Mail\ReplyContactMail;
use App\Mail\ReplySupportMail;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function editProfile($id)
    {
        $user = User::find($id);
        return view('modules.editprofile', [
            'user' => $user,
        ]);
    }

    public function changePassword(Request $req)
    {
        $data = User::find($req->id);
        if (Hash::check($req->currpwd, $data->password)) {
            $data->password = Hash::make($req->npwd);
            $data->save();
            return back()->with('success','Your password has been successfully changed!');
        } else {
            return back()->with('error','Your current password is incorrect!');
        }
    }

    public function careerSummaryPage()
    {
        $careers = DB::table('careers')
            ->latest()
            ->get();

        return view('modules.careersummary', [
            'careers' => $careers,
        ]);
    }

    public function supportSummaryPage()
    {
        $supports = DB::table('supports')
            ->latest()
            ->get();


        return view('modules.supportsummary', [
            'supports' => $supports,
        ]);
    }

    public function contactSummaryPage()
    {
        $contacts = DB::table('contacts')
            ->latest()
            ->get();


        return view('modules.contactussummary', [
            'contacts' => $contacts,
        ]);
    }

    public function usersPage()
    {
        $users = DB::table('users')
            ->latest()
            ->get();

        return view('modules.usermanagement', [
            'users' => $users,
        ]);
    }

    public function activateCareer(Request $req)
    {
        $data = Career::find($req->id);
        $data->status = 1;
        $data->save();
        return redirect('career-summary');
    }

    public function deactivateCareer(Request $req)
    {
        $data = Career::find($req->id);
        $data->status = 0;
        $data->save();
        return redirect('career-summary');
    }

    public function activateApplication($id)
    {
        $data = Career::find($id);
        $data->accept = 1;

        $data2 = [
            'name' => $data->name,
            'email' => $data->email
        ];

        Mail::to($data->email)->send(new AcceptMail($data2));

        $data->save();
        return redirect('career-summary');
    }

    public function activateContact(Request $req)
    {
        $data = Contact::find($req->id);
        $data->status = 1;
        $data->save();
        return redirect('contact-summary');
    }

    public function deactivateContact(Request $req)
    {
        $data = Contact::find($req->id);
        $data->status = 0;
        $data->save();
        return redirect('contact-summary');
    }

    public function activateSupport(Request $req)
    {
        $data = Support::find($req->id);
        $data->status = 1;
        $data->save();
        return redirect('support-summary');
    }

    public function deactivateSupport(Request $req)
    {
        $data = Support::find($req->id);
        $data->status = 0;
        $data->save();
        return redirect('support-summary');
    }

    public function addUser(Request $req)
    {
        $users = new User();
        $users->name = $req->name;
        $users->email = $req->email;
        $users->password = Hash::make($req->pwd);
        $users->user_role = 1;

        $users->save();
        return redirect('users-summary');
    }

    public function deleteUser(Request $req)
    {
        $data = User::find($req->id);
        $data->delete();
        return redirect('users-summary');
    }

    public function replyContact(Request $req)
    {
        $data = [
            'email' => $req->email,
            'message' => $req->reply,
            'subject' => $req->subject
        ];

        Mail::to($data['email'])->send(new ReplyContactMail($data));

        return redirect('contact-summary');
    }

    public function replySupport(Request $req)
    {
        $data = [
            'email' => $req->email,
            'message' => $req->reply,
            'subject' => $req->subject
        ];

        Mail::to($data['email'])->send(new ReplySupportMail($data));

        return redirect('support-summary');
    }
}
