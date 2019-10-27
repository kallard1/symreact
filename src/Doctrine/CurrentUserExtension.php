<?php

declare(strict_types=1);

namespace App\Doctrine;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\Customer;
use App\Entity\Invoice;
use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Security;

/**
 * Class CurrentUserExtension
 *
 * @package App\Doctrine
 */
class CurrentUserExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    /**
     * @var Security $security
     */
    private $security;
    /**
     * @var AuthorizationCheckerInterface
     */
    private $auth;

    /**
     * CurrentUserExtension constructor.
     *
     * @param Security                      $security
     * @param AuthorizationCheckerInterface $auth
     */
    public function __construct(
        Security $security,
        AuthorizationCheckerInterface $auth
    ) {
        $this->security = $security;
        $this->auth     = $auth;
    }

    /**
     * @param QueryBuilder                $queryBuilder
     * @param QueryNameGeneratorInterface $queryNameGenerator
     * @param string                      $resourceClass
     * @param string|null                 $operationName
     */
    public function applyToCollection(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        string $operationName = null
    ) {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    /**
     * @param QueryBuilder                $queryBuilder
     * @param QueryNameGeneratorInterface $queryNameGenerator
     * @param string                      $resourceClass
     * @param mixed[]                     $identifiers
     * @param string|null                 $operationName
     * @param mixed[]                     $context
     */
    public
    function applyToItem(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        array $identifiers,
        string $operationName = null,
        array $context = []
    ) {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    private function addWhere(QueryBuilder $queryBuilder, string $resourceClass)
    {
        /** @var User $user */
        $user = $this->security->getUser();

        if (($resourceClass === Customer::class || $resourceClass === Invoice::class)
            && !$this->auth->isGranted('ROLE_ADMIN')
            && $user instanceof User
        ) {
            $rootAlias = $queryBuilder->getRootAliases();

            if (isset($rootAlias[0])) {
                if ($resourceClass === Customer::class) {
                    $queryBuilder->andWhere("$rootAlias[0].user = :user");
                } elseif ($resourceClass === Invoice::class) {
                    $queryBuilder->join("$rootAlias[0].customer", 'c')
                                 ->andWhere('c.user = :user');
                }

                $queryBuilder->setParameter('user', $user);
            }
        }
    }
}
