<?php

namespace App\Http\Controllers;

use App\Http\Repositories\NurseRepository;
use App\Http\Resources\NurseCollection;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    protected $nursesRepo;

    public function __construct(NurseRepository $nursesRepo)
    {
        parent::__construct();
        $this->nursesRepo = $nursesRepo;
    }

    public function getNursesToListing(){
        $nurses = $this->nursesRepo->search();
        return new NurseCollection($nurses);
    }
}
