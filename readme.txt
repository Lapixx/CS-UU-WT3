Authors: Tijn Kersjes (3855473) and Jordi Vermeulen (3835634)

URL: https://students.science.uu.nl/~3835634/Practicum 3/

Tested on Firefox (28.0), Safari (??.?), Internet Explorer (11.0).

A list of user credentials can be found in users.txt.

Our website strictly adheres to the MVC pattern. The following is a list of all models, views and controllers we use.

MODELS
- brandmodel: the model for converting brand IDs to names
- configmodel: the model for handling the matching algorithm's configuration
- usermodel: the model for handling all user data

VIEWS
- configuration: the view for setting the matching algorithm's configuration
- deleteconfirm: the view for confirmation of the deletion of an account
- deleted: the view seen after deleting an account
- editprofile: the view seen when editing a profile
- formview: the view of a much-used form, used in editprofile, register and search
- home: the view for the home page
- json: the view for generating JSON in response to AJAX requests
- login: the view for the login page
- loginsuccess: the view seen after successfully logging in
- profile_details: the view for displaying a profile
- profile_list: the view for displaying a list of profile summaries
- register: the view for registering a new account
- registersuccess: the view seen after successfully registering a new account
- search: the view for searching through the user database
- uploadpicture: the view for changing the user's profile picture
- partials/footer: the view for the footer
- partials/header: the view for the header
- partials/paging.js: the view for the JavaScript code that handles the client-side page navigation
- partials/profile_cards: the view for showing a collection of 6 profile summaries
- partials/promo: the view for the promotional image shown to unregistered users

CONTROLLERS
- configuration: the controller for handling the matching algorithm's configuration
- deleteuser: the controller for deleting a user's account
- editpicture: the controller for changing a user's profile picture
- editprofile: the controller for changing a user's profile
- home: the controller for the home page
- login: the controller for handling login
- logout: the controller for handling logout
- profilesform: the controller for a much-used form, inherited by editprofile, search and register
- profiles: the controller for displaying a variety of profile listings
- redirect_404: the controller for redirecting 404's to the home page
- register: the controller for handling the registration of a new user
- search: the controller for handling searching


Our database contains four tables, with the following DDL statements:

CREATE TABLE users (
    userid   INTEGER         PRIMARY KEY AUTOINCREMENT,
    email    VARCHAR( 100 )  NOT NULL
                             UNIQUE,
    password VARCHAR( 255 )  NOT NULL,
    admin    BOOLEAN         NOT NULL
);

CREATE TABLE profiles (
    userid                 INTEGER         REFERENCES users ( userid ) ON DELETE CASCADE,
    firstname              VARCHAR( 50 )   NOT NULL,
    lastname               VARCHAR( 50 )   NOT NULL,
    nickname               VARCHAR( 25 )   NOT NULL
                                           UNIQUE,
    gender                 VARCHAR( 6 )    NOT NULL,
    dob                    DATE            NOT NULL,
    description            VARCHAR( 500 )  NOT NULL,
    gender_preference      VARCHAR( 5 )    NOT NULL,
    min_age                INTEGER         NOT NULL,
    max_age                INTEGER         NOT NULL,
    personality            CHAR( 15 )      NOT NULL,
    personality_preference CHAR( 15 )      NOT NULL,
    brands                 VARCHAR( 200 )  NOT NULL,
    likes                  TEXT
);

CREATE TABLE settings (
    name  VARCHAR( 10 )  PRIMARY KEY,
    value VARCHAR        NOT NULL
);

CREATE TABLE brands (
    brandid INTEGER        PRIMARY KEY AUTOINCREMENT,
    name    VARCHAR( 50 )  NOT NULL
                           UNIQUE
);

There is also a fifth table, which CI uses to store sessions.