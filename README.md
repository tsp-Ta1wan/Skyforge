**Bonjour! Ici tu trouveras tous les données nécéssaires pour l'évaluation de mon projet Skyforge.**

## Informations générales
**Etudiant**: Louay Belkhamsa

**Nom du projet**: Skyforge

**Thème**: Site pour la création de collections de pièces militaires (épées, arcs, armures, pistolets, etc...)

## Avancement:
Toutes les étapes du checklist sont normalement réalisée.
Vous pouvez consulter ce lien pour le [TODO.md](https://github.com/tsp-Ta1wan/Skyforge/blob/dev/TODO.md) 

## Erreurs/fonctionnalités manquantes:
Tous les fonctionnalités codées se compilent et marchent correctement sur mon environnement. 

## Nomenclature:
Inventaire = arsenal 

Objet = piece

## Mise en marche:
Après avoir téléchargé et extrait le rendu-CSC4101.zip suivez ces étapes en cas de besoin:
1.  Ouvrez le terminal et lancez ces commandes:
**Pour Linux/WSL Ubuntu**:
```
cd rendu-CSC4101/skyforge
rm -fr composer.lock symfony.lock vendor/ var/cache/
symfony composer install
symfony server:start
```
**Pour Windows**:
```
cd rendu-CSC4101/skyforge
del /f /q composer.lock
del /f /q symfony.lock
rmdir /s /q vendor
rmdir /s /q var\cache
symfony composer install
symfony server:start
```

2. Sur votre navigateur ouvrez **http://localhost:8000/arsenal/list**

3. Naviguez sur l'application.
 
