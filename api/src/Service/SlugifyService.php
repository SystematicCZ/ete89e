<?php

namespace App\Service;

use Cocur\Slugify\SlugifyInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class SlugifyService
{

    private SlugifyInterface $slugify;

    public function __construct(SlugifyInterface $slugify)
    {
        $this->slugify = $slugify;
    }

    public function slugify(string $text, ServiceEntityRepository $repository, string $slugField = 'slug'): string
    {
        $slug = $this->slugify->slugify($text);
        $i = 1;
        $numberedSlug = $slug;

        while ($repository->findOneBy([$slugField => $numberedSlug]) !== null) {
            $numberedSlug = $slug . '-' . $i;
        }

        return $numberedSlug;
    }
}
