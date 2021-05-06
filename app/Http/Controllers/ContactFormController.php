<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Mail;
use Response;



class ContactFormController extends Controller
{
    // See all contact from website
    public function index()
    {
        return Contact::all();
        return response()->json(["message" => "L'ensemble des contacts"], 200);
    }
    // storage user query
    public function store(Request $request)
    {
        Contact::create($request->all());
        // send copie of query to the user
        Mail::send('response', [
            'firstname' => $request->get('firstname'),
            'user_query' => $request->get('message'),
            'email' => $request->get('email'),
        ], function($message) use ($request){
            $message->from($request->email);
            $message->to($request->email)->subject("Votre demande");
        });
        // send the user query to the admin
        Mail::send('mail', array(
            'lastname' => $request->get('lastname'),
            'firstname' => $request->get('firstname'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'subject' => $request->get('subject'),
            'consent' => $request->get('consent'),
            'user_query' => $request->get('message'),
        ), function($message) use ($request){
            $message->from($request->email);
            $message->to('alexis.resses@gmail.com', 'Admin')->subject("Nouveau message");
        });

        return response()->json(['message' => 'Votre message est bien envoyée'], 201);

    }
    // delete one user query
    public function delete($id)
    {
        $contactDelete = Contact::findOrFail($id);
        $contactDelete->delete();
        return response()->json(['message' => 'Le contact est bien supprimé'], 200);
    }
    // delete all user query 
    public function destroy(Contact $request)
    {
        Contact::destroy($request->all());
        return response()->json(['message' => 'Les contacts sont supprimés'], 200);
    }

}