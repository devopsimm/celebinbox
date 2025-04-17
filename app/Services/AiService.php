<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AiService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('AI_KEY'); // or config('services.ai.key')
    }

    // protected $apiKey = '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';

    protected $apiUrl = 'https://api.openai.com/v1/chat/completions'; // Replace with your API endpoint
    public function getResponse($prompt,$systemPrompt=false)
    {
        if (!$systemPrompt){
            $systemPrompt = 'Please rephrase only the text content in the following HTML code while keeping all HTML tags, attributes, and images intact. Replace any <a> tags with <span> tags and remove the href attributes, but do not modify the structure or content of any tags.';
        }
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->timeout(90)->post($this->apiUrl, [
            'model' => 'gpt-4-turbo', // Specify the AI model
           // 'prompt' => $prompt,
            'messages' => [
                [
                    'role' => 'system',
                    'content' => $systemPrompt
                ],
                [
                    'role' => 'user',
                    'content' => $prompt,
                ]
            ],
            'max_tokens' => 1500, // Adjust token limit
        ]);

        if ($response->successful()) {
            return $response->json();
        }

       // dd($response->body());
        return ['error' => $response->status(), 'message' => $response->body()];
    }

    public function generateImage($prompt,$postId,$postSlug)
    {
        //$prompt = 'I NEED to test how the tool works with extremely simple prompts. DO NOT add any detail, just use it AS-IS';

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->post('https://api.openai.com/v1/images/generations', [
            'prompt' => $prompt,
            'n' => 1,
            'size' => '1024x1024',
        ]);

        if ($response->successful()) {
            // Get the URL of the generated image
            $imageUrl = $response->json()['data'][0]['url'];

            // Download the image content
            $imageContent = file_get_contents($imageUrl);

            // Generate a unique filename for the image
            $imageName = $postSlug.'_' . $postId . '_' . time() . '.png';

            // Define the file path where you want to save the image inside the 'public' directory
            $imagePath = public_path('images/' . $imageName);

            // Save the image to the 'public/images' folder
            file_put_contents($imagePath, $imageContent);

            // Now use your existing uploadImgAi function to handle the image (and generate thumbnails if necessary)
            $gService = new GeneralService();

            // Call your uploadImgAi function to store the image and generate thumbnails
            $serviceImg = $gService->uploadImgAi($imagePath, 'posts/featureImages', 'postThumbnails');

            // After the image is uploaded to storage, delete it from the public folder
//            if (file_exists($imagePath)) {
//                unlink($imagePath); // Deletes the image from the public path
//            }

            return $serviceImg; // Return the image URL or path
        }


//        if ($response->successful()) {
//            // Get the URL of the generated image
//            $imageUrl = $response->json()['data'][0]['url'];
//
//            // Download the image content
//            $imageContent = file_get_contents($imageUrl);
//
//            // Define the file path where you want to save the image inside the 'public' directory
//            $imagePath = public_path('images/generated_image_'.$postId.'_' . time() . '.png');
//
//            // Save the image directly to the public folder
//           // file_put_contents($imagePath, $imageContent);
//
//            $gService = new GeneralService();
//
//            $serviceImg = $gService->uploadImgAi($imagePath,'posts/featureImages','postThumbnails');
//            return $serviceImg;
//            //return 'images/generated_image_'.$postId.'_'  . time() . '.png'; // Return the file path
//        }

       return  false;
    }


}
