
CREATE TABLE Breed (
	BreedID		INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	FurType		VARCHAR(16),
	BreedName 	VARCHAR(32),
	PRIMARY KEY (BreedID)
);
INSERT INTO Breed (FurType, BreedName) VALUES ("Fur", "Golden Retriever");
INSERT INTO Breed (FurType, BreedName) VALUES ("Hair", "Morkie Poo");
INSERT INTO Breed (FurType, BreedName) VALUES ("Hair", "Sheepadoodle");

CREATE TABLE CriminalRecord (
	CriminalRecordID	INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	CriminalRecordName	VARCHAR(64),
	PRIMARY KEY (CriminalRecordID)
);
INSERT INTO CriminalRecord (CriminalRecordName) VALUES ("Charged With Animal Abuse on December 7th");
INSERT INTO CriminalRecord (CriminalRecordName) VALUES ("NO PRIOR RECORD");
INSERT INTO CriminalRecord (CriminalRecordName) VALUES ("NO PRIOR RECORD");

CREATE TABLE PastHistory (
	HistoryID			INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	PastOrganization	VARCHAR(128),
	PastOwner 			VARCHAR(64),
	PRIMARY KEY (HistoryID)
);

INSERT INTO PastHistory (PastOrganization, PastOwner) VALUES ("San Jose Medical Center", "James Patterson");
INSERT INTO PastHistory (PastOrganization, PastOwner) VALUES ("FIRST TIME IN ADOPTION SYSTEM", "NONE");
INSERT INTO PastHistory (PastOrganization, PastOwner) VALUES ("San Diego PetSmart Center", "Key Anu Reeves");


CREATE TABLE Vaccination (
	VaccinationID		INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	MedicalHistoryID 	INTEGER,
	VaccinationName		VARCHAR(256),
	PRIMARY KEY (VaccinationID),
	FOREIGN KEY (MedicalHistoryID) REFERENCES MedicalHistory(MedicalHistoryID)
);

INSERT INTO Vaccination (MedicalHistoryID, VaccinationName) VALUES (1, "Influenza on 03/04/2020");
INSERT INTO Vaccination (MedicalHistoryID, VaccinationName) VALUES (2, "WormBeGone on 07/09/2016");
INSERT INTO Vaccination (MedicalHistoryID, VaccinationName) VALUES (2, "Influenza on 07/09/2016");
INSERT INTO Vaccination (MedicalHistoryID, VaccinationName) VALUES (3, "None");

CREATE TABLE Ailment (
	AilmentID	INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	AilmentName	VARCHAR(128),
	MedicalHistoryID INTEGER,
	PRIMARY KEY (AilmentID),
	FOREIGN KEY (MedicalHistoryID) REFERENCES MedicalHistory(MedicalHistoryID)
);
INSERT INTO Ailment (AilmentName, MedicalHistoryID) VALUES ("Dog Flu", 1);
INSERT INTO Ailment (AilmentName, MedicalHistoryID) VALUES ("TapeWorm", 2);
INSERT INTO Ailment (AilmentName, MedicalHistoryID) VALUES ("NONE", 3);

CREATE TABLE MedicalHistory (
	MedicalHistoryID	INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
    AilmentID 			INTEGER,
	NeuteredStatus		VARCHAR(16),
	PRIMARY KEY (MedicalHistoryID)
);
INSERT INTO MedicalHistory (AilmentID, NeuteredStatus) VALUES ("Neutered");
INSERT INTO MedicalHistory (AilmentID, NeuteredStatus) VALUES ("Spayed");
INSERT INTO MedicalHistory (AilmentID, NeuteredStatus) VALUES ("Neutered");

CREATE TABLE CustomerInterests (
	InterestID		INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
    BreedID 		INTEGER,
	TimeCommitment	VARCHAR(256),
	PRIMARY KEY (InterestID),
	FOREIGN KEY (BreedID) REFERENCES Breed(BreedID)
);

INSERT INTO CustomerInterests (BreedID, TimeCommitment) VALUES (1, "Not That Much Time");
INSERT INTO CustomerInterests (BreedID, TimeCommitment) VALUES (2, "I have a job but right now it is work at home. I would say 17 hours a day.");
INSERT INTO CustomerInterests (BreedID, TimeCommitment) VALUES (3, "24/7 but on occasion both me and my wife will leave the house");

CREATE TABLE CustomerBackground (
	BackgroundID	INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
    CriminalRecordID INTEGER,
	Salary			DECIMAL,
	NumPeopleHousehold INTEGER,
	NumKids 		INTEGER,
	NumCurrPets		INTEGER,
	BUDGET			DECIMAL,
	PRIMARY KEY (BackgroundID),
	FOREIGN KEY (CriminalRecordID) REFERENCES CriminalRecord(CriminalRecordID)

);
INSERT INTO CustomerBackground (CriminalRecordID, Salary, NumPeopleHousehold, NumKids, NumCurrPets, BUDGET) VALUES (1, 0.0, 1, 0, 10, 20.0);
INSERT INTO CustomerBackground (CriminalRecordID, Salary, NumPeopleHousehold, NumKids, NumCurrPets, BUDGET) VALUES (2, 67000.50, 4, 6, 2, 150.0);
INSERT INTO CustomerBackground (CriminalRecordID, Salary, NumPeopleHousehold, NumKids, NumCurrPets, BUDGET) VALUES (3, 200000.00, 3, 1, 0, 600.0);

CREATE TABLE Address (
	AddressID	INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
    Street 		VARCHAR(128),
	City		VARCHAR(32),
	State		VARCHAR(16),
	Country 	VARCHAR(64),
	ZipCode		INTEGER,
	PRIMARY KEY (AddressID)
);
INSERT INTO Address (Street, City, State, Country, ZipCode) VALUES ("17 East San Carlos Street", "San Jose", "CA", "United States", 95122);
INSERT INTO Address (Street, City, State, Country, ZipCode) VALUES ("180 Chester Road", "Los Angeles", "CA", "United States", 90005);
INSERT INTO Address (Street, City, State, Country, ZipCode) VALUES ("811 Rich Road", "Beverly Hills", "CA", "United States", 18000);

CREATE TABLE Customer (
	CustomerID	INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
    AddressID 	INTEGER,
    BackgroundID INTEGER,
    InterestID 	INTEGER,
	Username 	VARCHAR(64),
    Password 	VARCHAR(64),
	FirstName	VARCHAR(32),
	LastName 	VARCHAR(32),
	Age			INTEGER,
	Email		VARCHAR(64),
	PhoneNumber	VARCHAR(32),
	PRIMARY KEY (CustomerID),
	FOREIGN KEY (AddressID) REFERENCES Address(AddressID),
	FOREIGN KEY (BackgroundID) REFERENCES CustomerBackground(BackgroundID),
	FOREIGN KEY (InterestID) REFERENCES CustomerInterests(InterestID)
);

INSERT INTO Customer (AddressID, BackgroundID, InterestID, Username, Password, FirstName, LastName, Age, Email, PhoneNumber) VALUES (1, 1, 1, "CrazyCat11", "HatePetsLol01", "Conrad", "Victo", 37, "ConVicto@gmail.com", "551-578-1100");
INSERT INTO Customer (AddressID, BackgroundID, InterestID, Username, Password, FirstName, LastName, Age, Email, PhoneNumber) VALUES (2, 2, 2, "DanaPeters", "ImSoExcited00", "Dana", "Peters", 50, "ILoveDogs@gmail.com", "525-908-2910");
INSERT INTO Customer (AddressID, BackgroundID, InterestID, Username, Password, FirstName, LastName, Age, Email, PhoneNumber) VALUES (3, 3, 3, "GetItJeff", "JeffSretam1", "Jeffrey", "Masters", 37, "JeffMasters@yahoo.com", "201-934-9483");


CREATE TABLE Dog (
	DogID		INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
    BreedID 	INTEGER,
    HistoryID 	INTEGER,
    MedicalHistoryID INTEGER,
	Name		VARCHAR(32),
	Image 		BLOB,
	Personality	VARCHAR(64),
	Color		VARCHAR(32),
	Weight		DECIMAL,
	DateArrived	DATE,
	DateLeft	VARCHAR(128),
	Owner		VARCHAR(64),
	AssignedVet	VARCHAR(64),
	Age			INTEGER,
	Trained		VARCHAR(32),
	Sex			VARCHAR(16),
	PRIMARY KEY (DogID),
	FOREIGN KEY (BreedID) REFERENCES Breed(BreedID),
	FOREIGN KEY (HistoryID) REFERENCES PastHistory(HistoryID),
	FOREIGN KEY (MedicalHistoryID) REFERENCES MedicalHistory(MedicalHistoryID)
);
INSERT INTO Dog (BreedID, HistoryID, MedicalHistoryID, Name, Personality, Color, Weight, DateArrived, DateLeft, Owner, AssignedVet, Age, Trained, Sex) VALUES (1, 1, 1, "Daisy", "Very polite and kind", "Brown/Blonde", 36.7, "2020-10-21", "2020-11-17", "Angeline Lee", "Dr. Matthew Klein", 12, "Trained in disability assistance", "Female");
INSERT INTO Dog (BreedID, HistoryID, MedicalHistoryID, Name, Personality, Color, Weight, DateArrived, DateLeft, Owner, AssignedVet, Age, Trained, Sex) VALUES (2, 2, 2, "Scout", "Likes to bite as a show of love", "Pale White/Blonde", 25.5, "2019-11-02", "Has not been adopted", "Helping Paws", "Dr. Katie Veters", 10, "None", "Female");
INSERT INTO Dog (BreedID, HistoryID, MedicalHistoryID, Name, Personality, Color, Weight, DateArrived, DateLeft, Owner, AssignedVet, Age, Trained, Sex) VALUES (3, 3, 3, "Teddy", "Very timid but likes to bark a lot", "White ", 13.6, "2007-02-16", "2007-02-17", "Kramer Krimson", "Dr. Ronaldo Craster", 7, "Potty-Trained", "Male");

CREATE TABLE Employment (
	EmploymentID 		INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	Occupation	  		VARCHAR(64),
	Pay 		  		DECIMAL,
	TimeWorking	  		INTEGER,
	EmploymentStatus  	VARCHAR(32),
    PRIMARY KEY (EmploymentID)
);
INSERT INTO Employment (Occupation, Pay, TimeWorking, EmploymentStatus) VALUES ("Manager", 30.00, 500, "Employed");
INSERT INTO Employment (Occupation, Pay, TimeWorking, EmploymentStatus) VALUES ("Veterinarian", 50.00, 800, "Employed");
INSERT INTO Employment (Occupation, Pay, TimeWorking, EmploymentStatus) VALUES ("Cashier", 17.0, 20, "Employed");

CREATE TABLE Employees (
	EmployeeID	INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
    EmploymentID INTEGER,
	FirstName	VARCHAR(32),
	LastName 	VARCHAR(32),
    Username VARCHAR(64),
    Password VARCHAR(64),
	Age		INTEGER,
	PhoneNumber	VARCHAR(32),
	EmailAddress	VARCHAR(64),
	PRIMARY KEY (EmployeeID),
	FOREIGN KEY (EmploymentID) REFERENCES Employment(EmploymentID)

);

INSERT INTO Employees (EmploymentID, FirstName, LastName, Username, Password, Age, PhoneNumber, EmailAddress) VALUES (1, "Angeline", "Lee", "Angeline5Foot7", "IAmActually5Foot3", 21, "220-304-3840", "angeline.lee@yahoo.com");
INSERT INTO Employees (EmploymentID, FirstName, LastName, Username, Password, Age, PhoneNumber, EmailAddress) VALUES (2, "Risha", "Ray", "DocRay", "IAmBestVet1010", 37, "220-102-3340", "doctor.risharay@gmail.com");
INSERT INTO Employees (EmploymentID, FirstName, LastName, Username, Password, Age, PhoneNumber, EmailAddress) VALUES (3, "Chris", "Tom", "SomeInternChris", "WishIWorkedAtCostco1", 18, "220-306-3800", "chris.tom@comcast.net");




	