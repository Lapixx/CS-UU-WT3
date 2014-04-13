Authors: Tijn Kersjes (3855473) and Jordi Vermeulen (3835634)

URL: https://students.science.uu.nl/~3835634/Practicum 3/

Tested on Firefox, Safari, Chrome, Opera.

Our website strictly adheres to the MVC pattern. A large part of the form used for profile-related pages is reused in the 'formprofile' controller and 'profileview' view.

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