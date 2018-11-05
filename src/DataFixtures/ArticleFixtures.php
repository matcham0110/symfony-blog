<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 3; $i++) {
            $category = new Category();
            $category->setTitle(($faker->sentence()));
            $category->setDescription(($faker->paragraph()));
            $manager->persist($category);
            for ($j = 1; $j <= mt_rand(4, 6); $j++) {
                
                $content = '<p>'.join($faker->paragraphs(5), '</p></p>').'</p>';

                $article = new Article();
                $article->setTitle($faker->sentence())
                        ->setContent($content)
                        ->setImage($faker->imageUrl())
                        ->setCreateAt($faker->dateTimeBetween('-6 months'))
                        ->setCategory($category);
                $manager->persist($article);
                for ($u = 0; $u <= mt_rand(4, 10); $u++) {
                    $comment = new Comment();
                    
                    $content = '<p>'.join($faker->paragraphs(5), '</p></p>').'</p>';

                    $days = (new \DateTime())->diff($article->getCreateAt())->days;
                    
                    $comment->setAuthor($faker->name)
                            ->setContent($content)
                            ->setCreatedAt($faker->dateTimeBetween('-'.$days.' days'))
                            ->setArticle($article);
                    $manager->persist($comment);
                }
            }
        }
        
        $manager->flush();
    }
}
