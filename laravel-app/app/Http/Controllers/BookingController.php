<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\BookingService;
use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Http\Resources\BookingResource;
use App\Http\Filters\BookingFilter;
use Illuminate\Http\Response;

class BookingController extends Controller
{
    private $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function index(BookingFilter $filter){
        $bookings = $this->bookingService->getAll($filter);
        return BookingResource::collection($bookings);
    }

    public function show(Booking $booking){
        return new BookingResource($booking);
    }

    public function store(StoreBookingRequest $request){
        $booking = $this->bookingService->create($request->validated());
        return new BookingResource($booking);
    }

    public function acceptBooking(Request $request, Booking $booking){
        return $this->bookingService->acceptBooking($booking);
    }

    public function cancelBooking(Request $request, Booking $booking){
        return $this->bookingService->cancelBooking($booking);
    }
}
