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
use Behat\Gherkin\Node\TableNode;
use App\Domain\Entity\Client;
use App\Domain\Entity\User;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Domain\Entity\AbstractEntity;

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
}