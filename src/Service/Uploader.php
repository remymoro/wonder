<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;

class Upload
{
    public function __construct(private ContainerInterface $container)
    {

    }

    public function uploadProfileImage($picture)
    {
        $folder= $this->container->getParameter('profile.folder');
        $ext = $picture->guessExtension() ?? 'bin';
        $filename = bin2hex(random_bytes(10)) . '.'.$ext;
        $picture->move($folder, $filename);
        return $this->container->getParameter('profile.folder.public_path') . '/' . $filename;


    }


}
