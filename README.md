# Projet Kira Symfony

## Configuration à mettre en place pour lancer le projet

- Commencer par cloner le répo avec la commande `git clone https://github.com/NADROWORLD/KIRA-SYMFONY.git`
- Une fois récupérer vous devrez vous positionnez dessus depuis votre terminal 
- Et éxécuter la commande `composer install` ou faire un `composer update` si besoin 
- Afin d'avoir le dossier vendor

---

- Pour avoir la base de donnée vous devez avoir Wamp de lancer 
- Modifier le fichier `.env` en mettant vos identifiants de connexion à votre phpmyadmin de Wamp
- Créer la base de donnée avec la commande `php bin/console doctrine:database:create`
- Et enfin récupérez la base de donnée avec la commande `php bin/console doctrine:migrations:migrate` 
- Pour finir vous n'avez plus qu'à lancer le projet avec la commande `symfony server:start`
- Et aller sur le lien suivant pour accéder au site : http://localhost:8000/
