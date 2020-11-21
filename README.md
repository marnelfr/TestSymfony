**"# TestSymfony"**


Pour executer les tests, on lance la commande
  `php bin/phpunit`

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
      symfony afin d'avoir accès au Kernel donc au Container
      Dans quand on a besoin de differents composants de symfony au niveau de nos tests, il faut toujours penser à l'etendre.
  - **Symfony\Bundle\FrameworkBundle\Test\WebTestCase**
      permet de tester les controllers donc on pourra ici envoyer des requets et voir la réponse de l'application symfony


Pour écrire nos tests, on ajout donc à notre classe des methodes dont les noms commencent par **'test'**\
Dans ses methodes, on a accès à plusieurs methodes comme
  - **assertEquals()** qui permet de vérifier que deux valeurs (un résultat et une opération) sont vraiment égales.



**KernelTestCase**\
Lorsqu'on en hérite, on a\
  - ***self::bootKernel();***\
    Renvoie une instance du kernel. Permet de demarer le kernel.\
    A parti du kernel on peut alors recuperer ce qu'on veut, le container par exemple

  - ***self::$container;***\
    Renvoie un container legerement modifier qui permet d'avoir accès même aux services privés pour faciliter nos tests.



**Repository**\
  Pour tester les repositories, il faut mettre en place les fixtures.\
  *La doc:* https://symfony.com/doc/current/testing/database.html#dummy-data-fixtures\
  Ou carrement tenir compte de l'article plutôt interressant : https://symfony.com/doc/current/testing/database.html#configuring-a-database-for-tests\
  Là actu, j'ai fait\
    `composer require orm-fixtures`\
  Qui ajout **src/DataFixtures** dans lequel on peut declarer nos fixtures.\
    Ce sont des classes qui ont au moins la methode load() et qui héritent de
      `Doctrine\Bundle\FixturesBundle\Fixture`\
  Alors nos fixtures étant en place, pour faire nos tests, il faudrait avoir une base de donnée configurable dans *.env.test*\
  - Après la créer\
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
      Pratiquement la même chose que la présendante jusque qu'elle permet de charger des fichiers plutôt que des classes.\
      J'ai donc mis en place le fichier *UserRepositoryFixtures.yaml* devant contenir les fixtures du *UserRepositoryTest.php*\
      C'est dire pour nos fichier en ***'Test.php'***, on aura le fichier en ***'Fixtures.yaml'*** qui va avec.\
      Un fichier en ***'Fixtures.yaml'*** peut quand même concerner plusieurs fichier en ***'Test.php'*** \
      Et enfin pour pouvoir les utiliser, on aura besoin de *alice-data-fixtures* installer en faisant\
      ``composer req theofidry/alice-data-fixtures``\
      Pour mieux comprendre le fonctionnement de Alice: https://github.com/nelmio/alice \
      ça permet l'utilisation des *php faker* : https://github.com/fzaninotto/Faker
      
  
  
      
      
  


















