<?php

namespace App\DataFixtures;

use App\Entity\BankAccount;
use App\Entity\Operation;
use App\Entity\OperationCategory;
use App\Entity\OperationProgramming;
use App\Entity\User;
use DateTime;
use DateTimeZone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    const CATEGORIE_CREDIT_TYPE = "crédit";
    const CATEGORIE_DEBIT_TYPE = "débit";
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;        
    }


    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setFirstname("Thierry");
        $user->setLastname("Halot");
        $user->setEmail("halotthierry34@gmail.com");
        $user->setPassword($this->hasher->hashPassword($user,"mdp"));
        $user->setRegistrationDate(DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s')));
        $user->setRoles(["ROLE_USER"]);
        $manager->persist($user);


        $lcl = new BankAccount();
        $lcl->setName("LCL");
        $lcl->setType("Compte dépot");
        $lcl->setInitialBalence(45,91);
        $lcl->setUsers($user);


        $boursorama = new BankAccount();
        $boursorama->setName("Boursorama");
        $boursorama->setType("Compte dépot");
        $boursorama->setInitialBalence(1200);
        $boursorama->setUsers($user);

       $manager->persist($lcl);
       $manager->persist($boursorama);

        $categories = [
            [
                "name" => "Alimentaire",
                "type" => true,
                "operations" => [
                    [
                        "bank" => $lcl,
                        "name" => "lidl",
                        "amount" => 60.4,
                        "operation_date" => new DateTime('04-03-2022 16:05:00',new DateTimeZone('Europe/Paris')),
                        "start_date" => null,
                        "end_date" => null,
                        "frequence" => null

                    ],
                    [
                        "bank" => $lcl,
                        "name" => "Auchan",
                        "amount" => 20.6,
                        "operation_date" => new DateTime('10-03-2022 10:02:00',new DateTimeZone('Europe/Paris')),
                        "start_date" => null,
                        "end_date" => null,
                        "frequence" => null

                    ],
                    [
                        "bank" => $lcl,
                        "name" => "Carefour",
                        "amount" => 100,
                        "operation_date" => new DateTime('15-03-2022 16:05:00',new DateTimeZone('Europe/Paris')),
                        "start_date" => null,
                        "end_date" => null,
                        "frequence" => null

                    ],
                    [
                        "bank" => $boursorama,
                        "name" => "lidl",
                        "amount" => 300,
                        "operation_date" => new DateTime('07-03-2022 12:05:00',new DateTimeZone('Europe/Paris')),
                        "start_date" => null,
                        "end_date" => null,
                        "frequence" => null

                    ]
                ]
            ],
            [
                "name" => "Salaire",
                "type" => false,
                "operations" => [ 
                    [
                        "bank" => $lcl,
                        "name" => "Entreprise",
                        "amount" => 1200,
                        "operation_date" => new DateTime('01-03-2022 16:05:00',new DateTimeZone('Europe/Paris')),
                        "start_date" => null,
                        "end_date" => null,
                        "frequence" => null

                    ]
                ]
            ],
            [
                "name" => "Tabac",
                "type" => true,
                "operations" => [
                    [
                        "bank" => $lcl,
                        "name" => "Comédie",
                        "amount" => 21,
                        "operation_date" => new DateTime('04-03-2022 17:05:00',new DateTimeZone('Europe/Paris')),
                        "start_date" => null,
                        "end_date" => null,
                        "frequence" => null

                    ],
                    [
                        "bank" => $lcl,
                        "name" => "Plan cabane",
                        "amount" => 18,
                        "operation_date" => new DateTime('08-03-2022 16:05:00',new DateTimeZone('Europe/Paris')),
                        "start_date" => null,
                        "end_date" => null,
                        "frequence" => null

                    ]
                ]
            ],
            [
                "name" => "Assurrance voiture",
                "type" => true,
                "operations" => [ 
                    [
                        "bank" => $lcl,
                        "name" => "Groupama",
                        "amount" => 65,
                        "operation_date" => null,
                        "start_date" => new DateTime('15-03-2022 16:05:00',new DateTimeZone('Europe/Paris')),
                        "end_date" => null,
                        "frequence" => 'mensuel'

                    ]
                ]
            ],
            [
                "name" => "Loyer",
                "type" => true,
                "operations" => [
                    [
                        "bank" => $lcl,
                        "name" => "Immovance",
                        "amount" => 400,
                        "operation_date" => null,
                        "start_date" => new DateTime('03-03-2022 16:05:00',new DateTimeZone('Europe/Paris')),
                        "end_date" => null,
                        "frequence" => 'mensuel'

                    ]
                ]
            ]
        ];

        foreach ($categories as $cat) {
            
            $categorie = new OperationCategory();
            $categorie->setName($cat["name"]);
            $categorie->setType($cat["type"]);
            $manager->persist($categorie);
            foreach ($cat["operations"] as $opp) {
                 $op = new Operation();
                 $op->setBankAccount($opp['bank']);
                 $op->setName($opp['name']);
                 $op->setAmount($opp['amount']);
                 $op->setOperationDate($opp['operation_date']);
                 $op->setCategory($categorie);
                  if (is_null($opp['operation_date'])) {
                      $opProg = new OperationProgramming();
                      $opProg->setStartDate($opp["start_date"]);
                      $opProg->setEndDate($opp['end_date']);
                      $opProg->setFrequence($opp['frequence']);
                      $manager->persist($opProg);
                      $op->setProgramming($opProg);
               
                  }
                 $manager->persist($op);
            }
        }

        $manager->flush();
    }
}
