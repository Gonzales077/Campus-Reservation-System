<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    /**
     * Geocode location using OpenStreetMap Nominatim API
     */
    private function geocodeLocation($location)
    {
        try {
            $url = 'https://nominatim.openstreetmap.org/search?q=' . urlencode($location . ', Sta. Lucia, Pampanga, Philippines') . '&format=json&limit=1';
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_USERAGENT, 'HCC-Facilities-App/1.0');
            
            $response = curl_exec($ch);
            curl_close($ch);
            
            if ($response) {
                $results = json_decode($response, true);
                if (!empty($results) && isset($results[0]['lat']) && isset($results[0]['lon'])) {
                    return [
                        'latitude' => (float)$results[0]['lat'],
                        'longitude' => (float)$results[0]['lon']
                    ];
                }
            }
        } catch (\Exception $e) {
            \Log::error('Geocoding error: ' . $e->getMessage());
        }
        
        // Default to school center if geocoding fails
        return [
            'latitude' => 15.0879,
            'longitude' => 120.8544
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $facilities = Facility::where('status', 'active')->get();
        return view('facilities.index', compact('facilities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('facilities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'available_hours' => 'required|integer|min:1',
        ]);

        // Auto-geocode the location
        $coordinates = $this->geocodeLocation($validated['location']);
        $validated['latitude'] = $coordinates['latitude'];
        $validated['longitude'] = $coordinates['longitude'];
        $validated['created_by'] = auth()->id();

        Facility::create($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Facility created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Facility $facility)
    {
        return view('facilities.show', compact('facility'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Facility $facility)
    {
        return view('facilities.edit', compact('facility'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Facility $facility)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'available_hours' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);

        // Re-geocode if location changed
        if ($validated['location'] !== $facility->location) {
            $coordinates = $this->geocodeLocation($validated['location']);
            $validated['latitude'] = $coordinates['latitude'];
            $validated['longitude'] = $coordinates['longitude'];
        }

        $facility->update($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Facility updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Facility $facility)
    {
        // Check if facility has any reservations
        if ($facility->reservations()->exists()) {
            return redirect()->route('admin.dashboard')->with('error', 'Cannot delete facility with existing reservations. Please remove all reservations first.');
        }
        
        $facility->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Facility deleted successfully!');
    }
}
