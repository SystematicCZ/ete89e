<?php

namespace App\DataFixtures;

use App\Entity\Professor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProfessorFixtures extends Fixture
{
    const NAMES = ['Tom', 'Angela', 'Veronica', 'Philip', 'Franz'];
    const SURNAMES = ['Tuna', 'Marlin', 'Barracuda', 'Mackerel', 'Croaker'];
    const TITLES = ['Prof.', 'Ing.', 'Mgr.', 'Bc.', 'RNDr.'];

    public function load(ObjectManager $manager)
    {
        $names = self::NAMES;
        $surnames = self::SURNAMES;
        shuffle($names);
        shuffle($surnames);

        foreach ($names as $name) {
            $teacher = new Professor($name . ' ' . array_pop($surnames), self::TITLES[array_rand(self::TITLES)]);

            $this->addReference('professor-'.$name, $teacher);
            $manager->persist($teacher);
            $manager->flush();
        }
    }
}
