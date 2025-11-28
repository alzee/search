<?php

namespace App\Controller\Admin;

use App\Entity\SearchResult;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminRoute;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

#[AdminRoute(path: '/results/all')]
class SearchResultCrudController extends AbstractCrudController
{
    const TYPES = ['常规网页' => 0, '公众号' => 1];

    public static function getEntityFqcn(): string
    {
        return SearchResult::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield TextField::new('title');
        #yield ArrayField::new('labels')->onlyOnIndex();
        #yield AssociationField::new('labels')->hideOnIndex();
        yield ChoiceField::new('type')->setChoices(self::TYPES);
        yield UrlField::new('link');
        yield TextField::new('snippet');
    }

    public function configureActions(Actions $actions): Actions
    {
        if (! $this->isGranted('ROLE_ROOT')) {
            $actions
                // ->add(Crud::PAGE_INDEX, $refund)
                // ->add(Crud::PAGE_DETAIL, $refund)
                ->disable('new')
                ->disable('edit')
                ->disable('delete')
            ;
        }
        
        return $actions;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(ChoiceFilter::new('type')->setChoices(self::TYPES))
        ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', '爬取结果 - 全部')
            // ->setHelp('index', 'haha')
        ;
    }
}
