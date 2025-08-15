<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AIIntegrationController extends Controller
{
    /**
     * Display the AI integration settings.
     */
    public function index()
    {
        return view('admin.ai-integration');
    }

    /**
     * Update the AI integration settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'openai_api_key' => 'nullable|string|max:255',
            'openai_model' => 'nullable|string|max:100',
            'ai_enabled' => 'boolean',
            'auto_generate_descriptions' => 'boolean',
            'ai_temperature' => 'nullable|numeric|min:0|max:2',
        ]);

        // Here you would save the AI settings to your config or database
        // For now, we'll just redirect back with success
        
        return redirect()->route('admin.ai-integration')
            ->with('success', 'AI integration settings updated successfully!');
    }
}
