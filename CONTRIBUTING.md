# Comment contribuer

## Installation

### Windows

1. Installer Chocolatey

    https://chocolatey.org/install

2. Installer les package managers avec Chocolatey dans Powershell en mode Admin

    `choco install composer nodejs`

3. Installer les dépendences node et php

    1. Se déplacer dans le dossier du projet

    2. Installer les dépendances

        `npm install`

        `composer install`

4. Installer PHPunit en suivant les instructions suivantes :

    [Site de PHPunit](https://phpunit.de/manual/6.5/en/installation.html#installation.phar.windows)

5. Héberger le site avec le built-in web server de php

    Dans le cmd, dans le dossier du projet,

    `php -S localhost:3030 -t public/`

    Par la suite, vous pourrez accéder au site en visitant localhost:3030

    Pour héberger le serveur de façon à y accéder de l'application mobile, utilisez plutôt l'adresse IP de votre ordinateur.

    `php -S 192.168.x.x:3030 -t public/`

    [Solution sur stack overflow](https://stackoverflow.com/questions/42323120/why-my-stringrequest-is-going-always-at-onerrorresponse-method)

6. Executer les tests

    1. Tests unitaires

        Dans le dossier du projet, entrer

        `phpunit tests`

    2. Tests d'implémentations avec Cypress

        Pendant que le site est hébergé, entrer

        `npm run cy:run`

## Prérequis

### Git

Git est l'outil principal que nous utilisons pour travailler sur le
même code source en parallèle et mettre en commun ce code.

Avant de commencer à programmer, il est important de s'assurer d'être
sur une machine ayant Git et ses outils en console d'installés.

Vous pouvez installer Git ici: https://git-scm.com/downloads

ou avec la commande `sudo apt-get install git` sur Linux.

### Editorconfig

Editorconfig est un outil permettant de règler automatiquement nos éditeurs
de texte afin qu'ils créent des caractères invisbles et spéciaux avec le
même style (par exemple: les tabs, les espaces, les retours de lignes,
les caractères unicode, etc.).

Il est important d'avoir un style constant à travers notre code afin
que notre code soit toujours facile à lire et qu'aucun commit ne serve
qu'à changer le style ou ne change accidentellement le style.

Il est également important que l'éditeur texte que vous utilisez
ait un plugin qui offre du support pour les fichiers `.editorconfig`
d'installé (si nécessaire).

Vous pouvez l'installer en suivant les instructions ci-dessous ou en
suivant les instructions ici: https://editorconfig.org/#download

#### Installation du plugin Editorconfig sur Atom

https://github.com/sindresorhus/atom-editorconfig

`$ apm install editorconfig`

ou

Settings -> Install -> Rechercher `editorconfig`

#### Installation du plugin Editorconfig sur Visual Studio Code

https://github.com/editorconfig/editorconfig-vscode

`$ ext install Editorconfig`


## Usage de Git

### Procédures pour écrire du code (En 10 étapes faciles)

1. Créer sa branche localement
2. Écrire des tests unitaires pour son code
3. Écrire son code en respectant les règles de style
4. Écrire des tests d'intégration si la fonctionnalité est complète
5. Créer son commit
6. Envoyer son commit sur sa branche en remote
7. Aller sur [GitHub](https://github.com/Hyftar/CircuitVoyages) et
   créer une pull request qui explique bien la fonctionnalité
8. S'assurer que les changements apportés ne changent pas le résultat
   des tests dans le *CI*
9. Demander à un autre membre de l'équipe de réviser les changements
   apportés
10. *Merger* la PR

### Règles pour les commits

1. Écrire au **présent** (exemple: `Add README.md`);
2. Utiliser un maximum de 72 caractères;
3. Écrire en **anglais** seulement;
4. Faire plusieur petits commits est préférable à en faire un seul gros;
5. Chaque commit doit être une version fonctionnelle du code.

### Commandes (Cheat sheet)

#### Gestion des commits

##### Regarder le status du repository

`git status`

- Cette commande devrait être exécutée très souvent pour être
  certain de ne pas faire d'erreurs en créant ses commits

##### Ajouter les fichier modifiés au *staging area*

`git add [fichiers] [-ip]`

- Ajouter `-ip` si vous voulez le faire en «mode intéractif»
- Utiliser `git add .` pour ajouter tout les fichiers
- Utiliser `git add . -ip` pour ajouter tout les changement en mode
  intéractif

##### Créer un commit

`git commit -m "[message]"`

- Suivre les règles de style (ci-dessus)
- Jamais créer de commit directement sur la branche `master`

##### Modifier un commit déjà créé

`git add [fichiers]`

`git commit --amend`

`git push origin [nom de la branche] -f` (si un push avait déjà été fait)

- Ceci devrait être utilisé avec parcimonie car cela écrase le code du
  côté du serveur
- Il s'agit parcontre de la façon préférée de modifier son code lorsque des
  changements sont demandés dans un pull request car il faut éviter de créer
  des nouveaux commits inutilement

##### Envoyer ses commits sur *GitHub*

`git push origin [nom de la branche]`

- Jamais *push* sur la branche *master* (Cela va être bloqué)

##### Observer un commit

`git checkout [hash du commit]`

##### Regarder l'historique des commits

`git log [--oneline] [--graph]`

- Les deux options spécifiées ci-dessus sont recommendées pour faciliter la
lecture

#### Gestion des branches

##### Créer une nouvelle branche

`git checkout -b [nom de la branche]`

- Exemple de noms de branches:
  - `hyftar-dev`
  - `nicholas-dev`
  - `new-shiny-feature`
  - `login`
  - `search-bar`

- Toujours changer de branche avant de commencer à écrire son code

##### Changer de branche

`git checkout [nom de la branche]`

- Si la branche n'apparait pas, vous pouvez utiliser
`git fetch origin [nom de la branche]` s'il s'agit d'une branche *remote*

##### Supprimer une branche

`git branch -d [nom de la branche]`

## Règles de style pour PHP

Se référer aux documents suivants pour les règles de style en PHP:

- [PSR-1](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md)
- [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md)

## Règles de style pour HTML / CSS

Se référer aux documents suivants pour les règles de style en HTML / CSS:

- [Google HTML/CSS Style Guide](https://google.github.io/styleguide/htmlcssguide.html)
- [Airbnb CSS/Sass Style Guide](https://github.com/airbnb/css/blob/master/README.md)

Autres points importants:

- Utiliser la [palette de couleur](https://slack-files.com/TNLKMV8CB-FPTSZ9Y72-7cf1fd835d)
  afin de guider son choix de couleurs
- Préférer les mesures relatives (%, fr, vh, vw) qu'aux mesures absolues
  (px, cm, em, rm) lorsque ceux-ci s'y prêtent

## Règles de style pour JS

Se référer au document suivant pour les règles de style en JS:

- [Airbnb JavaScript Style Guide](https://github.com/airbnb/javascript/blob/master/README.md)
