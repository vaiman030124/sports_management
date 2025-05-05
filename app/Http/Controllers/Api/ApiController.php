<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Venue;
use App\Models\Sport;
use App\Models\Court;
use App\Models\Slot;
use App\Models\Booking;
use App\Models\Group;

class ApiController extends Controller
{
    /**
     * Venue Management APIs.
     */
    public function getVenues(Request $request)
    {
        $page = $request->page_number ?? 1;
        $status = $request->status ?? "";
        $offSet = ($page - 1) * env('API_DATA_LIMIT');

        $venues = Venue::limit(env('API_DATA_LIMIT'))->offset($offSet);

        if(!empty($status)) {
            $venues = $venues->where('status', $status);
        }

        $venues = $venues->get();
        
        return response()->json($venues);
    }

    public function createVenues(Request $request)
    {
        $validated = $request->validate([
            'venue_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            // 'images' => 'nullable|array',
            // 'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:active,inactive',
            'capacity' => 'required|integer|min:0',
        ]);

        /* if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('venues', 'public');
                $imagePaths[] = $path;
            }
            $validated['images'] = $imagePaths;
        } */

        Venue::create($validated);

        return response()->json(["message" => "Venue created successfully"]);
    }

    public function updateVenues(Request $request)
    {
        $request['id'] = $request->id ?? '';
        $validated = $request->validate([
            'venue_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            // 'images' => 'nullable|array',
            // 'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:active,inactive',
            'capacity' => 'required|integer|min:0',
            'id' => 'required|exists:venues,id'
        ]);

        /* if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('venues', 'public');
                $imagePaths[] = $path;
            }
            $validated['images'] = $imagePaths;
        } */

        Venue::updateOrCreate(['id' => $request->id], $validated);

        return response()->json(["message" => "Venue updated successfully"]);
    }

    public function deleteVenues(Request $request)
    {
        $request['id'] = $request->id ?? '';
        $validated = $request->validate([
            'id' => 'required|exists:venues,id'
        ]);

        $venue = Venue::where('id', $validated['id'])->first();
        $venue->delete();

        return response()->json(["message" => "Venue deleted successfully"]);
    }

    public function upStatusVenues(Request $request)
    {
        $request['id'] = $request->id ?? '';
        $validated = $request->validate([
            'id' => 'required|exists:venues,id',
            'status' => 'required|in:active,inactive',
        ]);

        Venue::updateOrCreate(['id' => $validated['id']], $validated);

        return response()->json(["message" => "Venue status updated successfully"]);
    }

    /**
     * Sports Management APIs.
     */
    public function getSports(Request $request)
    {
        $page = $request->page_number ?? 1;
        $status = $request->status ?? "";
        $offSet = ($page - 1) * env('API_DATA_LIMIT');

        $sports = Sport::with('venue')->limit(env('API_DATA_LIMIT'))->offset($offSet);

        if(!empty($status)) {
            $sports = $sports->where('status', $status);
        }

        $sports = $sports->get();
        
        return response()->json($sports);
    }

    public function createSports(Request $request)
    {
        $validated = $request->validate([
            'sport_name' => 'required|string|max:255',
            'venue_id' => 'required|exists:venues,id',
            'court_count' => 'required|integer|min:0',
            'shared_with' => 'nullable|array',
            'shared_with.*' => 'string',
            'pricing_peak' => 'required|numeric|min:0',
            'pricing_non_peak' => 'required|numeric|min:0',
            'status' => 'required|string|in:active,inactive',
        ]);

        $validated['shared_with'] = $validated['shared_with'] ?? [];

        Sport::create($validated);

        return response()->json(["message" => "Sport created successfully"]);
    }

    public function updateSports(Request $request)
    {
        $request['id'] = $request->id ?? '';
        $validated = $request->validate([
            'sport_name' => 'required|string|max:255',
            'venue_id' => 'required|exists:venues,id',
            'court_count' => 'required|integer|min:0',
            'shared_with' => 'nullable|array',
            'shared_with.*' => 'string',
            'pricing_peak' => 'required|numeric|min:0',
            'pricing_non_peak' => 'required|numeric|min:0',
            'status' => 'required|string|in:active,inactive',
            'id' => 'required|exists:sports,id'
        ]);

        $validated['shared_with'] = $validated['shared_with'] ?? [];

        Sport::updateOrCreate(['id' => $request->id], $validated);

        return response()->json(["message" => "Sport updated successfully"]);
    }

    public function deleteSports(Request $request)
    {
        $request['id'] = $request->id ?? '';
        $validated = $request->validate([
            'id' => 'required|exists:sports,id'
        ]);

        $sport = Sport::where('id', $validated['id'])->first();
        $sport->delete();

        return response()->json(["message" => "Sport deleted successfully"]);
    }

    public function upStatusSports(Request $request)
    {
        $request['id'] = $request->id ?? '';
        $validated = $request->validate([
            'id' => 'required|exists:sports,id',
            'status' => 'required|in:active,inactive',
        ]);

        Sport::updateOrCreate(['id' => $validated['id']], $validated);

        return response()->json(["message" => "Sport status updated successfully"]);
    }
    
    public function getSportsDetail(Request $request)
    {
        $request['id'] = $request->id ?? '';
        $validated = $request->validate([
            'id' => 'required|exists:sports,id'
        ]);

        $sport = Sport::where('id', $validated['id'])->first();

        return response()->json($sport);
    }

    /**
     * Courts Management APIs.
     */
    public function getCourts(Request $request)
    {
        $page = $request->page_number ?? 1;
        $status = $request->status ?? "";
        $offSet = ($page - 1) * env('API_DATA_LIMIT');

        $courts = Court::with('sport')->limit(env('API_DATA_LIMIT'))->offset($offSet);

        if(!empty($status)) {
            $courts = $courts->where('status', $status);
        }

        $courts = $courts->get();
        
        return response()->json($courts);
    }

    public function createCourts(Request $request)
    {
        $validated = $request->validate([
            'court_name' => 'required|string|max:255',
            'sport_id' => 'required|exists:sports,id',
            'status' => 'required|in:active,inactive,maintenance',
            'court_type' => 'required|in:shared,dedicated'
        ]);

        Court::create($validated);

        return response()->json(["message" => "Court created successfully"]);
    }

    public function updateCourts(Request $request)
    {
        $request['id'] = $request->id ?? '';
        $validated = $request->validate([
            'court_name' => 'required|string|max:255',
            'sport_id' => 'required|exists:sports,id',
            'status' => 'required|in:active,inactive,maintenance',
            'court_type' => 'required|in:shared,dedicated',
            'id' => 'required|exists:courts,id'
        ]);

        Court::updateOrCreate(['id' => $request->id], $validated);

        return response()->json(["message" => "Court updated successfully"]);
    }

    public function deleteCourts(Request $request)
    {
        $request['id'] = $request->id ?? '';
        $validated = $request->validate([
            'id' => 'required|exists:courts,id'
        ]);

        $court = Court::where('id', $validated['id'])->first();
        $court->delete();

        return response()->json(["message" => "Court deleted successfully"]);
    }

    public function upStatusCourts(Request $request)
    {
        $request['id'] = $request->id ?? '';
        $validated = $request->validate([
            'id' => 'required|exists:courts,id',
            'status' => 'required|in:active,inactive',
        ]);

        Court::updateOrCreate(['id' => $validated['id']], $validated);

        return response()->json(["message" => "Court status updated successfully"]);
    }

    public function getCourtsBySport(Request $request)
    {
        $page = $request->page_number ?? 1;
        $offSet = ($page - 1) * env('API_DATA_LIMIT');

        $courts = Court::where('sport_id', $request->id)->limit(env('API_DATA_LIMIT'))->offset($offSet)->get();
        
        return response()->json($courts);
    }

    /**
     * Slots Management APIs.
     */
    public function getSlots(Request $request)
    {
        $page = $request->page_number ?? 1;
        $status = $request->status ?? "";
        $offSet = ($page - 1) * env('API_DATA_LIMIT');

        $slots = Slot::with('sport', 'court')->limit(env('API_DATA_LIMIT'))->offset($offSet);

        if(!empty($status)) {
            $slots = $slots->where('status', $status);
        }

        $slots = $slots->get();
        
        return response()->json($slots);
    }

    public function createSlots(Request $request)
    {
        $validated = $request->validate([
            'sport_id' => 'required|exists:sports,sports.id',
            'court_id' => 'required|exists:courts,courts.id',
            'slot_date' => 'required|date',
            'slot_time' => 'required|date_format:H:i',
            'slot_end_time' => 'required|date_format:H:i|after:slot_time',
            'is_member_slot' => 'required|in:1,0',
            'max_players' => 'required|integer|min:4',
            'available_slots' => 'required|integer|min:1',
            'is_peak_hour' => 'required|in:1,0',
            'status' => 'required|in:available,booked,blocked'
        ]);

        Slot::create($validated);

        return response()->json(["message" => "Slot created successfully"]);
    }

    public function updateSlots(Request $request)
    {
        $request['id'] = $request->id ?? '';
        $validated = $request->validate([
            'sport_id' => 'required|exists:sports,sports.id',
            'court_id' => 'required|exists:courts,courts.id',
            'slot_date' => 'required|date',
            'slot_time' => 'required|date_format:H:i',
            'slot_end_time' => 'required|date_format:H:i|after:slot_time',
            'is_member_slot' => 'required|in:1,0',
            'max_players' => 'required|integer|min:4',
            'available_slots' => 'required|integer|min:1',
            'is_peak_hour' => 'required|in:1,0',
            'status' => 'required|in:available,booked,blocked',
            'id' => 'required|exists:slots,id'
        ]);

        Slot::updateOrCreate(['id' => $request->id], $validated);

        return response()->json(["message" => "Slot updated successfully"]);
    }

    public function deleteSlots(Request $request)
    {
        $request['id'] = $request->id ?? '';
        $validated = $request->validate([
            'id' => 'required|exists:slots,id'
        ]);

        $slots = Slot::where('id', $validated['id'])->first();
        $slots->delete();

        return response()->json(["message" => "Slot deleted successfully"]);
    }

    public function upStatusSlots(Request $request)
    {
        $request['id'] = $request->id ?? '';
        $validated = $request->validate([
            'id' => 'required|exists:slots,id',
            'status' => 'required|in:available,booked,blocked',
        ]);

        Slot::updateOrCreate(['id' => $validated['id']], $validated);

        return response()->json(["message" => "Slot status updated successfully"]);
    }

    public function getSlotBySportDate(Request $request)
    {
        $request['sport_id'] = $request->sport_id ?? '';
        $request['slot_date'] = $request->date ?? '';
        $validated = $request->validate([
            'sport_id' => 'required|exists:sports,sports.id',
            'slot_date' => 'required|date',
        ]);

        $slots = Slot::with('sport', 'court')->where('sport_id', $validated['sport_id'])->where('slot_date', $validated['slot_date'])->where('status', 'available')->get();
        
        return response()->json($slots);
    }

    /**
     * Booking Management APIs.
     */
    public function bookSlots(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'group_id' => 'nullable|exists:groups,id',
            'trainer_id' => 'nullable|exists:trainers,id',
            'venue_id' => 'nullable|exists:venues,id',
            'court_id' => 'required|exists:courts,id',
            'sport_id' => 'required|exists:sports,id',
            'slot_id' => 'required|exists:slots,id',
            'is_member_booking' => 'boolean',
            'is_group_game' => 'boolean',
            'game_id' => 'nullable|exists:games,id',
            'membership_id' => 'nullable|exists:memberships,id',
            'booking_date' => 'required|date',
            'number_of_players' => 'required|integer|min:1',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            // 'payment_id' => 'nullable|exists:transactions,id',
            // 'payment_status' => 'required|in:pending,paid,failed,refunded',
            // 'refund_id' => 'nullable|exists:refunds,id',
        ]);

        Booking::create($validated);

        return response()->json(["message" => "Your Slot Booked Successfully"]);
    }

    public function myBooking(Request $request)
    {
        $request['user_id'] = $request->user_id ?? '';
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $bookings = Booking::with('sport', 'court', 'slot', 'game', 'trainer', 'venue', 'group')->where('user_id', $validated['user_id'])->get();
        
        return response()->json($bookings);
    }

    public function bookingDetail(Request $request)
    {
        $request['booking_id'] = $request->id ?? '';
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id'
        ]);

        $bookings = Booking::with('sport', 'court', 'slot', 'game', 'trainer', 'venue', 'group')->where('id', $validated['booking_id'])->first();
        
        return response()->json($bookings);
    }

    public function cancelBooking(Request $request)
    {
        $request['booking_id'] = $request->id ?? '';
        $request['status'] = 'canceled';
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'status' => 'required|in:canceled',
        ]);

        Booking::updateOrCreate(['id' => $validated['booking_id']], $validated);
        
        return response()->json(["message" => "Booking cancelled successfully"]);
    }

    public function getBookings(Request $request)
    {
        $page = $request->page_number ?? 1;
        $offSet = ($page - 1) * env('API_DATA_LIMIT');

        $bookings = Booking::with('user', 'sport', 'court', 'slot', 'game', 'trainer', 'venue', 'group')->limit(env('API_DATA_LIMIT'))->offset($offSet)->get();
        
        return response()->json($bookings);
    }

    public function upStatusBooking(Request $request)
    {
        $request['booking_id'] = $request->id ?? '';
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
        ]);

        Booking::updateOrCreate(['id' => $validated['booking_id']], $validated);
        
        return response()->json(["message" => "Booking status updated successfully"]);
    }

    /**
     * Group Management APIs.
     */
    public function getMyGroups(Request $request)
    {
        $request['user_id'] = $request->user_id ?? '';
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $groups = DB::table('group_members')->select('group_id', 'group_name')->join('groups', function($query) {
            $query->on('group_id', '=', 'id')->where('status', 'active');
        })->where('user_id', $validated['user_id'])->get();
        
        return response()->json($groups);
    }

    public function createGroups(Request $request)
    {
        $validated = $request->validate([
            'group_name' => 'required|string|max:255',
            'created_by' => 'required|exists:users,id',
            'status' => 'required|in:active,inactive'
        ]);

        Group::create($validated);

        return response()->json(["message" => "Group created successfully"]);
    }

    public function getAllGroups(Request $request)
    {
        $page = $request->page_number ?? 1;
        $offSet = ($page - 1) * env('API_DATA_LIMIT');

        $groups = Group::with(['creator'])->select('created_by', 'group_name', 'status')->limit(env('API_DATA_LIMIT'))->offset($offSet)->get();
        
        return response()->json($groups);
    }

    public function joinGroup(Request $request)
    {
        $request['group_id'] = $request->id ?? '';
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'group_id' => 'required|exists:groups,id'
        ]);

        $checkEx = DB::table('group_members')->where('group_id', $validated['group_id'])->where('user_id', $validated['user_id'])->count();

        if($checkEx > 0) {
            return response()->json(["message" => "You Have already joined this group"]);
        } else {
            DB::table('group_members')->insert([
                'group_id' => $validated['group_id'],
                'user_id' => $validated['user_id']
            ]);
    
            return response()->json(["message" => "Group joined successfully"]);
        }
    }

    public function leaveGroup(Request $request)
    {
        $request['group_id'] = $request->id ?? '';
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'group_id' => 'required|exists:groups,id'
        ]);

        $affRow = DB::table('group_members')->where('group_id', $validated['group_id'])->where('user_id', $validated['user_id'])->delete();

        if($affRow > 0) {
            return response()->json(["message" => "Group leaved successfully"]);
        } else {
            return response()->json(["message" => "Something went wrong when leave the group"]);   
        }
    }
}
