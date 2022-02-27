# Testing the Github Users API
Open your Postman application. This is the application we will use to test the API end points.

## Testing the user registration API
* Perform a POST request to `http://localhost:18000/v1/api/registration` with the following JSON request body.
    ```json
    {
        "email": "user@domain.com",
        "password": "ThisPasswordIsVerySecured",
        "passwordConfirmation": "ThisPasswordIsVerySecured"
    }
    ```
    ![Register user postman API request example](images/02-01.png)
    
    _The request body must be RAW and in JSON format._
    
* It should return a response body like this.
    ```json
    {
        "id": "52a034745478b5e91cf06315c6bcff51",
        "accessToken": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI1MmEwMzQ3NDU0NzhiNWU5MWNmMDYzMTVjNmJjZmY1MSIsImVtYWlsIjoidXNlckBkb21haW4uY29tIiwiaXNzIjoiaHR0cDovL2F3ZXNvbWUtdGVjaG5pY2FsLWV4YW0uY29tIiwiaWF0IjoxNjQ1OTQ3MjMwLCJleHAiOjE2NDU5NTA4MzB9.jcynlVvoirZ6B_OY_FyAS2GxZPM8Ksq2rO43OK0z8mY",
        "tokenType": "bearer",
        "expiresIn": 1645950830
    }
    ```

    ![Register user postman API response example](images/02-02.png)

## Testing the user login API
* Perform a POST request to `http://localhost:18000/v1/api/access_token` with the following JSON request body.
    ```json
    {
        "email": "user@domain.com",
        "password": "ThisPasswordIsVerySecured"
    }
    ```
  
    ![User login postman API request example](images/02-03.png)
    
* It should return a response body like this.
    ```json
    {
        "accessToken": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI1MmEwMzQ3NDU0NzhiNWU5MWNmMDYzMTVjNmJjZmY1MSIsImVtYWlsIjoidXNlckBkb21haW4uY29tIiwiaXNzIjoiaHR0cDovL2F3ZXNvbWUtdGVjaG5pY2FsLWV4YW0uY29tIiwiaWF0IjoxNjQ1OTQ4NDg3LCJleHAiOjE2NDU5NTIwODd9.G7lNwWTXe81DQH0crBsh1l4a-zNz52mJCII67A-pyJE",
        "tokenType": "bearer",
        "expiresIn": 1645952087
    }
    ```
  
    ![User login postman API response example](images/02-04.png)
  
## Testing the Github users API
* Perform a GET request to `http://localhost:18000/v1/api/users?username=ericksonreyes`. Use the value of the `accessToken`
key from the user login API response as Authentication for the request. The request should look like this.
  
  ![User login postman API response example](images/02-05.png)

* It should have a response body like this.
    ```json
    {
        "_embedded": {
            "users": [
                {
                    "id": 841321,
                    "login": "ericksonreyes",
                    "name": "Erickson Reyes",
                    "company": "Sourcefit Philippines",
                    "followers": 8,
                    "public_repository_count": 20,
                    "average_number_of_public_repository_followers": 1,
                    "origin_repository": "Github"
                }
            ]
        }
    }
    ```
  
    ![User login postman API response example](images/02-06.png)
    
    The `origin_repository` is `Github`. It means it was fetched from the official Github user API.

* Perform the same request again within two minutes from the first request. It should return a response body like this.
    ```json
    {
        "_embedded": {
            "users": [
                {
                    "id": 841321,
                    "login": "ericksonreyes",
                    "name": "Erickson Reyes",
                    "company": "Sourcefit Philippines",
                    "followers": 8,
                    "public_repository_count": 20,
                    "average_number_of_public_repository_followers": 1,
                    "origin_repository": "Cache"
                }
            ]
        }
    }
    ```
  
    ![User login postman API response example](images/02-07.png)
    
    The `origin_repository` is `Cache`. It means it was fetched from the Redis caching service. The speed should be 
    significantly improved.


## Searching for multiple Github users.    
* You can search for multiple users by sending a GET request to `http://localhost:18000/v1/api/users?username=ericksonreyes,octocat,hindi_totoong_user,ryan`. 
Multiple usernames should be comma-separated. 

    ![User login postman API response example](images/02-08.png)
    
* It should have a response body like this.
    
    ![User login postman API response example](images/02-09.png)

    The user `hindi_totoong_user` should not be listed since it is not existing or registered. No errors will be raised 
    and it will just be simply ignored. 