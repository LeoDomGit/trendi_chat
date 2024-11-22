<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\Character;

class CharacterSeeder extends Seeder
{
    public function run()
    {
        $characters = [
            ['name' => 'GPT', 'instructions' => 'A general-purpose AI model for various tasks', 'model' => 'gpt-4o'],
            ['name' => 'AI Joke', 'instructions' => 'An AI assistant to tell jokes', 'model' => 'gpt-4o'],
            ['name' => 'AI Math', 'instructions' => 'An AI assistant to solve math problems', 'model' => 'gpt-4o'],
            ['name' => 'AI Poem', 'instructions' => 'An AI assistant that creates poems', 'model' => 'gpt-4o'],
            ['name' => 'Translator AI', 'instructions' => 'An AI assistant that translates text', 'model' => 'gpt-4o'],
            ['name' => 'Relationship AI', 'instructions' => 'An AI assistant for relationship advice', 'model' => 'gpt-4o'],
        ];

        foreach ($characters as $characterData) {
            Log::info('Processing character: ' . $characterData['name']);

            // Step 1: Make API call to create assistant
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                'OpenAI-Beta' => 'assistants=v2',
            ])->post('https://api.openai.com/v1/assistants', [
                'instructions' => $characterData['instructions'],
                'name' => $characterData['name'],
                'model' => $characterData['model'],
            ]);

            if ($response->successful()) {
                $apiData = $response->json();
                $assistantId = $apiData['id'];

                // Step 2: Create the character record
                Character::create([
                    'fullname' => $characterData['name'] . ' Character',
                    'seed' => Str::random(10),
                    'assistant_id' => $assistantId,
                    'assistant_intro' => 'This is a character for the ' . $characterData['name'],
                    'instructions' => $characterData['instructions'],
                    'tools' => json_encode($apiData['tools'] ?? []),
                    'model' => $characterData['model'],
                    'slug' => Str::slug($characterData['name']),
                    'opening_greeting' => 'Hello, I am the ' . $characterData['name'] . ' character!',
                    'avatar' => 'default_avatar_url',
                    'is_public' => 1,
                    'is_active' => 1,
                ]);
            } else {
                Log::error("Failed to create character: " . $characterData['name'], [
                    'status' => $response->status(),
                    'response' => $response->body(),
                ]);
            }

            // Optional delay to avoid hitting API limits
            sleep(3);
        }
    }
}
