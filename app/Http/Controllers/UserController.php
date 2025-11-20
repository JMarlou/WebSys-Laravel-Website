<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use App\Models\User;
    use App\Models\PersonalInfo;
    use App\Models\Education;
    use App\Models\Skill;
    use App\Models\Experience;

    /**
     * UserController
     * Manages resume CRUD operations:
     * - Personal Information
     * - Education
     * - Skills
     * - Experience
     * - Public Resume Display
     * 
     * All methods except showPublicResume() require authentication
     */
    class UserController extends Controller
    {
        // DASHBOARD & PERSONAL INFO
        //Display the admin dashboard
        //Shows all resume data for editing
        
        public function dashboard()
        {
            // Get the currently authenticated user
            $user = Auth::user();
            
            // Get personal info (expect only 1 record in database)
            $info = PersonalInfo::first();
            
            // Fetch all education, skills, and experience records
            $education = Education::all();
            $skills = Skill::all();
            $experiences = Experience::all();
            
            // If no personal info exists, create a blank template
            // This prevents errors when displaying the form
            if (!$info) {
                $info = new PersonalInfo([
                    'name' => '',
                    'title' => '',
                    'location' => '',
                    'phone' => '',
                    'email' => '',
                    'github' => '',
                    'summary' => '',
                ]);
            }
            
            // Pass all data to the dashboard view
            return view('dashboard', compact('user', 'info', 'education', 'skills', 'experiences'));
        }

        public function updateResume(Request $request)
        {
            // Validate all incoming data
            $validated = $request->validate([
                'name' => 'required|string|max:255',      // Required field
                'title' => 'nullable|string|max:255',     // Optional
                'location' => 'nullable|string|max:255',  // Optional
                'phone' => 'nullable|string|max:20',      // Optional, max 20 chars
                'email' => 'required|email|max:255',      // Required, must be valid email
                'github' => 'nullable|url|max:255',       // Optional, must be valid URL
                'summary' => 'nullable|string',           // Optional, no length limit
            ]);

            // Get the first (and should be only) personal info record
            $info = PersonalInfo::first();

            // If record exists, update it; otherwise create new
            if ($info) {
                $info->update($validated);
            } else {
                PersonalInfo::create($validated);
            }

            // Redirect back to dashboard with success message
            return back()->with('success', 'Personal information updated successfully!');
        }

        public function addEducation(Request $request)
        {
            // Validate education data
            $validated = $request->validate([
                'level' => 'required|string|max:255',   
                'school' => 'required|string|max:255',
                'years' => 'required|string|max:255',   
            ]);

            // Create new education record
            Education::create($validated);
            
            return back()->with('success', 'Education added successfully!');
        }

        public function updateEducation(Request $request, $id)
        {
            // Validate updated data
            $validated = $request->validate([
                'level' => 'required|string|max:255',
                'school' => 'required|string|max:255',
                'years' => 'required|string|max:255',
            ]);

            // Find education record or throw 404 if not found
            $education = Education::findOrFail($id);
            
            // Update the record with validated data
            $education->update($validated);
            
            return back()->with('success', 'Education updated successfully!');
        }

        public function deleteEducation($id)
        {
            // Find and delete the education record
            // findOrFail() will throw 404 if record doesn't exist
            Education::findOrFail($id)->delete();
            
            return back()->with('success', 'Education deleted successfully!');
        }

        public function addSkill(Request $request)
        {
            // Validate skill name
            $validated = $request->validate([
                'skill' => 'required|string|max:255',
            ]);

            // Create new skill record
            Skill::create($validated);
            
            return back()->with('success', 'Skill added successfully!');
        }

        public function deleteSkill($id)
        {
            // Find and delete the skill
            Skill::findOrFail($id)->delete();
            
            return back()->with('success', 'Skill deleted successfully!');
        }

        public function addExperience(Request $request)
        {
            // Validate experience description
            $validated = $request->validate([
                'description' => 'required|string',  // No max length - can be long
            ]);

            // Create new experience record
            Experience::create($validated);
            
            return back()->with('success', 'Experience added successfully!');
        }

        public function updateExperience(Request $request, $id)
        {
            // Validate updated description
            $validated = $request->validate([
                'description' => 'required|string',
            ]);

            // Find and update the experience record
            $experience = Experience::findOrFail($id);
            $experience->update($validated);
            
            return back()->with('success', 'Experience updated successfully!');
        }

        public function deleteExperience($id)
        {
            // Find and delete the experience
            Experience::findOrFail($id)->delete();
            
            return back()->with('success', 'Experience deleted successfully!');
        }

        // PUBLIC RESUME VIEW

        /**
         * Display public resume page
         * This is publicly accessible (no authentication required).
         * Shows the complete resume with all sections.
         */
        
        public function showPublicResume($id = 1)
        {
            // Try to find personal info by ID
            $info = PersonalInfo::find($id);
            
            // If not found, get the first record
            if (!$info) {
                $info = PersonalInfo::first();
            }
            
            // If still no data exists, show 404 error
            if (!$info) {
                abort(404, 'No resume found. Please create one in the dashboard first.');
            }
            
            // Fetch all related data
            $education = Education::all();
            $skills = Skill::all();
            $experiences = Experience::all();
            
            // Return public resume view with all data
            return view('public.resume', compact('info', 'education', 'skills', 'experiences'));
        }
    }