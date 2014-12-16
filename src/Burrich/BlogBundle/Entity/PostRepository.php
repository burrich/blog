<?php

namespace Burrich\BlogBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends EntityRepository
{
	public function getPosts($page, $postsPerPage)
	{
		$query = $this->createQueryBuilder('p')
			->innerJoin('p.author', 'a')
			->leftJoin('p.comments', 'c')
			->addSelect('a')
			->addSelect('c')
			->orderBy('p.publishedDate', 'DESC')
			->orderBy('p.title', 'DESC') // TODO a supprimer
			->getQuery();

		$query
			->setFirstResult(($page - 1) * $postsPerPage)
			->setMaxResults($postsPerPage)
		;

		return new Paginator($query, $fetchJoinCollection = true);
	}
}
