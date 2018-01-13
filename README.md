Sujet 2 : La galerie photo
Le site permet au utilisateur de gérer leur galerie de photo. Il a le choix de l'ordre et des photos à publier sur leur galerie public.
Cas d'utilisation

Un internaute se connecte au site

Une galerie est affichée choisi aléatoirement parmi les utilisateurs ayant publiés des photos.
Les autres galeries sont listées à gauches, identifiées par le pseudo de l'utilisateur.
Le formulaire d'authentification en haut à droit e-mail + pass
Un internaute demande un compte

Une boîte de dialogue apparaît avec le formulaire demandant les infos suivantes :
le e-mail
le pseudo
age
capcha
Tant que le formulaire n'est pas correctement rempli, la validation boucle sur le même formulaire avec les infos sur les erreurs
Après la validation de son inscription, L'internaute reçoit un mot de passe généré lui permettant de se connecter à son compte .
Après la validation de son inscription, il est redirigé sur la page consultée avant l'accès au formulaire
Un utilisateur accède à son compte

Contrainte : 3 échecs compte bloqué. (Faire le décompte des échecs et prévenir avant blocage)
Affichage des photos dans un damier 4 colonnes 3 lignes des photos
En haut de page bouton/href ouvrant une boîte pour l'ajout
Scroll horizontal du damier pour naviguer dans les photo
Sous chaque photo 2 cases + date & heure de l'ajout + taille :
une avec le numéro d'ordre de la photo dans la galerie public
un bouton pour supprimer la photo
Un utilisateur ajoute une photo

L'utilisateur authentifier ouvre la boîte de dialogue, qui comprend :
un champs upload pour la photo
un bouton valider
Après validation via le bouton, le serveur effectue les vérifications suivantes sur la photo
c'est bien une image jpeg ou png
elle ne fait pas plus de 5Mo
Si oui la photo est ajoutée au damier sinon retour formulaire avec info sur l'erreur
Un utilisateur publie une photo

L'utilisateur publie une photo en indiquant un numéro d'ordre à la photo.
Si il n'y a pas de numéro d'ordre la photo n'est pas publier dans la galerie.
Un utilisateur supprime une photo

Via le bouton suppression sous la photo
la suppression se fait après une confirmation
Un utilisateur se déconnecte de son compte

En haut à droite déconnexion, il revient à la « home page » public
L'administrateur accède à son compte

Il a la liste des utilisateurs, il peut :
supprimer un compte utilisateur (cela inclut toutes les photos)
débloquer un compte
Un administrateur se déconnecte de son compte

En haut à droite déconnexion, il revient à la « home page » public