<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\BookingService;
use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Http\Resources\BookingResource;
use Illuminate\Http\Response;

class BookingController extends Controller
{
    private $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function show(Booking $booking){
        return new BookingResource($booking);
    }

    public function store(StoreBookingRequest $request){
        $booking = $this->bookingService->create($request->validated());
        return new BookingResource($booking);
    }
}
