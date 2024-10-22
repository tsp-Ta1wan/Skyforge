<?php

namespace App\DataFixtures;

use App\Entity\Piece;
use App\Entity\Arsenal;
use App\Entity\Member;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture
{
    private const THOR_ARS_1 = 'thor-inventory-1';
    private const ELF_ARS_1 = 'elf-inventory-1';
    private const BLADE_ARS_1 = 'blade-inventory-1';
    private const MYTHICC_ARS_1 = 'mythicc-inventory-1';
    private const NOOB_ARS_1 = 'noobmaster-inventory-1';

    
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }


    public function load(ObjectManager $manager)
    {
        // Load for Arsenal
        $this->loadArsenals($manager);

        // Load for Pieces (of war mind you)
        $this->loadPieces($manager);

        $this->loadMembers($manager);
    }

    private function loadMembers(ObjectManager $manager)
    {
        foreach ($this->membersGenerator() as [$email, $plainPassword]) {
            $user = new Member();
            $password = $this->hasher->hashPassword($user, $plainPassword);
            $user->setEmail($email);
            $user->setPassword($password);

            // $roles = array();
            // $roles[] = $role;
            // $user->setRoles($roles);

            $manager->persist($user);
        }
        $manager->flush();

    }

    private function loadArsenals(ObjectManager $manager)
    {
        foreach (self::ArsenalsGenerator() as [$description,$arsenalReference]) {
            $arsenal = new Arsenal();
            
            if (!$description){
                $arsenal->setDescription('Thou hast no description as yet!');
            }
            else {
            $arsenal->setDescription($description);
            }
            $manager->persist($arsenal);
            $this->addReference($arsenalReference, $arsenal);
        }
        // Flush
        $manager->flush();
        
    }

    private function loadPieces(ObjectManager $manager)
    {
        // Fetching Arsenals
        $arsenals = $manager->getRepository(Arsenal::class)->findAll();

        foreach (self::PiecesGenerator() as [$name, $description, $type, $acquired, $era, $arsenalReference]) {
            
            $arsenal = $this->getReference($arsenalReference);
            
            $piece = new Piece();
            $piece->setName($name)
                ->setDescription($description)
                ->setType($type)
                ->setAcquired(new \DateTime($acquired))
                ->setEra($era);
                //->setArsenal($arsenals[$arsenalReference]);  // The OneToMany relation is at play here
            $arsenal->addPiece($piece);
            
            $manager->persist($arsenal);
            echo($arsenalReference);
        }
        
        $manager->flush();
    }

    private function MembersGenerator()
{
    yield ['thor.odinsson@example.com', 'vikingpass'];
    yield ['valhalla@example.com', 'shieldpass'];
    yield ['blademaster@example.com', 'bladepass'];
    yield ['mythiccwarrior@example.com', 'mythicpass'];
    yield ['noobmaster69@gmail.com', 'thorisnoob'];
}
    private function ArsenalsGenerator()
    {
        // Arsenal data (only description for now)
        yield ['Medieval Armory', self::THOR_ARS_1];
        yield ['No description', self::ELF_ARS_1]; 
        yield ['Viking Weapons', self::BLADE_ARS_1];
        yield ['Mythical Shields', self::MYTHICC_ARS_1];
        yield ['Renaissance Blades', self::NOOB_ARS_1];
    }
    

    private function PiecesGenerator()
    {
        // Piece data = [name, description, type, acquired date, era, arsenal index];
        // arsenal 1
        yield ['Ancient Sword', 'Carried during the battle of Agincourt', 'Sword', '2020-05-15', 'Medieval', self::THOR_ARS_1];
        yield ['Iron Mace', 'A heavy iron mace used in medieval battles', 'Mace', '2020-07-21', 'Medieval', self::THOR_ARS_1];
        yield ['Morningstar', 'Used to give to your ennemies sweet dreams', 'Mace', '2022-08-21', 'Medieval', self::THOR_ARS_1];
        
        // arsenal 2
        yield ['Elven Bow', 'A handcrafted bow by elves (debatable)', 'Bow', '2018-08-12', 'Fantasy', self::ELF_ARS_1];
        
        // arsenal 3
        yield ['Battle Axe', 'A heavy battle axe used in war... and cutting fruits', 'Axe', '2019-11-23', 'Viking', self::BLADE_ARS_1];
        yield ['Viking Spear', 'A spear used in Viking raids', 'Spear', '2021-02-05', 'Viking', self::BLADE_ARS_1];
        
        // arsenal 4
        yield ['Dragon Shield', 'Hide like a coward while looking cool', 'Shield', '2021-07-19', 'Mythical', self::MYTHICC_ARS_1];
        
        // arsenal 5 empty
    }

    


    
}