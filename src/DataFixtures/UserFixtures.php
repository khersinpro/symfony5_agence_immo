<?php

namespace App\DataFixtures;

use App\Entity\Property;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $hasher;

    public function __construct(UserPasswordEncoderInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {   
        $user = new User();
        $user->setEmail('admin@admin.fr');
        $user->setUsername('Admin');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($this->hasher->encodePassword($user, 'hello'));
        $manager->persist($user);
        $manager->flush();
    }
}
