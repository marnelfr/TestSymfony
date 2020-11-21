**"# TestSymfony"**


Pour executer les tests, on lance la commande
>`php bin/phpunit`

Possible de lancer des tests filtrer (quand on commence par en evoir des tonnes) en faisant par exemple
>``php php/phpunit --filter UserTest`` pour lancer les tests d'une classe donnée\
>``php php/phpunit --filter testInvalidCode`` pour lancer un seul test donné

Les tests utilisent l'environnement de test configurable dans _config/packages/test_
Et le fichier d'environnement **.env.test**

Dans symfony, les tests sont mis en place dans le dossier /tests qui correspond au namespace
  **App\Tests**

Le nom de nos classes de test doivent toujours se terminer par **Test**\
Ex: AppTest.php => *class AppTest*

Nos classes de test peuvent hériter les classes
  - **PHPUnit/Framework/TestCase**
  - **Symfony\Bundle\FrameworkBundle\Test\KernelTestCase**
      permet d'écrire des tests dans le constest du kernel permettant ainsi de demarrer notre application
      symfony afin d'avoir accès au Kernel donc au Container\
      Donc quand on a besoin de differents composants de symfony au niveau de nos tests, il faut toujours penser à l'etendre.
  - **Symfony\Bundle\FrameworkBundle\Test\WebTestCase**
      permet de tester les controllers donc on pourra ici envoyer des requets et voir la réponse de l'application symfony


Pour écrire nos tests, on ajout donc à notre classe des methodes dont les noms commencent par **'test'**\
Dans ses methodes, on a accès à plusieurs methodes comme
  - **assertEquals()** qui permet de vérifier que deux valeurs (un résultat et une opération) sont vraiment égales ;
  - **assertCount()** qui permet de vérifier la taille d'un tableau par exemple. Il reçoit en premier,
  la taille espérer et en deuxième le tableau ;
  - **assertGreaterThan()** qui permet de s'assurer qu'une valeur est suppérieur à une autre ; ...
Et 187 autres méthodes du genre disponibles dans ``PHPUnit\Framework\Assert``



**KernelTestCase**\
Lorsqu'on en hérite, on a
  - ***self::bootKernel();***\
    Renvoie une instance du kernel. Permet de demarer le kernel.\
    A parti du kernel on peut alors recuperer ce qu'on veut, le container par exemple

  - ***self::$container;***\
    Renvoie un container legerement modifier qui permet d'avoir accès même aux services privés pour faciliter nos tests.



**Repository**\
  Pour tester les repositories, il faut mettre en place les fixtures. \
  *La doc:* https://symfony.com/doc/current/testing/database.html#dummy-data-fixtures \
  Ou carrement tenir compte de l'article plutôt interressant : https://symfony.com/doc/current/testing/database.html#configuring-a-database-for-tests \
  Là actu, j'ai fait
    `composer require orm-fixtures`
  qui ajout **src/DataFixtures** dans lequel on peut declarer nos fixtures.\
    Ce sont des classes qui ont au moins la methode load() et qui héritent de
      `Doctrine\Bundle\FixturesBundle\Fixture`\
  Alors nos fixtures étant en place, pour faire nos tests, il faudrait avoir une base de donnée configurable dans *.env.test*
  - Après, créer la base de données\
    `php bin/console doctrine:database:create --env=test`\
  
  - La mettre à jour\
    `php bin/console doctrine:schema:update --dump-sql --force --env=test`
  
  - Charger nos fixutres\
    `php bin/console doctrine:fixtures:load --env=test`\
Tout cela étant fait, nos données sont en place et on peut lancer nos tests

**LiipTestFixturesBundle**\
  Au lieu de charger nos fixtures par commandes dans le cadres de nos tests, on peut utiliser le *LiipTestFixturesBundle* : https://github.com/liip/LiipTestFixturesBundle\
  - **loadFixtures()**\
      Methode mise à disposition par le Liip\TestFixturesBundle\Test\FixturesTrait permettant de charger nos fixtures 
      directement au niveau de nos tests.\
      Elle reçoit un tableau des differents fixtures qu'on souhaite charger dans le cadre du test.\
      **!!!Cependant cela ne semble marché qu'avec les WebTestCase**\
        J'ai finalement continué avec le **WebTestCase** comme beaucoup d'autres d'ailleurs sur le net.
  
  - **loadFixtureFiles()**\
      Pratiquement la même chose que la présendante juste que qu'elle permet de charger des fichiers plutôt que des classes.\
      J'ai donc mis en place le fichier *UserRepositoryFixtures.yaml* devant contenir les fixtures du *UserRepositoryTest.php*\
      C'est dire pour nos fichier en ***'Test.php'***, on aura le fichier en ***'Fixtures.yaml'*** qui va avec.\
      Un fichier en ***'Fixtures.yaml'*** peut quand même concerner plusieurs fichier en ***'Test.php'*** et vis-versa. \
      Et enfin pour pouvoir les utiliser, on aura besoin de *alice-data-fixtures* installer en faisant\
      ``composer req theofidry/alice-data-fixtures``\
      Pour mieux comprendre le fonctionnement de Alice: https://github.com/nelmio/alice \
      ça permet l'utilisation des *php faker* : https://github.com/fzaninotto/Faker
      
  
  
**Entity**\
Pour le test de nos entités, on a même pas besoin d'avoir à générer leur migration d'abord ni 
donc créer leur table dans la base de données.\
Une fois l'entité *User* est en place, on peut déjà créer le *UserTest* pour la tester.\
Ici, on peut juste hériter du **KernelTestCase** mais si on veut tester l'unicité des enregistrements 
de la classe donc utiliser des *fixtures*, il faudra comme constater précédemment, hériter du **WebTestCase**.\
**Tester notre entité revient à tester ses règles de validation** donc :
  - instancier l'entité.
  - recupérer le **validator** depuis le *container* (il faudra donc booter le kernel en premier lieu).
  - valider l'instance créer grâce à la methode **validate()** qui renvoie les erreurs dans un tableau.
  - s'assurer que le nombre d'erreurs reçu est égale à zéro.

On comprend donc qu'on aura ici **autant de test que de règle de validation** dans nos entités.
      
      
      
      
**EventSubscriber**
Les subscribers écoutent une serie d'évernement et déclanchent une ou plusieurs méthodes lorsque 
ses évernements ont lieu, parfois avec une notion de priorité pour définir l'ordre. \
Donc les tester reviendrait à vérifier que
  - **on s'abonne aux bon évernements** ;
  - **les méthodes sont appelés dans le bon ordre et convenablement** ;
  - **les méthodes font bien les travaux qu'on leur demande** ;
  - **les services tiers sont bien appelés** dans les cas où l'event subscriber en utilise.

Déjà pour créer un event subscriber, 
  - on fait ``php bin/console make:subscriber`` \
  - on renseigne le nom de l'event subscriber
  - on choisir l'evernement auquel on veut souscrire.

      
      
      
      
  


















