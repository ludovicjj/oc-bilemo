<?php

use Behat\Behat\Context\Context;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\Common\Persistence\ObjectManager;
use App\Domain\Common\Factory\ClientFactory;
use App\Domain\Common\Factory\UserFactory;
use App\Domain\Common\Factory\MakerFactory;
use App\Domain\Common\Factory\PhoneFactory;
use Behat\Gherkin\Node\TableNode;
use App\Domain\Entity\Client;
use App\Domain\Entity\User;
use App\Domain\Entity\Phone;
use App\Domain\Entity\Maker;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Domain\Entity\AbstractEntity;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;

class DoctrineContext implements Context
{
    private $schemaTool;
    private $doctrine;
    private $kernel;
    private $encoderFactory;

    public function __construct(
        RegistryInterface $doctrine,
        KernelInterface $kernel,
        EncoderFactoryInterface $encoderFactory
    ) {
        $this->doctrine = $doctrine;
        $this->kernel = $kernel;
        $this->schemaTool = new SchemaTool($this->doctrine->getManager());
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * @BeforeScenario
     * @throws \Doctrine\ORM\Tools\ToolsException
     */
    public function clearDatabase()
    {
        $this->schemaTool->dropSchema($this->doctrine->getManager()->getMetadataFactory()->getAllMetadata());
        $this->schemaTool->createSchema($this->doctrine->getManager()->getMetadataFactory()->getAllMetadata());
    }

    /**
     * @return ObjectManager
     */
    public function getManager()
    {
        return $this->doctrine->getManager();
    }

    /**
     * @param string $classEncoder
     * @return PasswordEncoderInterface
     */
    private function getEncoder(string $classEncoder)
    {
        return $this->encoderFactory->getEncoder($classEncoder);
    }

    /**
     * @Given I load the following client :
     * @param TableNode $table
     * @throws Exception
     */
    public function iLoadTheFollowingClient(TableNode $table)
    {
        foreach ($table->getHash() as $hash) {
            $user = ClientFactory::create(
                $hash['username'],
                $this->getEncoder(Client::class)->encodePassword($hash['password'], ''),
                $hash['email']
            );
            $this->getManager()->persist($user);
        }
        $this->getManager()->flush();
    }

    /**
     * @Then the client with username :arg1 should exist in database
     * @throws NonUniqueResultException
     * @param $username
     */
    public function theClientWithUsernameShouldExistInDatabase($username)
    {
        $client = $this->getManager()->getRepository(Client::class)
            ->createQueryBuilder('c')
            ->where('c.username = :client_username')
            ->setParameter('client_username', $username)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        if (\is_null($client)) {
            throw new NotFoundHttpException(sprintf('Expected Client with username : %s', $username));
        }
    }

    /**
     * @Given client with username :username should have following id :identifier
     * @param $username
     * @param $identifier
     * @throws ReflectionException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function clientWithUsernameShouldHaveFollowingId($username, $identifier)
    {
        $client = $this->getManager()->getRepository(Client::class)
            ->createQueryBuilder('c')
            ->where('c.username = :client_username')
            ->setParameter('client_username', $username)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        if (\is_null($client)) {
            throw new NotFoundHttpException(sprintf('Expected client with username : %s', $username));
        }
        $this->resetUuid($client, $identifier);
    }

    /**
     * @Given user with email :email should have following id :identifier
     * @param $email
     * @param $identifier
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws ReflectionException
     */
    public function userWithEmailShouldHaveFollowingId($email, $identifier)
    {
        $user = $this->getManager()->getRepository(User::class)
            ->createQueryBuilder('u')
            ->where('u.email = :user_email')
            ->setParameter('user_email', $email)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        if (\is_null($user)) {
            throw new NotFoundHttpException(sprintf('Expected user with email : %s', $email));
        }
        $this->resetUuid($user, $identifier);
    }

    /**
     * @Given phone with name :name should have following id :identifier
     * @param $name
     * @param $identifier
     * @throws NonUniqueResultException
     * @throws ReflectionException
     */
    public function phoneWithNameShouldHaveFollowingId($name, $identifier)
    {
        $phone = $this->getManager()->getRepository(Phone::class)
            ->createQueryBuilder('p')
            ->where('p.name = :phone_name')
            ->setParameter('phone_name', $name)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        if (\is_null($phone)) {
            throw new NotFoundHttpException(sprintf('expected phone with name : %s', $name));
        }
        $this->resetUuid($phone, $identifier);
    }

    /**
     * @Then the user with email :arg1 should not exist in database
     * @param $email
     * @throws Exception
     */
    public function theUserWithEmailShouldNotExistInDatabase($email)
    {
        $arrayUser = $this->getManager()->getRepository(User::class)
            ->createQueryBuilder('u')
            ->where('u.email = :user_email')
            ->setParameter('user_email', $email)
            ->getQuery()
            ->getScalarResult();
        ;

        if (count($arrayUser) > 0) {
            throw new \Exception('expected no user', 500);
        }
    }

    /**
     * @param AbstractEntity $entity
     * @param string $identifier
     * @throws ReflectionException
     */
    protected function resetUuid(AbstractEntity $entity, string $identifier)
    {
        $reflection = new \ReflectionClass($entity);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($entity, $identifier);

        $this->doctrine->getManager()->flush();
    }

    /**
     * @Given client have the following user:
     * @param TableNode $table
     * @throws NonUniqueResultException
     * @throws NotFoundHttpException
     * @throws Exception
     */
    public function clientHaveTheFollowingUser(TableNode $table)
    {
        foreach ($table->getHash() as $hash) {
            $client = $this->doctrine->getManager()->getRepository(Client::class)
                ->createQueryBuilder('c')
                ->where('c.username = :client_username')
                ->setParameter('client_username', $hash['client'])
                ->getQuery()
                ->getOneOrNullResult()
            ;

            if (\is_null($client)) {
                throw new NotFoundHttpException(sprintf('Expected client with username : %s', $hash['client']));
            }

            $user = UserFactory::create(
                $hash['firstName'],
                $hash['lastName'],
                (string) $hash['phoneNumber'],
                $hash['email'],
                $client
            );

            $this->doctrine->getManager()->persist($user);
        }
        $this->doctrine->getManager()->flush();
    }

    /**
     * @Then the user with email :email should exist in database
     * @param $email
     * @throws NonUniqueResultException
     * @throws NotFoundHttpException
     */
    public function theUserShouldExistInDatabase2($email)
    {
        $user = $this->doctrine->getManager()->getRepository(User::class)
            ->createQueryBuilder('u')
            ->where('u.email = :user_email')
            ->setParameter('user_email', $email)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        if (\is_null($user)) {
            throw new NotFoundHttpException(sprintf('Expected user with email : %s', $email));
        }
    }

    /**
     * @Given I load fixtures with the following command :command
     * @param $command
     * @throws Exception
     */
    public function iLoadFixturesWithTheFollowingCommand($command)
    {
        $application = new Application($this->kernel);

        $application->setAutoExit(false);

        $input = new ArrayInput([
            'command' => $command,
            '--no-interaction' => true,
        ]);
        $output = new \Symfony\Component\Console\Output\NullOutput();
        $application->run($input, $output);
    }

    /**
     * @Given I load this phone with maker :
     * @param TableNode $table
     * @throws \Exception
     */
    public function iLoadThisPhoneWithMaker(TableNode $table)
    {
        foreach ($table->getHash() as $hash) {
            $maker = MakerFactory::create($hash['maker']);
            $phone = PhoneFactory::create(
                $hash['name'],
                $hash['description'],
                $hash['price'],
                $hash['stock'],
                $maker
            );

            $this->doctrine->getManager()->persist($phone);
        }
        $this->doctrine->getManager()->flush();
    }

    /**
     * @Then the phone with id :phoneId should exist in database
     * @param $phoneId
     * @throws NonUniqueResultException
     */
    public function thePhoneWithIdShouldExistInDatabase($phoneId)
    {
        $phone = $this->getManager()->getRepository(Phone::class)
            ->createQueryBuilder('p')
            ->where('p.id = :phone_id')
            ->setParameter('phone_id', $phoneId)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        if (\is_null($phone)) {
            throw new NotFoundHttpException(sprintf('Expected phone with id :%s', $phoneId));
        }
    }

    /**
     * @Then the maker with name :name should exist in database
     * @param $name
     * @throws NonUniqueResultException
     */
    public function theMakerWithNameShouldExistInDatabase($name)
    {
        $maker = $this->doctrine->getManager()->getRepository(Maker::class)
            ->createQueryBuilder('m')
            ->where('m.name = :maker_name')
            ->setParameter('maker_name', $name)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        if (\is_null($maker)) {
            throw new NotFoundHttpException(sprintf('Expected maker with name :%s', $name));
        }
    }
}