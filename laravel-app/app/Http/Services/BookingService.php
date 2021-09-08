<?php

namespace App\Http\Services;

use Illuminate\Http\Response;
use App\Repositories\BookingRepository;
use Lang;

class BookingService
{
    private $bookingRepository;

    public function __construct(BookingRepository $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

    public function create(array $data){
        return $this->bookingRepository->create($data);
    }
}
