//SAJAT letszam
SELECT  terulet.t_elnevezes, COUNT(dolgozok.d_id) AS db
FROM terulet 
LEFT OUTER JOIN dolgozok ON dolgozok.t_id = terulet.t_id 
WHERE dolgozok.a_id = 1 AND dolgozok.a_id = 3
GROUP BY terulet.t_elnevezes

//Kolcsonzott létszám 
SELECT  terulet.t_elnevezes, COUNT(dolgozok.d_id) AS db
FROM terulet 
LEFT OUTER JOIN dolgozok ON dolgozok.t_id = terulet.t_id 
WHERE dolgozok.a_id = 4
GROUP BY terulet.t_elnevezes


//Összes létszám
SELECT  terulet.t_elnevezes, COUNT(dolgozok.d_id) AS db
FROM terulet 
LEFT OUTER JOIN dolgozok ON dolgozok.t_id = terulet.t_id 
GROUP BY terulet.t_elnevezes

//Saját bejövő létszám 
SELECT  terulet.t_elnevezes, COUNT(dolgozok.d_id) AS db
FROM terulet 
LEFT OUTER JOIN dolgozok ON dolgozok.t_id = terulet.t_id 
WHERE dolgozo.a_id = 5
GROUP BY terulet.t_elnevezes

//Kölcsönzött bejövő létszám
SELECT  terulet.t_elnevezes, COUNT(dolgozok.d_id) AS db
FROM terulet 
LEFT OUTER JOIN dolgozok ON dolgozok.t_id = terulet.t_id 
WHERE dolgozo.a_id = 6 
GROUP BY terulet.t_elnevezes

//Összes Bejövő létszám
SELECT  terulet.t_elnevezes, COUNT(dolgozok.d_id) AS db
FROM terulet 
LEFT OUTER JOIN dolgozok ON dolgozok.t_id = terulet.t_id 
WHERE dolgozo.a_id = 6 AND dolgozo.a_id = 5
GROUP BY terulet.t_elnevezes

//Összes Igény



