# API Documentation

## Overview

This API provides endpoints for sort character and calculating the minimum number of buses required based on family sizes.

This API is for test logical needs for Nawadata.

Base URL: `http://your-local-host/api`

## Endpoints

### Sort Character

Endpoint to process a string and return vowels and consonants.

- **URL:** `/sort-character`
- **Method:** `POST`
- **Request:**
  
  ```json
  {
      "word": "Sample Case"
  }
  ```

- **Response (Success):**
  
  ```json
  {
    "vowels": "aae",
    "consonants": "smplcs"
  }
  ```

- **Response (Error - 400 Bad Request):**
  
  ```json
  {
    "message": "The given data was invalid.",
    "errors": {
        "word": ["The word field is required."]
    }
  }
  ```


### Minimum Bus Required

Endpoint to calculate the minimum number of buses required.

- **URL:** `/min-bus`
- **Method:** `POST`
- **Request:**
  
  ```json
  {
    "n": 8,
    "members": "2 3 4 4 2 1 3 1"
  }
  ```
- **Response (Success):**
  
  ```json
  {
    "message": "Minimum bus required is 5"
  }
  ```

- **Response (Error - 400 Bad Request):**
  
  ```json
  {
    "message": "The given data was invalid.",
    "errors": {
        "n": ["The n field is required."],
        "members": ["The members field is required."]
    }
  }
  ```