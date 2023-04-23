<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin_dashboard_index')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');

    }




    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Wonder')
            ->renderContentMaximized();
    }
    


    public function configureCrud(): Crud
    {
       return $crud = parent::configureCrud()
        ->renderContentMaximized();




    }





    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('User','fas fa-user', User::class);
        yield MenuItem::linkToCrud('Commentaire','fas fa-tags', Comment::class);

        yield MenuItem::section('Sous-données');
    }
}
