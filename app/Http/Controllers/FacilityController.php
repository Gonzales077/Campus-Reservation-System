<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FacilityController extends Controller
{
    /**
     * Get predefined facility names for dropdown
     */
    private function getFacilityNames()
    {
        return [
            'Chapel', 'Gymnasium', 'CE Lab', 'Computer Lab A',
            'Computer Lab B', 'Chem Lab', 'CPE Lab',
            'Drawing Room', 'Physics Lab', 'Pyschology Lab', 'Criminal & Justice Lab', 'Hospitality and Tourism Training Facilities','Academic & Learning Facilitiy',
        ];
    }

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
            Log::error('Geocoding error: ' . $e->getMessage());
        }
        
        return ['latitude' => 15.0879, 'longitude' => 120.8544];
    }

    /**
     * Smart Media Mapper - Hardcoded Image Paths
     */
   private function getFacilityMedia($name)
    {
        return match($name) {
            'Chapel' => [
                'thumb' => 'chapthumb.jpg',
                'gallery' => ['chap1.jpg', 'chap2.jpg', 'chap3.jpg'] 
            ],
            'CE Lab' => [
                'thumb' => 'pic3.jpg',
                'gallery' => ['pic1.jpg', 'pic2.jpg', 'pic3.jpg']
            ],
            'Chem Lab' => [
                'thumb' => 'chemthumb.jpg',
                'gallery' => ['chem1.jpg', 'chem2.jpg', 'chem3.jpg']
            ],
            'Computer Lab B' => [
                'thumb' => 'comb1.jpg',
                'gallery' => ['comb1.jpg', 'comb2.jpg', 'comb1.jpg']
            ],
            'Computer Lab A' => [
                'thumb' => 'coma1.jpg',
                'gallery' => ['coma1.jpg', 'coma3.jpg', 'com2.jpg']
            ],
            'Gymnasium' => [
                'thumb' => 'gym1.jpg',
                'gallery' => ['gym1.jpg', 'gym1.jpg', 'gym1.jpg']
            ],
            'CPE Lab' => [
                'thumb' => 'cpe1.jpg',
                'gallery' => ['cpe1.jpg', 'cpe2.jpg', 'cpe3.jpg']
            ],
            'Pyschology Lab' => [
                'thumb' => 'cholo1.jpg',
                'gallery' => ['cholo1.jpg', 'cholo2.jpg', 'cholo3.jpg']
            ],
            'Physics Lab' => [
                'thumb' => 'phy1.jpg',
                'gallery' => ['phy1.jpg', 'phy2.jpg', 'phy1.jpg']
            ],
            'Drawing Room' => [
                'thumb' => 'draw1.jpg',
                'gallery' => ['draw1.jpg', 'draw2.jpg', 'draw1.jpg']
            ],
            'Criminal & Justice Lab' => [
                'thumb' => 'crim1.jpg',
                'gallery' => ['crim1.jpg', 'crim2.jpg', 'crim3.jpg']
            ],
            'Hospitality and Tourism Training Facilities' => [
                'thumb' => 'hm1.jpg',
                'gallery' => ['hm2.jpg', 'hm3.jpg', 'hm4.jpg']
            ],
            'Academic & Learning Facilitiy' => [
                'thumb' => 'acad1.jpg',
                'gallery' => ['acad1.jpg', 'acad2.jpg', 'acad3.jpg']
            ],
            default => [
                'thumb' => 'default_thumb.jpg',
                'gallery' => ['default_1.jpg', 'default_2.jpg', 'default_3.jpg']
            ],
        };
    }

    public function create()
    {
        $facilityNames = $this->getFacilityNames();
        return view('facilities.create', compact('facilityNames'));
    }

    public function store(Request $request)
    {
        $facilityNames = $this->getFacilityNames();
        
        $validated = $request->validate([
            'name' => 'required|in:' . implode(',', $facilityNames),
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'available_hours' => 'required|integer|min:1',
        ]);

        $coordinates = $this->geocodeLocation($validated['location']);
        $validated['latitude'] = $coordinates['latitude'];
        $validated['longitude'] = $coordinates['longitude'];
        $validated['created_by'] = auth()->id();

        $media = $this->getFacilityMedia($validated['name']);
        
        $validated['thumbnail'] = 'images/facilities/' . $media['thumb'];
        $validated['images'] = array_map(fn($img) => 'images/facilities/' . $img, $media['gallery']);
        $validated['status'] = 'active';

        Facility::create($validated);

        return redirect()->route('admin.dashboard')->with('toast_success', 'Facility created with automated media sync!');
    }

    /**
     * ADDED EDIT METHOD
     */
    public function edit(Facility $facility)
    {
        $facilityNames = $this->getFacilityNames();
        // Updated to use 'facilities.edit' to match your 'facilities.create' structure
        return view('facilities.edit', compact('facility', 'facilityNames'));
    }

    public function update(Request $request, Facility $facility)
    {
        $facilityNames = $this->getFacilityNames();
        
        $validated = $request->validate([
            'name' => 'required|in:' . implode(',', $facilityNames),
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'available_hours' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validated['name'] !== $facility->name) {
            $media = $this->getFacilityMedia($validated['name']);
            $validated['thumbnail'] = 'images/facilities/' . $media['thumb'];
            $validated['images'] = array_map(fn($img) => 'images/facilities/' . $img, $media['gallery']);
        }

        if ($validated['location'] !== $facility->location) {
            $coordinates = $this->geocodeLocation($validated['location']);
            $validated['latitude'] = $coordinates['latitude'];
            $validated['longitude'] = $coordinates['longitude'];
        }

        $facility->update($validated);

        return redirect()->route('admin.dashboard')->with('toast_success', 'Facility updated successfully!');
    }

    public function destroy(Facility $facility)
    {
        if ($facility->reservations()->exists()) {
            return redirect()->route('admin.dashboard')->with('toast_error', 'Cannot delete facility with existing reservations.');
        }
        
        $facility->delete();
        return redirect()->route('admin.dashboard')->with('toast_success', 'Facility deleted successfully!');
    }
}