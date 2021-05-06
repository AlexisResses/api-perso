<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Controllers\ContactFormController;

class Contact extends Model
{
    use HasFactory;
    public $fillable = ['lastname', 'firstname', 'email', 'phone', 'subject', 'message', 'consent'];
}
