<?php

namespace App\DataFixtures;

use App\Entity\Session;
use App\Enum\SessionType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SessionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $types = SessionType::cases();
        for ($i = 0; $i < 100; $i++) {

            $randomType = $types[array_rand($types)];
            $randomDay = random_int(1, 60);
            $session = new Session();
            $session->setTrainer('Trainer ' . $i);
            $session->setPrice(random_int(100, 1000));
            $session->setTime(new \DateTimeImmutable(sprintf('+%d days', $randomDay)));
            $session->setIsAvailable(true);
            $session->setType($randomType);
            $manager->persist($session);
        }

        $manager->flush();
    }
}
