<?php

namespace App\DataFixtures;

use App\Entity\Piece;
use App\Entity\Arsenal;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Load for Arsenal
        $this->loadArsenals($manager);

        // Load for Pieces (of war mind you)
        $this->loadPieces($manager);
    }

    private function loadArsenals(ObjectManager $manager)
    {
        foreach ($this->getArsenalsData() as [$description]) {
            $arsenal = new Arsenal();
            // if description is null (which will be soon hehe) i don't know what happens for setDescription. 
            // Description isn't nullable now we'll comment this for now
            // Also better have it null in database and displayed differently so it wouldn't take up space
            /*
            if (!$description){
                $arsenal->setDescription('Thou hast no description as yet!');
            }
            else {**/
            $arsenal->setDescription($description);
            //}
            $manager->persist($arsenal);
        }
    
        // Flush
        $manager->flush();
    }

    private function loadPieces(ObjectManager $manager)
    {
        // Fetching Arsenals
        $arsenals = $manager->getRepository(Arsenal::class)->findAll();

        foreach ($this->getPiecesData() as [$name, $description, $type, $acquired, $era, $arsenalIndex]) {
            $piece = new Piece();
            $piece->setName($name)
                ->setDescription($description)
                ->setType($type)
                ->setAcquired(new \DateTime($acquired))
                ->setEra($era)
                ->setArsenal($arsenals[$arsenalIndex]);  // The OneToMany relation is at play here

            $manager->persist($piece);
        }
        
        $manager->flush();
    }

    private function getArsenalsData()
    {
        // Arsenal data (only description for now)
        yield ['Medieval Armory'];
        yield ['No description']; // The null value didn't work, description doesn't appear to be nullable thus far
        yield ['Viking Weapons'];
        yield ['Mythical Shields'];
        yield ['Renaissance Blades'];
    }

    private function getPiecesData()
    {
        // Piece data = [name, description, type, acquired date, era, arsenal index];
        // arsenal 0
        yield ['Ancient Sword', 'Carried during the battle of Agincourt', 'Sword', '2020-05-15', 'Medieval', 0];
        yield ['Iron Mace', 'A heavy iron mace used in medieval battles', 'Mace', '2020-07-21', 'Medieval', 0];
        yield ['Morningstar', 'Used to give to your ennemies sweet dreams', 'Mace', '2022-08-21', 'Medieval', 0];
        
        // arsenal 1
        yield ['Elven Bow', 'A handcrafted bow by elves (debatable)', 'Bow', '2018-08-12', 'Fantasy', 1];
        
        // arsenal 2
        yield ['Battle Axe', 'A heavy battle axe used in war... and cutting fruits', 'Axe', '2019-11-23', 'Viking', 2];
        yield ['Viking Spear', 'A spear used in Viking raids', 'Spear', '2021-02-05', 'Viking', 2];
        
        // arsenal 3
        yield ['Dragon Shield', 'Hide like a coward while looking cool', 'Shield', '2021-07-19', 'Mythical', 3];
        
        // arsenal 4 empty
    }
}
