<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class LogicalTestController extends Controller
{
    // Function to check if a character is a vowel
    private function isVowel($char) {
        $vowels = ['a', 'e', 'i', 'o', 'u'];
        return in_array($char, $vowels);
    }

    // Function to process the string and return vowels and consonants
    public function sortCharacterHandler(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'word' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $str = $request->input('word'); // Get input string

        $vowels = [];
        $consonants = [];

        // Remove white spaces and convert to lowercase
        $strWithoutWhiteSpace = str_replace(' ', '', $str);
        $strWithoutWhiteSpace = strtolower($strWithoutWhiteSpace);

        // Loop through each character in the string
        for ($i = 0; $i < strlen($strWithoutWhiteSpace); $i++) {
            $char = $strWithoutWhiteSpace[$i];
            if ($this->isVowel($char)) {
                $vowels[] = $char;
            } else {
                $consonants[] = $char;
            }
        }

        // Join arrays to create strings
        $vowelsStr = implode('', $vowels);
        $consonantsStr = implode('', $consonants);

        // Return results as JSON response
        return response()->json([
            'vowels' => $vowelsStr,
            'consonants' => $consonantsStr
        ]);
    }

    // Function to calculate the minimum number of buses required
    public function minBusHandler(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'n' => 'required|integer|min:1',
            'members' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $n = $request->input('n');
        $members = $request->input('members');
        $arrMembers = explode(' ', $members);

        if (count($arrMembers) != $n) {
            return response()->json([
                'message' => 'Input must be equal with count of family'
            ], Response::HTTP_BAD_REQUEST);
        }

        $families = [];
        foreach ($arrMembers as $m) {
            if (!is_numeric($m) || intval($m) <= 0) {
                return response()->json([
                    'message' => 'Input not valid'
                ], Response::HTTP_BAD_REQUEST);
            }
            $families[] = intval($m);
        }

        $bus = $this->calculateMinBus($families);

        return response()->json([
            'message' => "Minimum bus required is $bus"
        ]);
    }

    // Helper function to calculate the minimum number of buses required
    private function calculateMinBus($families)
    {
        sort($families);
        $bus = 0;
        $i = 0;
        $j = count($families) - 1;

        while ($i <= $j) {
            if ($families[$i] + $families[$j] <= 4 && $i != $j) {
                $i++;
            }
            $j--;
            $bus++;
        }

        return $bus;
    }
}
