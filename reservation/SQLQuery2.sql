CREATE TABLE RESERVATION (
    fname VARCHAR(255) NOT NULL ,
    sex VARCHAR(10) NOT NULL,
    phonenumber VARCHAR(15) NOT NULL,
    email VARCHAR(255) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    location VARCHAR(255) NOT NULL,
    time TIME NOT NULL,
    date DATE NOT NULL,
	PRIMARY KEY (fname,date, time)
);