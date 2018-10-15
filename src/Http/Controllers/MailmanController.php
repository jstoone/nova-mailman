<?php

namespace Jstoone\Mailman\Http\Controllers;

use Illuminate\Http\Request;
use Jstoone\Mailman\File;
use Illuminate\Routing\Controller;

class MailmanController extends Controller
{
    public function index()
    {
        return 'Hello world!';
    }
}
