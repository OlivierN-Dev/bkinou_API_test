# Bookinou API

Debut projet : 27/06/26 - 23h34
Pause : 1h45
Reprise : 28/06/26 - 14h00
Fin : 15h26
Temps total : 3h37


## Lancer le projet

Copier le fichier d'environnement exemple et le remplir avec vos informations avant toute chose.

```bash
cp .env.exemple .env
```

Installer les dependances, créer la base de données, jouer les migrations, puis démarrer le serveur.

```bash
composer install
php app/console doctrine:database:create
php bin/console make:migration
symfony serve
```

## Exemples d'URL

```http
GET  http://127.0.0.1:8000/story
GET  http://localhost:3000/recordings
GET  http://localhost:3000/api/stories/{id}
POST http://localhost:3000/api/story
POST http://localhost:3000/api/recordings
```

## Bonus non implémentés

Je n'ai pas eu le temps de faire les bonus, donc je pense les faires dans une branch nommé `feature/bonus`.

### 1. Filtre de recherche sur Story par titre

J'aurais utilisé `SearchFilter` 

```php
#[ApiFilter(SearchFilter::class, properties: ['title' => 'partial'])]
```

### 2. Test PHPUnit sur la génération de audioKey

vérifié qu'un `audioKey` est bien généré et non null lors de la création d'un enregistrement.

### 3. Validation des champs narrator et ean

```php
#[Assert\NotBlank]
#[Assert\Length(exactly: 13, exactMessage: "L'EAN doit contenir exactement 13 caractères.")]
```

### 4. Trait Timestampable pour mutualiser createdAt

Extraction de `createdAt` dans un trait partagé entre entités, en utilisant `#[ORM\Column(type: 'datetime_immutable')]`.

```php
#[ORM\Column(type: 'datetime_immutable')]
private ?\DateTimeImmutable $createdAt = null;
```


## Les problèmes que j'ai rencontré 

Je n’avais jamais vraiment fait d’API sur Symfony donc j’ai pris environ 30 minutes à 1 heure pour m’y habituer.
Au début, j’avais mal compris une consigne donc j’avais commencé quelque chose qui m’a fait perdre environ 30 minutes. J’avais mis tout mon code dans le contrôleur puis j’ai tout transféré dans un fichier service afin que le contrôleur soit plus léger et appelle simplement le service.

J’ai aussi eu des difficultés avec le système de ManyToOne. Quand je récupérais getRecordings ou getStories ça me renvoyait une collection et je ne comprenais pas pourquoi je n’arrivais pas à faire ->getId() etc. Alors qu’en réalité il suffisait de faire toArray().