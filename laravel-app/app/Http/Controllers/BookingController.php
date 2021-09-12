<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Services\BookingService;
use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Http\Resources\BookingResource;
use App\Http\Filters\BookingFilter;
use Illuminate\Http\Response;
use Lang;

class BookingController extends Controller
{
    private $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function patientBooking(Request $request){
        $user = JWTAuth::parseToken()->authenticate();
        $request->request->add(['patient_id' => $user->id]);
        $bookings = $this->bookingService->getAll(new BookingFilter($request));
        return BookingResource::collection($bookings);
    }

    public function doctorBooking(Request $request){
        $user = JWTAuth::parseToken()->authenticate();
        $request->request->add(['doctor_id' => $user->id]);
        $bookings = $this->bookingService->getAll(new BookingFilter($request));
        return BookingResource::collection($bookings);
    }

    public function show(Booking $booking){
        return new BookingResource($booking);
    }

    public function store(StoreBookingRequest $request){
        $booking = $this->bookingService->create($request->validated());
        return response()->json(['message' => Lang::get('messages.booking.success.created')] , Response::HTTP_CREATED);
    }

    public function acceptBooking(Request $request, Booking $booking){
        $this->bookingService->accept($booking);
        return response()->json(['messages' => Lang::get('messages.booking.success.accept')] , Response::HTTP_OK);

    }

    public function cancelBooking(Request $request, Booking $booking){
        $this->bookingService->cancel($booking);
        return response()->json(['messages' => Lang::get('messages.booking.success.cancel')] , Response::HTTP_OK);
    }
}
