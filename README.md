# faq

1. git clone https://github.com/nitro41992/faq.git
2. cd into /faq and run composer install
3. cp .env.example to .env
4. setup database with sqlite or other database (https://laravel.com/docs/5.8/database)


## **Release Notes**

**heroku link:** http://damp-earth-66899.herokuapp.com/

**Epic:** Display all questions ordered by votes and allow an authenticated user to vote on questions. Also, allow the user to search by question and manage the specific questions previously voted on.

**User Stories:**

 1. Any user should be able to view all questions that are available on the faq website upon visiting the main page but voting should be disabled.
 2. Authenticated users should be able to view questions and add answers to a question.
 3. Authenticated users should be able to upvote or downvote a question.
 4. Questions should only be able to be voted on once by an authenticated user. A user should be able to vote up or down only once per question.
 5. An authenticated user should be able to cancel an upvote or downvote which should make their vote neutral for that question.
 6. All questions that a user voted on should be viewable as a part of their account.
 7. A user should be able to search for a question.
 8. An authenticated user should be able to see the questions they created as part of their account.

**Other Notes:**

 - Implemented ajax in order to allow for upvoting and downvoting without refreshing the page.
 - Use test username: stoltenberg.rachelle@example.net and test password: "password" in order to login or create user by clicking on Register.
