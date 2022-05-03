# Requêtes SQL pour le projet

## Requêtes pour les pages

Récupérer tous les films.

```sql
SELECT * FROM `movie`
```

Récupérer les acteurs et leur(s) rôle(s) pour un film donné.

```sql
SELECT *
FROM`casting`
INNER JOIN `person` ON `casting`.`person_id` = `person`.`id`
where `movie_id` = {id_movie}
```

Récupérer les genres associés à un film donné.

```sql
SELECT *
FROM `genre`
INNER JOIN `movie_genre`
ON `genre`.`id` = `movie_genre`.`genre_id`
WHERE `movie_id`= {id}
```

Récupérer les saisons associées à un film/série donné.

```sql
SELECT * FROM `season` WHERE `movie_id` = {id_movie}
```

Récupérer les critiques pour un film donné.

```sql
SELECT * FROM `review` WHERE `movie_id` = {id_movie}
```

Récupérer les critiques pour un film donné, ainsi que le nom de l'utilisateur associé.

```sql
SELECT * FROM `review` INNER JOIN `user` ON `review`.`user_id` = `user`.`id` WHERE `movie_id` = {$id}
```

Calculer, pour chaque film, la moyenne des critiques par film (en une seule requête).

```sql
SELECT `movie_id`,AVG(`rating`) FROM `review` GROUP BY  `movie_id`
```

Idem pour un film donné.

```sql
SELECT AVG(`rating`) FROM `review` WHERE `movie_id` = {$id}
```

## Requêtes de recherche

Récupérer tous les films pour une année de sortie donnée.

```sql
select *
from `movie`
where year(`release_date`) =1978
```

Récupérer tous les films dont le titre est fourni (titre complet).

```sql
SELECT * FROM `movie` WHERE `title` = 'Epic Movie'
```

Récupérer tous les films dont le titre contient une chaîne donnée.

```sql
SELECT * FROM `movie` WHERE `title` LIKE '%love%'
```

## Bonus : Pagination

Nombre de films par page : 10 (par ex.)

```sql
SELECT * FROM `movie` LIMIT 10
```

Récupérer la liste des films de la page 2 (grâce à LIMIT).
Testez la requête en faisant varier le nombre de films par page et le numéro de page.

```sql
SELECT * FROM `movie` LIMIT 10 OFFSET 10
```
