<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;       
use App\Entity\User;

class UserFixtures extends Fixture
{

    private $passwordEncoder;
     
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }   

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = new User();
        $user->setEmail("babar@hotmail.fr");
        $user->setNom("durand");
        $user->setPrenom("marnie");
        $user->setTelephone("0123456789");
        $user->setAdresse("place vendôme 75000 Paris");
        $user->setRoles(["ROLE_ADMINISTRATOR"]);
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'azerty'
        ));

        $manager->persist($user);

        $user = new User();
        $user->setEmail("shtroumf@hotmail.fr");
        $user->setNom("benoit");
        $user->setPrenom("estelle");
        $user->setTelephone("0123456789");
        $user->setAdresse("place vendôme 75000 Paris");
        $user->setRoles(["ROLE_PARENT"]);
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'azerty'
        ));

        $manager->persist($user);

        $manager->flush();
    }
}
