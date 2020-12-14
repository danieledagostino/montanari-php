<?php

namespace Montanari\Propel\Base;

use \Exception;
use \PDO;
use Montanari\Propel\Drivers as ChildDrivers;
use Montanari\Propel\DriversQuery as ChildDriversQuery;
use Montanari\Propel\Map\DriversTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'drivers' table.
 *
 *
 *
 * @method     ChildDriversQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildDriversQuery orderByIdUser($order = Criteria::ASC) Order by the id_user column
 * @method     ChildDriversQuery orderByInsertDate($order = Criteria::ASC) Order by the insert_date column
 * @method     ChildDriversQuery orderByIdEvent($order = Criteria::ASC) Order by the id_event column
 * @method     ChildDriversQuery orderByRoad($order = Criteria::ASC) Order by the road column
 * @method     ChildDriversQuery orderBySeatsNumber($order = Criteria::ASC) Order by the seats_number column
 *
 * @method     ChildDriversQuery groupById() Group by the id column
 * @method     ChildDriversQuery groupByIdUser() Group by the id_user column
 * @method     ChildDriversQuery groupByInsertDate() Group by the insert_date column
 * @method     ChildDriversQuery groupByIdEvent() Group by the id_event column
 * @method     ChildDriversQuery groupByRoad() Group by the road column
 * @method     ChildDriversQuery groupBySeatsNumber() Group by the seats_number column
 *
 * @method     ChildDriversQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDriversQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDriversQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDriversQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildDriversQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildDriversQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildDriversQuery leftJoinUsers($relationAlias = null) Adds a LEFT JOIN clause to the query using the Users relation
 * @method     ChildDriversQuery rightJoinUsers($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Users relation
 * @method     ChildDriversQuery innerJoinUsers($relationAlias = null) Adds a INNER JOIN clause to the query using the Users relation
 *
 * @method     ChildDriversQuery joinWithUsers($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Users relation
 *
 * @method     ChildDriversQuery leftJoinWithUsers() Adds a LEFT JOIN clause and with to the query using the Users relation
 * @method     ChildDriversQuery rightJoinWithUsers() Adds a RIGHT JOIN clause and with to the query using the Users relation
 * @method     ChildDriversQuery innerJoinWithUsers() Adds a INNER JOIN clause and with to the query using the Users relation
 *
 * @method     ChildDriversQuery leftJoinEvents($relationAlias = null) Adds a LEFT JOIN clause to the query using the Events relation
 * @method     ChildDriversQuery rightJoinEvents($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Events relation
 * @method     ChildDriversQuery innerJoinEvents($relationAlias = null) Adds a INNER JOIN clause to the query using the Events relation
 *
 * @method     ChildDriversQuery joinWithEvents($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Events relation
 *
 * @method     ChildDriversQuery leftJoinWithEvents() Adds a LEFT JOIN clause and with to the query using the Events relation
 * @method     ChildDriversQuery rightJoinWithEvents() Adds a RIGHT JOIN clause and with to the query using the Events relation
 * @method     ChildDriversQuery innerJoinWithEvents() Adds a INNER JOIN clause and with to the query using the Events relation
 *
 * @method     ChildDriversQuery leftJoinCarOrganization($relationAlias = null) Adds a LEFT JOIN clause to the query using the CarOrganization relation
 * @method     ChildDriversQuery rightJoinCarOrganization($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CarOrganization relation
 * @method     ChildDriversQuery innerJoinCarOrganization($relationAlias = null) Adds a INNER JOIN clause to the query using the CarOrganization relation
 *
 * @method     ChildDriversQuery joinWithCarOrganization($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the CarOrganization relation
 *
 * @method     ChildDriversQuery leftJoinWithCarOrganization() Adds a LEFT JOIN clause and with to the query using the CarOrganization relation
 * @method     ChildDriversQuery rightJoinWithCarOrganization() Adds a RIGHT JOIN clause and with to the query using the CarOrganization relation
 * @method     ChildDriversQuery innerJoinWithCarOrganization() Adds a INNER JOIN clause and with to the query using the CarOrganization relation
 *
 * @method     \Montanari\Propel\UsersQuery|\Montanari\Propel\EventsQuery|\Montanari\Propel\CarOrganizationQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildDrivers findOne(ConnectionInterface $con = null) Return the first ChildDrivers matching the query
 * @method     ChildDrivers findOneOrCreate(ConnectionInterface $con = null) Return the first ChildDrivers matching the query, or a new ChildDrivers object populated from the query conditions when no match is found
 *
 * @method     ChildDrivers findOneById(string $id) Return the first ChildDrivers filtered by the id column
 * @method     ChildDrivers findOneByIdUser(int $id_user) Return the first ChildDrivers filtered by the id_user column
 * @method     ChildDrivers findOneByInsertDate(string $insert_date) Return the first ChildDrivers filtered by the insert_date column
 * @method     ChildDrivers findOneByIdEvent(string $id_event) Return the first ChildDrivers filtered by the id_event column
 * @method     ChildDrivers findOneByRoad(string $road) Return the first ChildDrivers filtered by the road column
 * @method     ChildDrivers findOneBySeatsNumber(int $seats_number) Return the first ChildDrivers filtered by the seats_number column *

 * @method     ChildDrivers requirePk($key, ConnectionInterface $con = null) Return the ChildDrivers by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDrivers requireOne(ConnectionInterface $con = null) Return the first ChildDrivers matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDrivers requireOneById(string $id) Return the first ChildDrivers filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDrivers requireOneByIdUser(int $id_user) Return the first ChildDrivers filtered by the id_user column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDrivers requireOneByInsertDate(string $insert_date) Return the first ChildDrivers filtered by the insert_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDrivers requireOneByIdEvent(string $id_event) Return the first ChildDrivers filtered by the id_event column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDrivers requireOneByRoad(string $road) Return the first ChildDrivers filtered by the road column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDrivers requireOneBySeatsNumber(int $seats_number) Return the first ChildDrivers filtered by the seats_number column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDrivers[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildDrivers objects based on current ModelCriteria
 * @method     ChildDrivers[]|ObjectCollection findById(string $id) Return ChildDrivers objects filtered by the id column
 * @method     ChildDrivers[]|ObjectCollection findByIdUser(int $id_user) Return ChildDrivers objects filtered by the id_user column
 * @method     ChildDrivers[]|ObjectCollection findByInsertDate(string $insert_date) Return ChildDrivers objects filtered by the insert_date column
 * @method     ChildDrivers[]|ObjectCollection findByIdEvent(string $id_event) Return ChildDrivers objects filtered by the id_event column
 * @method     ChildDrivers[]|ObjectCollection findByRoad(string $road) Return ChildDrivers objects filtered by the road column
 * @method     ChildDrivers[]|ObjectCollection findBySeatsNumber(int $seats_number) Return ChildDrivers objects filtered by the seats_number column
 * @method     ChildDrivers[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class DriversQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Montanari\Propel\Base\DriversQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Montanari\\Propel\\Drivers', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDriversQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDriversQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildDriversQuery) {
            return $criteria;
        }
        $query = new ChildDriversQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildDrivers|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DriversTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = DriversTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDrivers A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, id_user, insert_date, id_event, road, seats_number FROM drivers WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildDrivers $obj */
            $obj = new ChildDrivers();
            $obj->hydrate($row);
            DriversTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildDrivers|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildDriversQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(DriversTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildDriversQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(DriversTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDriversQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(DriversTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(DriversTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DriversTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the id_user column
     *
     * Example usage:
     * <code>
     * $query->filterByIdUser(1234); // WHERE id_user = 1234
     * $query->filterByIdUser(array(12, 34)); // WHERE id_user IN (12, 34)
     * $query->filterByIdUser(array('min' => 12)); // WHERE id_user > 12
     * </code>
     *
     * @see       filterByUsers()
     *
     * @param     mixed $idUser The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDriversQuery The current query, for fluid interface
     */
    public function filterByIdUser($idUser = null, $comparison = null)
    {
        if (is_array($idUser)) {
            $useMinMax = false;
            if (isset($idUser['min'])) {
                $this->addUsingAlias(DriversTableMap::COL_ID_USER, $idUser['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idUser['max'])) {
                $this->addUsingAlias(DriversTableMap::COL_ID_USER, $idUser['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DriversTableMap::COL_ID_USER, $idUser, $comparison);
    }

    /**
     * Filter the query on the insert_date column
     *
     * Example usage:
     * <code>
     * $query->filterByInsertDate('2011-03-14'); // WHERE insert_date = '2011-03-14'
     * $query->filterByInsertDate('now'); // WHERE insert_date = '2011-03-14'
     * $query->filterByInsertDate(array('max' => 'yesterday')); // WHERE insert_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $insertDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDriversQuery The current query, for fluid interface
     */
    public function filterByInsertDate($insertDate = null, $comparison = null)
    {
        if (is_array($insertDate)) {
            $useMinMax = false;
            if (isset($insertDate['min'])) {
                $this->addUsingAlias(DriversTableMap::COL_INSERT_DATE, $insertDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($insertDate['max'])) {
                $this->addUsingAlias(DriversTableMap::COL_INSERT_DATE, $insertDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DriversTableMap::COL_INSERT_DATE, $insertDate, $comparison);
    }

    /**
     * Filter the query on the id_event column
     *
     * Example usage:
     * <code>
     * $query->filterByIdEvent('fooValue');   // WHERE id_event = 'fooValue'
     * $query->filterByIdEvent('%fooValue%', Criteria::LIKE); // WHERE id_event LIKE '%fooValue%'
     * </code>
     *
     * @param     string $idEvent The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDriversQuery The current query, for fluid interface
     */
    public function filterByIdEvent($idEvent = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($idEvent)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DriversTableMap::COL_ID_EVENT, $idEvent, $comparison);
    }

    /**
     * Filter the query on the road column
     *
     * Example usage:
     * <code>
     * $query->filterByRoad('fooValue');   // WHERE road = 'fooValue'
     * $query->filterByRoad('%fooValue%', Criteria::LIKE); // WHERE road LIKE '%fooValue%'
     * </code>
     *
     * @param     string $road The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDriversQuery The current query, for fluid interface
     */
    public function filterByRoad($road = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($road)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DriversTableMap::COL_ROAD, $road, $comparison);
    }

    /**
     * Filter the query on the seats_number column
     *
     * Example usage:
     * <code>
     * $query->filterBySeatsNumber(1234); // WHERE seats_number = 1234
     * $query->filterBySeatsNumber(array(12, 34)); // WHERE seats_number IN (12, 34)
     * $query->filterBySeatsNumber(array('min' => 12)); // WHERE seats_number > 12
     * </code>
     *
     * @param     mixed $seatsNumber The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDriversQuery The current query, for fluid interface
     */
    public function filterBySeatsNumber($seatsNumber = null, $comparison = null)
    {
        if (is_array($seatsNumber)) {
            $useMinMax = false;
            if (isset($seatsNumber['min'])) {
                $this->addUsingAlias(DriversTableMap::COL_SEATS_NUMBER, $seatsNumber['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($seatsNumber['max'])) {
                $this->addUsingAlias(DriversTableMap::COL_SEATS_NUMBER, $seatsNumber['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DriversTableMap::COL_SEATS_NUMBER, $seatsNumber, $comparison);
    }

    /**
     * Filter the query by a related \Montanari\Propel\Users object
     *
     * @param \Montanari\Propel\Users|ObjectCollection $users The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDriversQuery The current query, for fluid interface
     */
    public function filterByUsers($users, $comparison = null)
    {
        if ($users instanceof \Montanari\Propel\Users) {
            return $this
                ->addUsingAlias(DriversTableMap::COL_ID_USER, $users->getId(), $comparison);
        } elseif ($users instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DriversTableMap::COL_ID_USER, $users->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByUsers() only accepts arguments of type \Montanari\Propel\Users or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Users relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDriversQuery The current query, for fluid interface
     */
    public function joinUsers($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Users');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Users');
        }

        return $this;
    }

    /**
     * Use the Users relation Users object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Montanari\Propel\UsersQuery A secondary query class using the current class as primary query
     */
    public function useUsersQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUsers($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Users', '\Montanari\Propel\UsersQuery');
    }

    /**
     * Filter the query by a related \Montanari\Propel\Events object
     *
     * @param \Montanari\Propel\Events|ObjectCollection $events The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDriversQuery The current query, for fluid interface
     */
    public function filterByEvents($events, $comparison = null)
    {
        if ($events instanceof \Montanari\Propel\Events) {
            return $this
                ->addUsingAlias(DriversTableMap::COL_ID_EVENT, $events->getId(), $comparison);
        } elseif ($events instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DriversTableMap::COL_ID_EVENT, $events->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByEvents() only accepts arguments of type \Montanari\Propel\Events or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Events relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDriversQuery The current query, for fluid interface
     */
    public function joinEvents($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Events');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Events');
        }

        return $this;
    }

    /**
     * Use the Events relation Events object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Montanari\Propel\EventsQuery A secondary query class using the current class as primary query
     */
    public function useEventsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinEvents($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Events', '\Montanari\Propel\EventsQuery');
    }

    /**
     * Filter the query by a related \Montanari\Propel\CarOrganization object
     *
     * @param \Montanari\Propel\CarOrganization|ObjectCollection $carOrganization the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDriversQuery The current query, for fluid interface
     */
    public function filterByCarOrganization($carOrganization, $comparison = null)
    {
        if ($carOrganization instanceof \Montanari\Propel\CarOrganization) {
            return $this
                ->addUsingAlias(DriversTableMap::COL_ID, $carOrganization->getIdDriver(), $comparison);
        } elseif ($carOrganization instanceof ObjectCollection) {
            return $this
                ->useCarOrganizationQuery()
                ->filterByPrimaryKeys($carOrganization->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCarOrganization() only accepts arguments of type \Montanari\Propel\CarOrganization or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CarOrganization relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDriversQuery The current query, for fluid interface
     */
    public function joinCarOrganization($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CarOrganization');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'CarOrganization');
        }

        return $this;
    }

    /**
     * Use the CarOrganization relation CarOrganization object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Montanari\Propel\CarOrganizationQuery A secondary query class using the current class as primary query
     */
    public function useCarOrganizationQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCarOrganization($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CarOrganization', '\Montanari\Propel\CarOrganizationQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildDrivers $drivers Object to remove from the list of results
     *
     * @return $this|ChildDriversQuery The current query, for fluid interface
     */
    public function prune($drivers = null)
    {
        if ($drivers) {
            $this->addUsingAlias(DriversTableMap::COL_ID, $drivers->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the drivers table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DriversTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DriversTableMap::clearInstancePool();
            DriversTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DriversTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DriversTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            DriversTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            DriversTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // DriversQuery
