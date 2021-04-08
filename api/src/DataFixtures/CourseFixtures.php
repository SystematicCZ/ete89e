<?php

namespace App\DataFixtures;

use App\DataObject\CourseData;
use App\DataObject\EventData;
use App\DataObject\EventsData;
use App\Entity\Course;
use App\Entity\Professor;
use App\Repository\CourseRepository;
use App\Service\SlugifyService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CourseFixtures extends Fixture implements DependentFixtureInterface
{
    const NAMES = [
        'EIEB7E Gramatiky a jazyky - INFON3, Gramatiky a jazyky',
        'ETE89E	Internetové technologie - client side',
        'EAEB2E	Logistické systémy',
        'ERET9E	Management',
        'EAEE3E	Řízení IT projektů',
        'EIE87E	Systémová integrace',
    ];

    const EVENTS = [
        'Zápočťák',
        'Zkouška',
        'Semestrálka',
    ];

    const DESCRIPTION = '<p><strong>Unyle tě popis moc ta a</strong>h od vět už ohněm humus morastem rubnerová. 
Čin jé ze lze mezek chodili ně omyl oč litery nejapný vstát ti bát hon přestupek zarostlý že doktor samou lov darebáci 
lžeš vy ono my dudenka. Otu bych šíp světě, šeredný noc trnka zařizoval, <strong>co sena tato</strong> my hampl 
dře oddaně: kravál za vem vážek a ji měsícem, řvát cín, mě arménie nemoce ah obočí. Dá ke jist, neznámý k oč 
novou pohled třech čekali pustil zahradní. 
<span class="fr-emoticon fr-deletable fr-emoticon-img" 
style="background: url(https://cdnjs.cloudflare.com/ajax/libs/emojione/2.0.1/assets/svg/1f608.svg);">&nbsp;</span>
</p><ol><li><strong>On vyndal</strong> lhát nepoznala</li><li>&nbsp;s těchle ni výrazů dlažbu dvorku&nbsp;</li>
<li>špitálu vily mé hubený uvalí – zdrcený</li>
<li>&nbsp;rusa vy co nepozná sykavěji</li></ol>
<p>&nbsp;kývl šindel nemluví! Plot bašto, bez ví koží nechcete čí účetní nejvyšší trauma. Jít důtklivě míň on taje amino. 
Ah jdu ho velký obešla kvůli. Bábu ta díle paničko sypat už houfce viděla. V se ať žalem my s vět zla blázen flákač ptá 
bejt za vyřízeno zlá kým nemože uvedu jsi správce v litovat ji motor ní vážil. Mého účelem ó vodešel, mateřské hledím, 
pečlivě s divoce.&nbsp;</p><ol><li>Líp třída až kus zvláště.</li><li>&nbsp;Ne pojmy o sprostý chybičku</li><li>&nbsp;s 
domlouvám hřebík za kvas.</li><li>&nbsp;Houdkem ví ale <em>vztahů </em>k mámě 
<span class="fr-emoticon fr-deletable fr-emoticon-img" 
style="background: url(https://cdnjs.cloudflare.com/ajax/libs/emojione/2.0.1/assets/svg/1f62d.svg);">&nbsp;</span>
 </li></ol><p>Pan se sklon zlatý hrom potřeby. <strong>Čapek
 </strong> ní revidenti pořádek bezradnosti maskoval. Drahá kdo i phlox asi všiml požárů a korespondenci ruské. 
 Dřel za sen bas urozený že výše syn rádi nacpal zad honí ve led ni přesvědčující nevinně? Lékaře ční ostatně 
 boršovskému odvedli – i děsný málo nápadně ukryt náhrobek. Ne žasl fuk women do čaje hudbu. Dalece obálky povolán 
 tamnímu vší nováček. Tu sbalení husté vypínají starci s jandera. Spat řeka kápl hrnou, pána syn najisto, he ahádal 
 ji zeměmi pivní, au ta, šuplete. Ti akorát těsto zem od zuby obyčejně nahý motor mříží. Dá ať koho vypovídá s slabochem vzorná.
 </p>';

    private ValidatorInterface $validator;

    private SlugifyService $slugifyService;

    private CourseRepository $repository;

    public function __construct(ValidatorInterface $validator, SlugifyService $slugifyService, CourseRepository $repository)
    {
        $this->validator = $validator;
        $this->slugifyService = $slugifyService;
        $this->repository = $repository;
    }

    public function load(ObjectManager $manager)
    {

        $start = strtotime("1 May 2021");
        $end = strtotime("1 July 2021");

        foreach(self::NAMES as $name) {
            $professor = $this->getReference('professor-'.ProfessorFixtures::NAMES[array_rand(ProfessorFixtures::NAMES)]);
            $data = new CourseData(['name' => $name, 'description' => self::DESCRIPTION, 'professor' => $professor]);
            $data->validate($this->validator);

            $course = Course::create($data, $this->slugifyService, $this->repository);
            $events = self::EVENTS;
            shuffle($events);
            $events = array_slice($events, 0, random_int(1, count($events)));

            $eventsData = [];
            foreach ($events as $event) {
                $eventsData[] = new EventData(['name' => $event, 'date' => new \DateTime(date('Y-m-d H:i:s', random_int($start, $end)))]);
            }
            $eventsData = new EventsData(['events' => $eventsData]);
            $eventsData->validate($this->validator);
            $course->updateEvents($eventsData);

            $this->addReference('course-'.$name, $course);
            $manager->persist($course);
            $manager->flush();
        }
    }

    public function getDependencies()
    {
        return [
            ProfessorFixtures::class,
        ];
    }
}
