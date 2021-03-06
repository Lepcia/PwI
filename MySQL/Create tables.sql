CREATE TABLE users(
    id_user INT UNSIGNED AUTO_INCREMENT,
    login VARCHAR(50) NOT NULL,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    email VARCHAR(50),
    password CHAR(255) NOT NULL,
    PRIMARY KEY (id_user)
)

/* CREATE TABLE colors(
    id_color INT UNSIGNED AUTO_INCREMENT,
    color_hex VARCHAR(7),
    description VARCHAR(50),
    PRIMARY KEY (id_color)
) */

CREATE TABLE events(
	id_event INT(10) UNSIGNED AUTO_INCREMENT,
    id_organizer INT UNSIGNED,
    name VARCHAR(100) NOT NULL,
    date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    place VARCHAR(200),
    description VARCHAR(250),
    color_hex VARCHAR(7),
    PRIMARY KEY (id_event),
    FOREIGN KEY (id_organizer) REFERENCES users(id_user)
)

CREATE TABLE users_to_events(
    id_user int UNSIGNED,
    id_event int UNSIGNED,
    PRIMARY KEY (id_user, id_event),
    FOREIGN KEY (id_user) REFERENCES users(id_user),
    FOREIGN KEY (id_event) REFERENCES events(id_event)
)

CREATE TABLE friends(
    id_user INT UNSIGNED,
    id_friend INT UNSIGNED,
    PRIMARY KEY (id_user, id_friend),
    FOREIGN KEY (id_user) REFERENCES users(id_user),
    FOREIGN KEY (id_friend) REFERENCES users(id_user)
)