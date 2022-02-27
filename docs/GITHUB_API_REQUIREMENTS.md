# Github Users API 

## Requirements
Create PHP API project that has an API endpoint that takes a list of github
usernames (up to a maximum of 10 names) and returns to the user a list of basic
information for those users including:
- Name
- Login
- Company
- Number of followers
- Number of public repositories
- The average number of followers per public repository (ie. number of followers divided
by the number of public repositories)

In order to access the API endpoint described above, another endpoint should be created for
user registration and login.

## Required technologies
- PHP
- Redis
- MySQL
- Choose a framework that you are familiar with. 

## Rules
- Schema for User registration should be created in MySQL
- Only registered users can request a list of GitHub user information.
- The returned users should be sorted alphabetically by name
- If some usernames cannot be found, this should not fail the other usernames requested
- Implement a caching layer using Redis that will store a user that has been retrieved from
GitHub for 2 minutes
- Each user should be cached individually. For example, if I request users A and B, then do another request inside 2 minutes for users B, C and D, user B should come from the cache and users C and D should come from GitHub.
- If a user is returned from the cache, it should not call GitHub API
- The API endpoint needed to get github user information is `https://api.github.com/users/{username}`
- Include proper error handling
- Include proper logging