<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Venue;
use App\Models\Sport;
use App\Models\Court;
use App\Models\Slot;
use App\Models\Booking;
use App\Models\Group;
use App\Models\Game;
use App\Models\GameParticipant;

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

    /**
     * Trainer Management APIs.
     */
    public function getTrainers(Request $request)
    {
        $page = $request->page_number ?? 1;
        $status = $request->status ?? "";
        $offSet = ($page - 1) * env('API_DATA_LIMIT');

        $trainers = \App\Models\Trainer::limit(env('API_DATA_LIMIT'))->offset($offSet);

        if(!empty($status)) {
            $trainers = $trainers->where('status', $status);
        }

        $trainers = $trainers->get();

        return response()->json($trainers);
    }

    public function createTrainer(Request $request)
    {
        $validated = $request->validate([
            'admin_user_id' => 'required|exists:admin_users,id',
            'name' => 'required|string|max:255',
            'photo' => 'nullable|string',
            'description' => 'nullable|string',
            'sports' => 'required|integer|exists:sports,id',
            'is_kid_trainer' => 'required|boolean',
            'is_adult_trainer' => 'required|boolean',
            'status' => 'required|in:active,inactive',
        ]);

        \App\Models\Trainer::create($validated);

        return response()->json(["message" => "Trainer created successfully"]);
    }

    public function updateTrainer(Request $request)
    {
        $request['id'] = $request->id ?? '';
        $validated = $request->validate([
            'admin_user_id' => 'required|exists:admin_users,id',
            'name' => 'required|string|max:255',
            'photo' => 'nullable|string',
            'description' => 'nullable|string',
            'sports' => 'required|integer|exists:sports,id',
            'is_kid_trainer' => 'required|boolean',
            'is_adult_trainer' => 'required|boolean',
            'status' => 'required|in:active,inactive',
            'id' => 'required|exists:trainers,id',
        ]);

        \App\Models\Trainer::updateOrCreate(['id' => $request->id], $validated);

        return response()->json(["message" => "Trainer updated successfully"]);
    }

    public function deleteTrainer(Request $request)
    {
        $request['id'] = $request->id ?? '';
        $validated = $request->validate([
            'id' => 'required|exists:trainers,id'
        ]);

        $trainer = \App\Models\Trainer::where('id', $validated['id'])->first();
        $trainer->delete();

        return response()->json(["message" => "Trainer deleted successfully"]);
    }

    public function upStatusTrainer(Request $request)
    {
        $request['id'] = $request->id ?? '';
        $validated = $request->validate([
            'id' => 'required|exists:trainers,id',
            'status' => 'required|in:active,inactive',
        ]);

        \App\Models\Trainer::updateOrCreate(['id' => $validated['id']], $validated);

        return response()->json(["message" => "Trainer status updated successfully"]);
    }

    /**
     * Trainer Booking Management APIs.
     */
    public function bookTrainer(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'trainer_id' => 'required|exists:trainers,id',
            'membership_id' => 'nullable|exists:memberships,id',
            'booking_date' => 'required|date',
            'booking_time' => 'required|string',
            'booking_end_time' => 'required|string',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'payment_id' => 'nullable|exists:transactions,id',
        ]);

        \App\Models\TrainerBooking::create($validated);

        return response()->json(["message" => "Trainer booked successfully"]);
    }

    public function myTrainerBookings(Request $request)
    {
        $request['user_id'] = $request->user_id ?? '';
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // Exclude trainer bookings with status 'booked' or 'confirmed' (assuming these mean already booked)
        $trainerBookings = \App\Models\TrainerBooking::with('trainer', 'user', 'membership', 'payment')
            ->where('user_id', $validated['user_id'])
            ->whereNotIn('status', ['booked', 'confirmed'])
            ->get();

        return response()->json($trainerBookings);
    }

    public function trainerBookingDetail(Request $request)
    {
        $request['id'] = $request->id ?? '';
        $validated = $request->validate([
            'id' => 'required|exists:trainer_bookings,id',
        ]);

        $trainerBooking = \App\Models\TrainerBooking::with('trainer', 'user', 'membership', 'payment')->where('id', $validated['id'])->first();

        return response()->json($trainerBooking);
    }

    public function cancelTrainerBooking(Request $request)
    {
        $request['id'] = $request->id ?? '';
        $request['status'] = 'canceled';
        $validated = $request->validate([
            'id' => 'required|exists:trainer_bookings,id',
            'status' => 'required|in:canceled',
        ]);

        \App\Models\TrainerBooking::updateOrCreate(['id' => $validated['id']], $validated);

        return response()->json(["message" => "Trainer booking cancelled successfully"]);
    }

    public function getTrainerBookings(Request $request)
    {
        $page = $request->page_number ?? 1;
        $offSet = ($page - 1) * env('API_DATA_LIMIT');

        $trainerBookings = \App\Models\TrainerBooking::with('trainer', 'user', 'membership', 'payment')->limit(env('API_DATA_LIMIT'))->offset($offSet)->get();

        return response()->json($trainerBookings);
    }

    public function upStatusTrainerBooking(Request $request)
    {
        $request['id'] = $request->id ?? '';
        $validated = $request->validate([
            'id' => 'required|exists:trainer_bookings,id',
            'status' => 'required|in:pending,confirmed,canceled,completed',
        ]);

        \App\Models\TrainerBooking::updateOrCreate(['id' => $validated['id']], $validated);

        return response()->json(["message" => "Trainer booking status updated successfully"]);
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

        // Include image_category in response
        $sports = $sports->map(function ($sport) {
            return [
                'id' => $sport->id,
                'sport_name' => $sport->sport_name,
                'venue_id' => $sport->venue_id,
                'court_count' => $sport->court_count,
                'shared_with' => $sport->shared_with,
                'pricing_peak' => $sport->pricing_peak,
                'pricing_non_peak' => $sport->pricing_non_peak,
                'status' => $sport->status,
                'image' => $sport->image,
                'image_category' => $sport->image_category,
                'descriptions' => $sport->descriptions,
                'facilities' => $sport->facilities,
                'venue' => $sport->venue,
                'created_at' => $sport->created_at,
                'updated_at' => $sport->updated_at,
            ];
        });
        
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
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'descriptions' => 'nullable|string',
            'facilities' => 'nullable|string',
        ]);

        $validated['shared_with'] = $validated['shared_with'] ?? [];

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('sports', 'public');
                $imagePaths[] = $path;
            }
        }
        $validated['images'] = $imagePaths;

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
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'descriptions' => 'nullable|string',
            'facilities' => 'nullable|string',
            'id' => 'required|exists:sports,id'
        ]);

        $validated['shared_with'] = $validated['shared_with'] ?? [];

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('sports', 'public');
                $imagePaths[] = $path;
            }
        }
        $validated['images'] = $imagePaths;

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

        // Include image_category in response
        $sport = [
            'id' => $sport->id,
            'sport_name' => $sport->sport_name,
            'venue_id' => $sport->venue_id,
            'court_count' => $sport->court_count,
            'shared_with' => $sport->shared_with,
            'pricing_peak' => $sport->pricing_peak,
            'pricing_non_peak' => $sport->pricing_non_peak,
            'status' => $sport->status,
            'image' => $sport->image,
            'image_category' => $sport->image_category,
            'descriptions' => $sport->descriptions,
            'facilities' => $sport->facilities,
            'venue' => $sport->venue,
            'created_at' => $sport->created_at,
            'updated_at' => $sport->updated_at,
        ];

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

        // Transform courts to include images and description explicitly
        $courts = $courts->map(function ($court) {
            return [
                'id' => $court->id,
                'sport_id' => $court->sport_id,
                'court_name' => $court->court_name,
                'court_type' => $court->court_type,
                'status' => $court->status,
                'images' => $court->images ?? [],
                'description' => $court->description ?? '',
                'sport' => $court->sport,
                'created_at' => $court->created_at,
                'updated_at' => $court->updated_at,
            ];
        });
        
        return response()->json($courts);
    }

    public function createCourts(Request $request)
    {
        $validated = $request->validate([
            'court_name' => 'required|string|max:255',
            'sport_id' => 'required|exists:sports,id',
            'status' => 'required|in:active,inactive,maintenance',
            'court_type' => 'required|in:shared,dedicated',
            'description' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('courts', 'public');
                $imagePaths[] = $path;
            }
        }
        $validated['images'] = $imagePaths;

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
            'description' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'id' => 'required|exists:courts,id'
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('courts', 'public');
                $imagePaths[] = $path;
            }
            $validated['images'] = $imagePaths;
        } else {
            // If no new images uploaded, keep existing images
            $court = Court::find($request->id);
            $validated['images'] = $court ? $court->images : [];
        }

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

        // Transform courts to include images and description explicitly
        $courts = $courts->map(function ($court) {
            return [
                'id' => $court->id,
                'sport_id' => $court->sport_id,
                'court_name' => $court->court_name,
                'court_type' => $court->court_type,
                'status' => $court->status,
                'images' => $court->images ?? [],
                'description' => $court->description ?? '',
                'created_at' => $court->created_at,
                'updated_at' => $court->updated_at,
            ];
        });
        
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

    public function getAvailableSlotsBySportCourt(Request $request)
    {
        $validated = $request->validate([
            'sport_id' => 'required|exists:sports,id',
            'court_id' => 'required|exists:courts,id',
        ]);

        $today = date('Y-m-d');

        // Get slots for sport and court from today onwards with status 'available'
        $slots = Slot::where('sport_id', $validated['sport_id'])
            ->where('court_id', $validated['court_id'])
            ->where('slot_date', '>=', $today)
            ->where('status', 'available')
            ->get();

        // Filter out slots that are fully booked
        $availableSlots = $slots->filter(function ($slot) {
            $bookedCount = \App\Models\Booking::where('slot_id', $slot->id)
                ->whereIn('status', ['pending', 'confirmed'])
                ->count();
            return $bookedCount < $slot->available_slots;
        })->values();

        return response()->json($availableSlots);
    }

     /**
     * Create a new game by the authenticated user.
     */
    public function createGame(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sport_id' => 'required|exists:sports,id',
            'court_id' => 'required|exists:courts,id',
            'slot_id' => 'required|exists:slots,id',
            'group_id' => 'nullable|exists:groups,id',
            'is_split_payment' => 'boolean',
            'status' => 'required|in:pending,confirmed,canceled,completed',
            'payment_id' => 'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        // Check if slot is confirmed or booked
        $slot = \App\Models\Slot::find($data['slot_id']);
        if (!$slot || in_array($slot->status, ['confirmed', 'booked'])) {
            return response()->json(['error' => 'Cannot create game for a slot that is already confirmed or booked.'], 422);
        }

        $data['created_by'] = $request->user()->id;

        $game = Game::create($data);

        // If game status is confirmed, update slot status to booked
        if ($data['status'] === 'confirmed') {
            $slot = \App\Models\Slot::find($data['slot_id']);
            if ($slot) {
                $slot->status = 'booked';
                $slot->save();
            }
        }

        // Add creator as participant by default
        // GameParticipant::create([
        //     'game_id' => $game->id,
        //     'user_id' => $data['created_by'],
        //     'is_confirmed' => true,
        //     'has_paid' => false,
        //     'amount_paid' => 0,
        // ]);

        return response()->json(['message' => 'Game created successfully', 'game' => $game], 201);
    }

    /**
     * Invite a user to a game.
     */
    public function inviteUser(Request $request, $gameId)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'team' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $game = Game::findOrFail($gameId);

        // Check if user is already a participant
        $existing = GameParticipant::where('game_id', $gameId)
            ->where('user_id', $request->user_id)
            ->first();

        if ($existing) {
            return response()->json(['message' => 'User already invited or participating'], 400);
        }

        $participant = GameParticipant::create([
            'game_id' => $gameId,
            'user_id' => $request->user_id,
            'team' => $request->team,
            'is_confirmed' => false,
            'has_paid' => false,
            'amount_paid' => 0,
        ]);

        return response()->json(['message' => 'User invited successfully', 'participant' => $participant], 201);
    }

    /**
     * List games for the authenticated user.
     */
    public function listUserGames(Request $request)
    {
        $userId = $request->user()->id;

        $games = Game::where('created_by', $userId)
            ->with('participants')
            ->paginate(10);

        return response()->json($games);
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
