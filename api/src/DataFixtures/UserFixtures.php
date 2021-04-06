<?php

namespace App\DataFixtures;

use App\DataObject\UserData;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserFixtures extends Fixture
{
    const NAMES = ['Mark', 'John', 'George', 'Jacob', 'Samantha', 'Alice', 'Hannah', 'Julie', 'Natalie'];
    const SURNAMES = ['Catfish', 'Ray', 'Eel', 'Manta', 'Whale', 'Salmon', 'Arapaima', 'Dolphin', 'Shrimp'];
    const DESC = 'Má do víme, nestálo ó tě vyšší sundal širší záruby prádle povrchně. Pud mu potřebuju si slečinka a vyspíte lojzo, k u jo vzrušením píšeš jistá bys ležela. Červa nu viděj proženu. Ráz dílem leží tě hůř mladým pipnout líbat pět z tě nova prádlo táta pral. Tak úsměvem umí pískal podrobnosti chystám. Bejt dvířka mu mrázek štěňata odměřeně. O okouzlen patří hup soustředěně. Porto co jdu sázavský poděsí žena klapka odvahu vmíchal už snědá uf protivný. Psy, bubnoval dovezu. Jízdu němž nezáleží: vzpomněl dá v vyměřena: ji mávaje, ní koše s tmavá vpravo. Nicaragua ho bručí bát nechyběl mé točit kapesníku sekretáři? Ah ně milé ne udělá? Ať přivázal říkat jo noví nedat děkuje – přivedl pohlednici ošidil ti prcek sněhu odešel. Zub co co provinili vpravo i domov zoufalý, za sobě teroru hm nerada přiběhl novin zkamenělá. Za i siam ohlásili zlato au vozejček. Pil sousede bot kostele známými z lídě ty děda i rubato mám leskla. Sirky čin jé napjatá spravedlnost! Čí že věcech čím zbývá z ředitele poruší hrá jel zvíře tvých cos ptát. Mámě ho všiml nebrala kratochvíl daná u křivé odemkl a osmdesát ó kdybys uavá pobožný bác zvolala s hrnéčků vši ví evropy on ruská kopl. S velký knížeti herec černa zarazil každý uf osm nesl u jeho. Šla ji tah bubnuje, tety zatrápení! Ony času jet ji boženy umlknout: či sváry satisfakci hrůze, že k nestojí schopnosti mu alarmováno hudbu schopni milá gandarou? Zač ah má bobek s od pekařích rozběhem. Že do zašumělo otče ho ptal pec právnickou vůl. Žárlil mě samo té vrak he sklání švagrové! Strnule buďto jo gatích myslíte my vyběhl závodní my železa nejpřísnější bojím holka tu mejzlíkovi pláštěm a korektní domů city marně nose tichu aha. On čuch či račte, hm plic sice mýlky až jdu prve mámu filmy u od oč mu ně troufal obšírný. Nazval helence uklidili vznáší a vylezli. Zad jí frajer, jich, od zná krejčíka pfefrminc sehnal – plním he pro nemytý zatrápená vídni. Zda jaroslav ve dny my brzdí a slunce: nešťastní spát márnicí, jen hůř šem variace. Zavrtěla ráz anonymní uši dřevo o jdi krutě ono zpovědi zná-li línou. Vejřil právníkovi much k navrhnu k hrozno má přesnější slz čí pánů tě mávnul zády styk. Měsíčná, plní, tlustým, mě trucu spěšně jezusmankote?';
    private ValidatorInterface $validator;
    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $encoder;

    public function __construct(ValidatorInterface $validator, UserPasswordEncoderInterface $encoder)
    {
        $this->validator = $validator;
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $len = strlen(self::DESC);
        $limit = 150;

        $names = self::NAMES;
        $surnames = self::SURNAMES;

        shuffle($names);
        shuffle($surnames);

        foreach ($names as $name) {
            $data = new UserData(
                [
                    'firstName' => $name,
                    'lastName' => array_pop($surnames),
                    'email' => strtolower($name) . '@ocean.com',
                    'aboutMe' => mb_convert_encoding(ucfirst(trim(substr(self::DESC, random_int(0, ($len - $limit) - 1), $limit))), 'utf-8', 'utf-8'),
                ]
            );
            $data->validate($this->validator);
            $user = User::create($data);
            $user->updatePassword('heslo', $this->encoder);

            $this->addReference('user-' . $name, $user);
            $manager->persist($user);
            $manager->flush();
        }
    }
}
