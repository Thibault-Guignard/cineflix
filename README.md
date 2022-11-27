# Cinéflix

## Installation du projet

### Installation des dépendances

```bash
composer install
```

### Base de données et fixture (optionnel)

Création de la base de données

```bash
bin/console doctrine:database:create
```

Création des migrations de nos entités

```bash
bin/console make:migration
```

Mise a jour de la base de données avec nos migrations

```bash
bin/console doctrine:migration:migrate
```

Lancement des fixtures (optionnel)

```bash
bin/console doctrine:fixtures:load
```

BONUS : commande personnalisée pour mettre à jours les affiches de film

```bash
bin/console app:movies:getposter
```
