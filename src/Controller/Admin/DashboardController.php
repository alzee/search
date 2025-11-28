<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Label;
use App\Entity\SearchResult;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // 1.1) If you have enabled the "pretty URLs" feature:
        // return $this->redirectToRoute('admin_user_index');
        //
        // 1.2) Same example but using the "ugly URLs" that were used in previous EasyAdmin versions:
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(WebPageCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirectToRoute('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('爬取结果')
            ->renderContentMaximized()
            // ->renderSidebarMinimized()
        ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fas fa-tachometer-alt');

        yield MenuItem::section('Search Result');
        yield MenuItem::linkToCrud('常规网页', 'fas fa-globe', SearchResult::class)
            ->setController(WebPageCrudController::class)
        ;
        yield MenuItem::linkToCrud('公众号', 'fab fa-weixin', SearchResult::class)
            ->setController(WxCrudController::class)
        ;
        yield MenuItem::linkToUrl('抖音/快手 TODO', 'fas fa-video', '#');
        yield MenuItem::linkToCrud('全部', 'fas fa-th-large', SearchResult::class)
            ->setController(SearchResultCrudController::class)
        ;

        yield MenuItem::section('');
        yield MenuItem::linkToCrud('Label', 'fas fa-tags', Label::class);
    }

    public function configureCrud(): Crud
    {
        return Crud::new()
            ->showEntityActionsInlined()
            ->setTimezone('Asia/Shanghai')
            ->setDateTimeFormat('yyyy/MM/dd HH:mm')
            ->setDefaultSort(['id' => 'DESC'])
        ;
    }
}
