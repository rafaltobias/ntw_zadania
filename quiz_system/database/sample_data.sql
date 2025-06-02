-- Sample data population script for quiz_system database
-- Run this after setting up the main database structure

USE quiz_system;

-- Clear existing sample data (keep default teacher)
DELETE FROM student_answers WHERE id > 0;
DELETE FROM test_results WHERE id > 0;
DELETE FROM test_assignments WHERE id > 0;
DELETE FROM test_questions WHERE id > 0;
DELETE FROM answers WHERE id > 0;
DELETE FROM questions WHERE id > 0;
DELETE FROM tests WHERE id > 0;
DELETE FROM student_class WHERE id > 0;
DELETE FROM classes WHERE id > 0;
DELETE FROM users WHERE id > 1;

-- Insert additional teachers (5 more)
INSERT INTO users (username, password, name, role, email) VALUES
('teacher2', '$2y$10$7rLSvRVyTQORapkDOqmkhetjF6H9lJHngr4hJMSM2lHObJbW5EQh6', 'Maria Kowalska', 'teacher', 'maria.kowalska@school.edu'),
('teacher3', '$2y$10$7rLSvRVyTQORapkDOqmkhetjF6H9lJHngr4hJMSM2lHObJbW5EQh6', 'Jan Nowak', 'teacher', 'jan.nowak@school.edu'),
('teacher4', '$2y$10$7rLSvRVyTQORapkDOqmkhetjF6H9lJHngr4hJMSM2lHObJbW5EQh6', 'Anna Wiśniewska', 'teacher', 'anna.wisniewska@school.edu'),
('teacher5', '$2y$10$7rLSvRVyTQORapkDOqmkhetjF6H9lJHngr4hJMSM2lHObJbW5EQh6', 'Piotr Lewandowski', 'teacher', 'piotr.lewandowski@school.edu'),
('teacher6', '$2y$10$7rLSvRVyTQORapkDOqmkhetjF6H9lJHngr4hJMSM2lHObJbW5EQh6', 'Katarzyna Zielińska', 'teacher', 'katarzyna.zielinska@school.edu');

-- Insert students (10)
INSERT INTO users (username, password, name, role, email) VALUES
('student1', '$2y$10$7rLSvRVyTQORapkDOqmkhetjF6H9lJHngr4hJMSM2lHObJbW5EQh6', 'Adam Kowalczyk', 'student', 'adam.kowalczyk@student.edu'),
('student2', '$2y$10$7rLSvRVyTQORapkDOqmkhetjF6H9lJHngr4hJMSM2lHObJbW5EQh6', 'Ewa Nowakowa', 'student', 'ewa.nowakowa@student.edu'),
('student3', '$2y$10$7rLSvRVyTQORapkDOqmkhetjF6H9lJHngr4hJMSM2lHObJbW5EQh6', 'Michał Wiśniewski', 'student', 'michal.wisniewski@student.edu'),
('student4', '$2y$10$7rLSvRVyTQORapkDOqmkhetjF6H9lJHngr4hJMSM2lHObJbW5EQh6', 'Agnieszka Lewandowska', 'student', 'agnieszka.lewandowska@student.edu'),
('student5', '$2y$10$7rLSvRVyTQORapkDOqmkhetjF6H9lJHngr4hJMSM2lHObJbW5EQh6', 'Tomasz Zieliński', 'student', 'tomasz.zielinski@student.edu'),
('student6', '$2y$10$7rLSvRVyTQORapkDOqmkhetjF6H9lJHngr4hJMSM2lHObJbW5EQh6', 'Magdalena Kamińska', 'student', 'magdalena.kaminska@student.edu'),
('student7', '$2y$10$7rLSvRVyTQORapkDOqmkhetjF6H9lJHngr4hJMSM2lHObJbW5EQh6', 'Łukasz Dąbrowski', 'student', 'lukasz.dabrowski@student.edu'),
('student8', '$2y$10$7rLSvRVyTQORapkDOqmkhetjF6H9lJHngr4hJMSM2lHObJbW5EQh6', 'Karolina Szymańska', 'student', 'karolina.szymanska@student.edu'),
('student9', '$2y$10$7rLSvRVyTQORapkDOqmkhetjF6H9lJHngr4hJMSM2lHObJbW5EQh6', 'Bartosz Kozłowski', 'student', 'bartosz.kozlowski@student.edu'),
('student10', '$2y$10$7rLSvRVyTQORapkDOqmkhetjF6H9lJHngr4hJMSM2lHObJbW5EQh6', 'Natalia Jankowska', 'student', 'natalia.jankowska@student.edu');

-- Insert classes (10)
INSERT INTO classes (name, description) VALUES
('Matematyka - Klasa 1A', 'Podstawy matematyki dla pierwszej klasy'),
('Historia - Klasa 2B', 'Historia Polski i świata'),
('Fizyka - Klasa 3C', 'Podstawy fizyki i mechaniki'),
('Chemia - Klasa 1B', 'Wprowadzenie do chemii'),
('Biologia - Klasa 2A', 'Biologia człowieka i przyrody'),
('Geografia - Klasa 3A', 'Geografia Polski i Europy'),
('Język Polski - Klasa 1C', 'Literatura i gramatyka'),
('Język Angielski - Klasa 2C', 'Konwersacje i gramatyka angielska'),
('Informatyka - Klasa 3B', 'Programowanie i algorytmy'),
('WOS - Klasa 1A', 'Wiedza o społeczeństwie');

-- Assign students to classes (each student to 2-3 classes)
INSERT INTO student_class (user_id, class_id) VALUES
-- student1 (ID: 7) - classes 1,2,3
(7, 1), (7, 2), (7, 3),
-- student2 (ID: 8) - classes 2,4,5
(8, 2), (8, 4), (8, 5),
-- student3 (ID: 9) - classes 1,3,6
(9, 1), (9, 3), (9, 6),
-- student4 (ID: 10) - classes 4,7,8
(10, 4), (10, 7), (10, 8),
-- student5 (ID: 11) - classes 5,9,10
(11, 5), (11, 9), (11, 10),
-- student6 (ID: 12) - classes 1,6,7
(12, 1), (12, 6), (12, 7),
-- student7 (ID: 13) - classes 2,8,9
(13, 2), (13, 8), (13, 9),
-- student8 (ID: 14) - classes 3,10,1
(14, 3), (14, 10), (14, 1),
-- student9 (ID: 15) - classes 4,5,6
(15, 4), (15, 5), (15, 6),
-- student10 (ID: 16) - classes 7,8,9
(16, 7), (16, 8), (16, 9);

-- Insert questions (10 per teacher = 60 total)
-- Teacher 1 questions
INSERT INTO questions (content, created_by) VALUES
('Która z poniższych liczb jest liczbą pierwszą? (Teacher 1, Q1)', 1),
('Ile wynosi suma kątów w trójkącie? (Teacher 1, Q2)', 1),
('Co to jest liczba Pi? (Teacher 1, Q3)', 1),
('Jaka jest wartość 2^3? (Teacher 1, Q4)', 1),
('Ile wynosi pierwiastek z 16? (Teacher 1, Q5)', 1),
('Co to jest procent? (Teacher 1, Q6)', 1),
('Jaka jest wartość |−5|? (Teacher 1, Q7)', 1),
('Ile wynosi 7 × 8? (Teacher 1, Q8)', 1),
('Co to jest średnia arytmetyczna? (Teacher 1, Q9)', 1),
('Jaka jest wartość sin(90°)? (Teacher 1, Q10)', 1);

-- Teacher 2 questions
INSERT INTO questions (content, created_by) VALUES
('Kto był pierwszym królem Polski? (Teacher 2, Q1)', 2),
('W którym roku rozpoczęła się II wojna światowa? (Teacher 2, Q2)', 2),
('Kiedy przyjęto Konstytucję 3 Maja? (Teacher 2, Q3)', 2),
('Kto napisał "Krzyżacy"? (Teacher 2, Q4)', 2),
('W którym roku upadł mur berliński? (Teacher 2, Q5)', 2),
('Która bitwa miała miejsce w 1410 roku? (Teacher 2, Q6)', 2),
('Kto był pierwszym prezydentem niepodległej Polski? (Teacher 2, Q7)', 2),
('W którym roku Polska wstąpiła do NATO? (Teacher 2, Q8)', 2),
('Co to było powstanie warszawskie? (Teacher 2, Q9)', 2),
('Kto był władcą w czasie rozbiorów Polski? (Teacher 2, Q10)', 2);

-- Teacher 3 questions
INSERT INTO questions (content, created_by) VALUES
('Jaka jest prędkość światła w próżni? (Teacher 3, Q1)', 3),
('Co to jest siła grawitacji? (Teacher 3, Q2)', 3),
('Jaka jest jednostka mocy? (Teacher 3, Q3)', 3),
('Co opisuje prawo Ohma? (Teacher 3, Q4)', 3),
('Ile wynosi przyspieszenie ziemskie? (Teacher 3, Q5)', 3),
('Co to jest energia kinetyczna? (Teacher 3, Q6)', 3),
('Jaka jest częstotliwość światła czerwonego? (Teacher 3, Q7)', 3),
('Co to jest przewodnictwo cieplne? (Teacher 3, Q8)', 3),
('Jaka jest trzecia zasada dynamiki Newtona? (Teacher 3, Q9)', 3),
('Co to jest pole magnetyczne? (Teacher 3, Q10)', 3);

-- Teacher 4 questions
INSERT INTO questions (content, created_by) VALUES
('Który pierwiastek ma symbol chemiczny O? (Teacher 4, Q1)', 4),
('Ile elektronów ma atom węgla? (Teacher 4, Q2)', 4),
('Co to jest kwas? (Teacher 4, Q3)', 4),
('Jaka jest masa atomowa wodoru? (Teacher 4, Q4)', 4),
('Co powstaje przy spalaniu metanu? (Teacher 4, Q5)', 4),
('Ile wiązań może tworzyć azot? (Teacher 4, Q6)', 4),
('Co to jest pH? (Teacher 4, Q7)', 4),
('Który gaz jest najliczniejszy w atmosferze? (Teacher 4, Q8)', 4),
('Co to jest kataliza? (Teacher 4, Q9)', 4),
('Jaka jest wzór wody? (Teacher 4, Q10)', 4);

-- Teacher 5 questions
INSERT INTO questions (content, created_by) VALUES
('Ile chromosomów ma człowiek? (Teacher 5, Q1)', 5),
('Co to jest fotosynteza? (Teacher 5, Q2)', 5),
('Gdzie znajduje się DNA w komórce? (Teacher 5, Q3)', 5),
('Co to jest mitoza? (Teacher 5, Q4)', 5),
('Która grupa krwi jest dawcą uniwersalnym? (Teacher 5, Q5)', 5),
('Co to jest hemoglobina? (Teacher 5, Q6)', 5),
('Ile kładek ciągnie się przez żyłę główną? (Teacher 5, Q7)', 5),
('Co to jest ekosystem? (Teacher 5, Q8)', 5),
('Gdzie produkowana jest insulina? (Teacher 5, Q9)', 5),
('Co to jest mutacja? (Teacher 5, Q10)', 5);

-- Teacher 6 questions
INSERT INTO questions (content, created_by) VALUES
('Która rzeka przepływa przez Warszawę? (Teacher 6, Q1)', 6),
('Jaka jest stolica Francji? (Teacher 6, Q2)', 6),
('Który kontynent jest największy? (Teacher 6, Q3)', 6),
('Co to są Kordyliery? (Teacher 6, Q4)', 6),
('Gdzie znajduje się Morze Martwe? (Teacher 6, Q5)', 6),
('Jaka jest najwyższa góra świata? (Teacher 6, Q6)', 6),
('Co to jest równik? (Teacher 6, Q7)', 6),
('Które państwo ma największą powierzchnię? (Teacher 6, Q8)', 6),
('Co to jest tsunami? (Teacher 6, Q9)', 6),
('Gdzie znajdują się Wielkie Jeziora? (Teacher 6, Q10)', 6);

-- Insert answers for all questions (4 answers each, 1 correct)
-- Teacher 1 questions answers
INSERT INTO answers (question_id, content, is_correct) VALUES
-- Q1: Która liczba jest pierwsza?
(1, 'A) 15', 0), (1, 'B) 17', 1), (1, 'C) 18', 0), (1, 'D) 20', 0),
-- Q2: Suma kątów w trójkącie
(2, 'A) 180°', 1), (2, 'B) 360°', 0), (2, 'C) 90°', 0), (2, 'D) 270°', 0),
-- Q3: Co to jest Pi?
(3, 'A) 3.14159...', 1), (3, 'B) 2.71828...', 0), (3, 'C) 1.41421...', 0), (3, 'D) 2.30258...', 0),
-- Q4: 2^3
(4, 'A) 6', 0), (4, 'B) 8', 1), (4, 'C) 9', 0), (4, 'D) 12', 0),
-- Q5: Pierwiastek z 16
(5, 'A) 4', 1), (5, 'B) 8', 0), (5, 'C) 2', 0), (5, 'D) 16', 0),
-- Q6: Co to jest procent?
(6, 'A) Jedna setna', 1), (6, 'B) Jedna dziesiąta', 0), (6, 'C) Jedna tysięczna', 0), (6, 'D) Jedna połowa', 0),
-- Q7: |−5|
(7, 'A) -5', 0), (7, 'B) 5', 1), (7, 'C) 0', 0), (7, 'D) 10', 0),
-- Q8: 7 × 8
(8, 'A) 54', 0), (8, 'B) 56', 1), (8, 'C) 64', 0), (8, 'D) 49', 0),
-- Q9: Średnia arytmetyczna
(9, 'A) Suma podzielona przez liczbę elementów', 1), (9, 'B) Największa wartość', 0), (9, 'C) Najmniejsza wartość', 0), (9, 'D) Różnica maksymalnej i minimalnej', 0),
-- Q10: sin(90°)
(10, 'A) 0', 0), (10, 'B) 1', 1), (10, 'C) -1', 0), (10, 'D) 0.5', 0);

-- Teacher 2 questions answers
INSERT INTO answers (question_id, content, is_correct) VALUES
-- Q11: Pierwszy król Polski
(11, 'A) Bolesław Chrobry', 1), (11, 'B) Mieszko I', 0), (11, 'C) Kazimierz Wielki', 0), (11, 'D) Władysław Jagiełło', 0),
-- Q12: Początek II wojny światowej
(12, 'A) 1938', 0), (12, 'B) 1939', 1), (12, 'C) 1940', 0), (12, 'D) 1941', 0),
-- Q13: Konstytucja 3 Maja
(13, 'A) 1791', 1), (13, 'B) 1795', 0), (13, 'C) 1807', 0), (13, 'D) 1815', 0),
-- Q14: Autor Krzyżaków
(14, 'A) Adam Mickiewicz', 0), (14, 'B) Henryk Sienkiewicz', 1), (14, 'C) Bolesław Prus', 0), (14, 'D) Juliusz Słowacki', 0),
-- Q15: Upadek muru berlińskiego
(15, 'A) 1987', 0), (15, 'B) 1989', 1), (15, 'C) 1991', 0), (15, 'D) 1993', 0),
-- Q16: Bitwa pod Grunwaldem
(16, 'A) Bitwa pod Grunwaldem', 1), (16, 'B) Bitwa pod Wiedniem', 0), (16, 'C) Bitwa pod Komarowem', 0), (16, 'D) Bitwa pod Kircholmem', 0),
-- Q17: Pierwszy prezydent Polski
(17, 'A) Gabriel Narutowicz', 1), (17, 'B) Józef Piłsudski', 0), (17, 'C) Stanisław Wojciechowski', 0), (17, 'D) Ignacy Mościcki', 0),
-- Q18: Wstąpienie do NATO
(18, 'A) 1997', 0), (18, 'B) 1999', 1), (18, 'C) 2001', 0), (18, 'D) 2004', 0),
-- Q19: Powstanie warszawskie
(19, 'A) Powstanie przeciwko okupacji niemieckiej', 1), (19, 'B) Powstanie przeciwko Rosjanom', 0), (19, 'C) Powstanie przeciwko Austriakom', 0), (19, 'D) Powstanie przeciwko Szwiedom', 0),
-- Q20: Władca podczas rozbiorów
(20, 'A) Katarzyna II', 1), (20, 'B) Piotr I', 0), (20, 'C) Aleksander I', 0), (20, 'D) Mikołaj I', 0);

-- Teacher 3 questions answers
INSERT INTO answers (question_id, content, is_correct) VALUES
-- Q21: Prędkość światła
(21, 'A) 300,000 km/s', 0), (21, 'B) 299,792,458 m/s', 1), (21, 'C) 150,000 km/s', 0), (21, 'D) 1,000,000 m/s', 0),
-- Q22: Siła grawitacji
(22, 'A) Siła przyciągania mas', 1), (22, 'B) Siła odpychania', 0), (22, 'C) Siła magnetyczna', 0), (22, 'D) Siła elektryczna', 0),
-- Q23: Jednostka mocy
(23, 'A) Wat', 1), (23, 'B) Dżul', 0), (23, 'C) Newton', 0), (23, 'D) Amper', 0),
-- Q24: Prawo Ohma
(24, 'A) U = I × R', 1), (24, 'B) F = m × a', 0), (24, 'C) E = m × c²', 0), (24, 'D) P = F × v', 0),
-- Q25: Przyspieszenie ziemskie
(25, 'A) 9.8 m/s²', 1), (25, 'B) 10 m/s²', 0), (25, 'C) 8.9 m/s²', 0), (25, 'D) 11 m/s²', 0),
-- Q26: Energia kinetyczna
(26, 'A) Energia ruchu', 1), (26, 'B) Energia położenia', 0), (26, 'C) Energia cieplna', 0), (26, 'D) Energia chemiczna', 0),
-- Q27: Częstotliwość światła czerwonego
(27, 'A) 400-500 THz', 1), (27, 'B) 500-600 THz', 0), (27, 'C) 600-700 THz', 0), (27, 'D) 700-800 THz', 0),
-- Q28: Przewodnictwo cieplne
(28, 'A) Przenoszenie ciepła', 1), (28, 'B) Przenoszenie elektryczności', 0), (28, 'C) Przenoszenie dźwięku', 0), (28, 'D) Przenoszenie światła', 0),
-- Q29: III zasada dynamiki
(29, 'A) Każde działanie wywołuje równe przeciwdziałanie', 1), (29, 'B) F = ma', 0), (29, 'C) Ciało porusza się jednostajnie', 0), (29, 'D) Wszystkie z powyższych', 0),
-- Q30: Pole magnetyczne
(30, 'A) Obszar działania sił magnetycznych', 1), (30, 'B) Obszar działania sił elektrycznych', 0), (30, 'C) Obszar działania sił grawitacyjnych', 0), (30, 'D) Obszar działania sił jądrowych', 0);

-- Teacher 4 questions answers
INSERT INTO answers (question_id, content, is_correct) VALUES
-- Q31: Symbol O
(31, 'A) Wodór', 0), (31, 'B) Tlen', 1), (31, 'C) Azot', 0), (31, 'D) Węgiel', 0),
-- Q32: Elektrony węgla
(32, 'A) 4', 0), (32, 'B) 6', 1), (32, 'C) 8', 0), (32, 'D) 12', 0),
-- Q33: Co to jest kwas
(33, 'A) Związek uwalniający protony', 1), (33, 'B) Związek uwalniający elektrony', 0), (33, 'C) Związek uwalniający neutrony', 0), (33, 'D) Związek obojętny', 0),
-- Q34: Masa atomowa wodoru
(34, 'A) 1', 1), (34, 'B) 2', 0), (34, 'C) 4', 0), (34, 'D) 8', 0),
-- Q35: Spalanie metanu
(35, 'A) CO₂ i H₂O', 1), (35, 'B) CO i H₂', 0), (35, 'C) O₂ i N₂', 0), (35, 'D) SO₂ i H₂S', 0),
-- Q36: Wiązania azotu
(36, 'A) 3', 1), (36, 'B) 2', 0), (36, 'C) 4', 0), (36, 'D) 5', 0),
-- Q37: Co to jest pH
(37, 'A) Miara kwasowości', 1), (37, 'B) Miara temperatury', 0), (37, 'C) Miara masy', 0), (37, 'D) Miara objętości', 0),
-- Q38: Najliczniejszy gaz w atmosferze
(38, 'A) Azot', 1), (38, 'B) Tlen', 0), (38, 'C) Argon', 0), (38, 'D) Dwutlenek węgla', 0),
-- Q39: Co to jest kataliza
(39, 'A) Przyspieszanie reakcji', 1), (39, 'B) Spowalnianie reakcji', 0), (39, 'C) Zatrzymywanie reakcji', 0), (39, 'D) Zmiana produktów', 0),
-- Q40: Wzór wody
(40, 'A) H₂O', 1), (40, 'B) H₂O₂', 0), (40, 'C) HO', 0), (40, 'D) H₃O', 0);

-- Teacher 5 questions answers
INSERT INTO answers (question_id, content, is_correct) VALUES
-- Q41: Chromosomy człowieka
(41, 'A) 44', 0), (41, 'B) 46', 1), (41, 'C) 48', 0), (41, 'D) 50', 0),
-- Q42: Fotosynteza
(42, 'A) Proces wytwarzania glukozy ze światła', 1), (42, 'B) Proces oddychania', 0), (42, 'C) Proces trawienia', 0), (42, 'D) Proces rozmnażania', 0),
-- Q43: DNA w komórce
(43, 'A) W jądrze', 1), (43, 'B) W cytoplazmie', 0), (43, 'C) W mitochondriach', 0), (43, 'D) W rybosomach', 0),
-- Q44: Mitoza
(44, 'A) Podział komórki', 1), (44, 'B) Śmierć komórki', 0), (44, 'C) Wzrost komórki', 0), (44, 'D) Ruch komórki', 0),
-- Q45: Dawca uniwersalny
(45, 'A) 0 Rh-', 1), (45, 'B) AB Rh+', 0), (45, 'C) A Rh+', 0), (45, 'D) B Rh-', 0),
-- Q46: Hemoglobina
(46, 'A) Białko przenoszące tlen', 1), (46, 'B) Hormon wzrostu', 0), (46, 'C) Enzym trawienny', 0), (46, 'D) Witamina', 0),
-- Q47: Żyła główna
(47, 'A) 2', 1), (47, 'B) 1', 0), (47, 'C) 3', 0), (47, 'D) 4', 0),
-- Q48: Ekosystem
(48, 'A) Zespół organizmów i środowiska', 1), (48, 'B) Tylko rośliny', 0), (48, 'C) Tylko zwierzęta', 0), (48, 'D) Tylko mikroorganizmy', 0),
-- Q49: Produkcja insuliny
(49, 'A) Trzustka', 1), (49, 'B) Wątroba', 0), (49, 'C) Nerki', 0), (49, 'D) Serce', 0),
-- Q50: Mutacja
(50, 'A) Zmiana w DNA', 1), (50, 'B) Nowa komórka', 0), (50, 'C) Nowy organizm', 0), (50, 'D) Nowy gatunek', 0);

-- Teacher 6 questions answers
INSERT INTO answers (question_id, content, is_correct) VALUES
-- Q51: Rzeka przez Warszawę
(51, 'A) Wisła', 1), (51, 'B) Odra', 0), (51, 'C) Bug', 0), (51, 'D) San', 0),
-- Q52: Stolica Francji
(52, 'A) Paryż', 1), (52, 'B) Lyon', 0), (52, 'C) Marsylia', 0), (52, 'D) Tuluza', 0),
-- Q53: Największy kontynent
(53, 'A) Azja', 1), (53, 'B) Afryka', 0), (53, 'C) Ameryka Północna', 0), (53, 'D) Europa', 0),
-- Q54: Kordyliery
(54, 'A) Pasmo górskie w Ameryce', 1), (54, 'B) Pustynia', 0), (54, 'C) Rzeka', 0), (54, 'D) Jezioro', 0),
-- Q55: Morze Martwe
(55, 'A) Izrael/Jordania', 1), (55, 'B) Egipt', 0), (55, 'C) Turcja', 0), (55, 'D) Grecja', 0),
-- Q56: Najwyższa góra
(56, 'A) Mount Everest', 1), (56, 'B) K2', 0), (56, 'C) Kilimandżaro', 0), (56, 'D) Mont Blanc', 0),
-- Q57: Równik
(57, 'A) Linia 0° szerokości geograficznej', 1), (57, 'B) Linia 0° długości geograficznej', 0), (57, 'C) Północny kraniec Ziemi', 0), (57, 'D) Południowy kraniec Ziemi', 0),
-- Q58: Największe państwo
(58, 'A) Rosja', 1), (58, 'B) Kanada', 0), (58, 'C) Chiny', 0), (58, 'D) USA', 0),
-- Q59: Tsunami
(59, 'A) Fala morska wywołana trzęsieniem ziemi', 1), (59, 'B) Wiatr monsunowy', 0), (59, 'C) Erupcja wulkanu', 0), (59, 'D) Burza piaskowa', 0),
-- Q60: Wielkie Jeziora
(60, 'A) Ameryka Północna', 1), (60, 'B) Ameryka Południowa', 0), (60, 'C) Europa', 0), (60, 'D) Azja', 0);

-- Create tests (2 per teacher = 12 total)
INSERT INTO tests (title, description, created_by) VALUES
('Test z Matematyki - Podstawy', 'Test sprawdzający podstawowe umiejętności matematyczne', 1),
('Test z Matematyki - Zaawansowany', 'Test z zaawansowanych zagadnień matematycznych', 1),
('Test z Historii Polski', 'Test z dziejów Polski do 1989 roku', 2),
('Test z Historii Powszechnej', 'Test z historii świata', 2),
('Test z Fizyki - Mechanika', 'Test z podstaw mechaniki klasycznej', 3),
('Test z Fizyki - Elektryczność', 'Test z elektryczności i magnetyzmu', 3),
('Test z Chemii - Podstawy', 'Test z podstaw chemii nieorganicznej', 4),
('Test z Chemii - Organiczna', 'Test z chemii organicznej', 4),
('Test z Biologii - Genetyka', 'Test z podstaw genetyki', 5),
('Test z Biologii - Anatomia', 'Test z anatomii człowieka', 5),
('Test z Geografii Polski', 'Test z geografii fizycznej Polski', 6),
('Test z Geografii Świata', 'Test z geografii kontynentów', 6);

-- Assign questions to tests (5 questions each)
INSERT INTO test_questions (test_id, question_id) VALUES
-- Test 1 (Math basics) - Teacher 1 questions 1-5
(1, 1), (1, 2), (1, 3), (1, 4), (1, 5),
-- Test 2 (Math advanced) - Teacher 1 questions 6-10
(2, 6), (2, 7), (2, 8), (2, 9), (2, 10),
-- Test 3 (Polish history) - Teacher 2 questions 11-15
(3, 11), (3, 12), (3, 13), (3, 14), (3, 15),
-- Test 4 (World history) - Teacher 2 questions 16-20
(4, 16), (4, 17), (4, 18), (4, 19), (4, 20),
-- Test 5 (Physics mechanics) - Teacher 3 questions 21-25
(5, 21), (5, 22), (5, 23), (5, 24), (5, 25),
-- Test 6 (Physics electricity) - Teacher 3 questions 26-30
(6, 26), (6, 27), (6, 28), (6, 29), (6, 30),
-- Test 7 (Chemistry basics) - Teacher 4 questions 31-35
(7, 31), (7, 32), (7, 33), (7, 34), (7, 35),
-- Test 8 (Organic chemistry) - Teacher 4 questions 36-40
(8, 36), (8, 37), (8, 38), (8, 39), (8, 40),
-- Test 9 (Biology genetics) - Teacher 5 questions 41-45
(9, 41), (9, 42), (9, 43), (9, 44), (9, 45),
-- Test 10 (Biology anatomy) - Teacher 5 questions 46-50
(10, 46), (10, 47), (10, 48), (10, 49), (10, 50),
-- Test 11 (Geography Poland) - Teacher 6 questions 51-55
(11, 51), (11, 52), (11, 53), (11, 54), (11, 55),
-- Test 12 (Geography World) - Teacher 6 questions 56-60
(12, 56), (12, 57), (12, 58), (12, 59), (12, 60);

-- Assign tests to classes
INSERT INTO test_assignments (test_id, class_id) VALUES
-- Math tests to math class
(1, 1), (2, 1),
-- History tests to history class  
(3, 2), (4, 2),
-- Physics tests to physics class
(5, 3), (6, 3),
-- Chemistry tests to chemistry class
(7, 4), (8, 4),
-- Biology tests to biology class
(9, 5), (10, 5),
-- Geography tests to geography class
(11, 6), (12, 6),
-- Cross assignments for variety
(1, 7), (3, 8), (5, 9), (7, 10);

-- Generate some test results (students who completed tests)
INSERT INTO test_results (user_id, test_id, score, completed_at) VALUES
-- Student 1 completed math test 1 (5 questions, scored 4)
(7, 1, 4, '2024-11-15 10:30:00'),
-- Student 1 completed history test 3 (5 questions, scored 3)
(7, 3, 3, '2024-11-20 14:15:00'),
-- Student 2 completed math test 1 (5 questions, scored 5)
(8, 1, 5, '2024-11-16 11:00:00'),
-- Student 2 completed biology test 9 (5 questions, scored 2)
(8, 9, 2, '2024-11-18 09:45:00'),
-- Student 3 completed physics test 5 (5 questions, scored 4)
(9, 5, 4, '2024-11-17 13:20:00'),
-- Student 3 completed math test 1 (5 questions, scored 3)
(9, 1, 3, '2024-11-19 15:30:00'),
-- Student 4 completed chemistry test 7 (5 questions, scored 5)
(10, 7, 5, '2024-11-21 10:15:00'),
-- Student 5 completed biology test 9 (5 questions, scored 4)
(11, 9, 4, '2024-11-22 12:00:00'),
-- Student 6 completed geography test 11 (5 questions, scored 3)
(12, 11, 3, '2024-11-23 14:30:00'),
-- Student 7 completed history test 3 (5 questions, scored 4)
(13, 3, 4, '2024-11-24 11:45:00');

-- Generate student answers for the test results
-- Result 1: Student 7, Test 1, Score 4/5
INSERT INTO student_answers (result_id, question_id, answer_id) VALUES
(1, 1, 2), -- Correct (17 is prime)
(1, 2, 1), -- Correct (180°)
(1, 3, 1), -- Correct (Pi)
(1, 4, 2), -- Correct (8)
(1, 5, 2); -- Wrong answer (student chose 8 instead of 4)

-- Result 2: Student 7, Test 3, Score 3/5  
INSERT INTO student_answers (result_id, question_id, answer_id) VALUES
(2, 11, 1), -- Correct (Bolesław Chrobry)
(2, 12, 2), -- Correct (1939)
(2, 13, 2), -- Wrong (chose 1795 instead of 1791)
(2, 14, 2), -- Correct (Henryk Sienkiewicz)
(2, 15, 3); -- Wrong (chose 1991 instead of 1989)

-- Result 3: Student 8, Test 1, Score 5/5
INSERT INTO student_answers (result_id, question_id, answer_id) VALUES
(3, 1, 2), -- Correct
(3, 2, 1), -- Correct  
(3, 3, 1), -- Correct
(3, 4, 2), -- Correct
(3, 5, 1); -- Correct

-- Result 4: Student 8, Test 9, Score 2/5
INSERT INTO student_answers (result_id, question_id, answer_id) VALUES
(4, 41, 2), -- Correct (46 chromosomes)
(4, 42, 1), -- Correct (photosynthesis)
(4, 43, 2), -- Wrong (chose cytoplasm instead of nucleus)
(4, 44, 2), -- Wrong (chose cell death instead of division)
(4, 45, 2); -- Wrong (chose AB Rh+ instead of 0 Rh-)

-- Result 5: Student 9, Test 5, Score 4/5
INSERT INTO student_answers (result_id, question_id, answer_id) VALUES
(5, 21, 2), -- Correct (light speed)
(5, 22, 1), -- Correct (gravity)
(5, 23, 1), -- Correct (Watt)
(5, 24, 1), -- Correct (Ohm's law)
(5, 25, 2); -- Wrong (chose 10 m/s² instead of 9.8)

-- Result 6: Student 9, Test 1, Score 3/5
INSERT INTO student_answers (result_id, question_id, answer_id) VALUES
(6, 1, 2), -- Correct
(6, 2, 2), -- Wrong (chose 360° instead of 180°)
(6, 3, 1), -- Correct
(6, 4, 2), -- Correct  
(6, 5, 3); -- Wrong (chose 2 instead of 4)

-- Result 7: Student 10, Test 7, Score 5/5
INSERT INTO student_answers (result_id, question_id, answer_id) VALUES
(7, 31, 2), -- Correct (Oxygen)
(7, 32, 2), -- Correct (6 electrons)
(7, 33, 1), -- Correct (acid definition)
(7, 34, 1), -- Correct (mass 1)
(7, 35, 1); -- Correct (CO₂ and H₂O)

-- Result 8: Student 11, Test 9, Score 4/5
INSERT INTO student_answers (result_id, question_id, answer_id) VALUES
(8, 41, 2), -- Correct
(8, 42, 1), -- Correct
(8, 43, 1), -- Correct
(8, 44, 1), -- Correct
(8, 45, 3); -- Wrong

-- Result 9: Student 12, Test 11, Score 3/5
INSERT INTO student_answers (result_id, question_id, answer_id) VALUES
(9, 51, 1), -- Correct (Wisła)
(9, 52, 2), -- Wrong (this is world geography in Poland test)
(9, 53, 1), -- Correct (Asia)
(9, 54, 1), -- Correct (Cordilleras)
(9, 55, 2); -- Wrong

-- Result 10: Student 13, Test 3, Score 4/5  
INSERT INTO student_answers (result_id, question_id, answer_id) VALUES
(10, 11, 1), -- Correct
(10, 12, 2), -- Correct
(10, 13, 1), -- Correct
(10, 14, 2), -- Correct
(10, 15, 1); -- Wrong

-- Summary
SELECT 'Data population completed!' as Status;
SELECT 
    'Users' as Table_Name, COUNT(*) as Record_Count FROM users
UNION ALL SELECT 'Classes', COUNT(*) FROM classes  
UNION ALL SELECT 'Questions', COUNT(*) FROM questions
UNION ALL SELECT 'Answers', COUNT(*) FROM answers
UNION ALL SELECT 'Tests', COUNT(*) FROM tests
UNION ALL SELECT 'Test_Questions', COUNT(*) FROM test_questions
UNION ALL SELECT 'Test_Assignments', COUNT(*) FROM test_assignments
UNION ALL SELECT 'Student_Class', COUNT(*) FROM student_class
UNION ALL SELECT 'Test_Results', COUNT(*) FROM test_results
UNION ALL SELECT 'Student_Answers', COUNT(*) FROM student_answers;
