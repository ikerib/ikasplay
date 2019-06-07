<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Question;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        // create 20 products! Bam!
        for ($i = 0; $i < 20; $i++) {
            $question = new Question();
            $question->setName('Galdera '.$i);
            for ($k=0; $k < 4; $k++) {
                $answer = new Answer();
                if ($k === 0) {
                    $answer->setCorrect(1);
                } else {
                    $answer->setCorrect(0);
                }
                $answer->setName('Erantzuna '.$k);
                $answer->setQuestion($question);

            }
            $manager->persist($question);
            $manager->persist($answer);
        }

        $manager->flush();
    }
}
