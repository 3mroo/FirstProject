<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Carbon;

class ContactController extends Controller
{
    public function Contact()
    {
        return view('frontend.contact');
    }//end

    public function StoreMessage(Request $request)
    {
        Contact::insert([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Your Message Submited Successfullly',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }//end

    public function ContactMessage()
    {
        $contacts = Contact::latest()->get();
        return view('admin.contact.allcontact',compact('contacts'));
    }//end

    public function DeleteMessage($id)
    {

        Contact::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Contact Message Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }


}
