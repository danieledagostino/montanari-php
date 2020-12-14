<?php

namespace Montanari\Propel\Base;

use \Exception;
use \PDO;
use Montanari\Propel\Passengers as ChildPassengers;
use Montanari\Propel\PassengersQuery as ChildPassengersQuery;
use Montanari\Propel\Map\PassengersTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'passengers' table.
 *
 *
 *
 * @method     ChildPassengersQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPassengersQuery orderByIdUser($order = Criteria::ASC) Order by the id_user column
 * @method     ChildPassengersQuery orderByInsertDate($order = Criteria::ASC) Order by the insert_date column
 * @method     ChildPassengersQuery orderByIdEvent($order = Criteria::ASC) Order by the id_event column
 * @method     ChildPassengersQuery orderByMeetingPoint($order = Criteria::ASC) Order by the meeting_point column
 *
 * @method     ChildPassengersQuery groupById() Group by the id column
 * @method     ChildPassengersQuery groupByIdUser() Group by the id_user column
 * @method     ChildPassengersQuery groupByInsertDate() Group by the insert_date column
 * @method     ChildPassengersQuery groupByIdEvent() Group by the id_event column
 * @method     ChildPassengersQuery groupByMeetingPoint() Group by the meeting_point column
 *
 * @method     ChildPassengersQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPassengersQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPassengersQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPassengersQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPassengersQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPassengersQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPassengersQuery leftJoinUsers($relationAlias = null) Adds a LEFT JOIN clause to the query using the Users relation
 * @method     ChildPassengersQuery rightJoinUsers($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Users relation
 * @method     ChildPassengersQuery innerJoinUsers($relationAlias = null) Adds a INNER JOIN clause to the query using the Users relation
 *
 * @method     ChildPassengersQuery joinWithUsers($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Users relation
 *
 * @method     ChildPassengersQuery leftJoinWithUsers() Adds a LEFT JOIN clause and with to the query using the Users relation
 * @method     ChildPassengersQuery rightJoinWithUsers() Adds a RIGHT JOIN clause and with to the query using the Users relation
 * @method     ChildPassengersQuery innerJoinWithUsers() Adds a INNER JOIN clause and with to the query using the Users relation
 *
 * @method     ChildPassengersQuery leftJoinEvents($relationAlias = null) Adds a LEFT JOIN clause to the query using the Events relation
 * @method     ChildPassengersQuery rightJoinEvents($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Events relation
 * @method     ChildPassengersQuery innerJoinEvents($relationAlias = null) Adds a INNER JOIN clause to the query using the Events relation
 *
 * @method     ChildPassengersQuery joinWithEvents($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Events relation
 *
 * @method     ChildPassengersQuery leftJoinWithEvents() Adds a LEFT JOIN clause and with to the query using the Events relation
 * @method     ChildPassengersQuery rightJoinWithEvents() Adds a RIGHT JOIN clause and with to the query using the Events relation
 * @method     ChildPassengersQuery innerJoinWithEvents() Adds a INNER JOIN clause and with to the query using the Events relation
 *
 * @method     ChildPassengersQuery leftJoinCarOrganization($relationAlias = null) Adds a LEFT JOIN clause to the query using the CarOrganization relation
 * @method     ChildPassengersQuery rightJoinCarOrganization($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CarOrganization relation
 * @method     ChildPassengersQuery innerJoinCarOrganization($relationAlias = null) Adds a INNER JOIN clause to the query using the CarOrganization relation
 *
 * @method     ChildPassengersQuery joinWithCarOrganization($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the CarOrganization relation
 *
 * @method     ChildPassengersQuery leftJoinWithCarOrganization() Adds a LEFT JOIN clause and with to the query using the CarOrganization relation
 * @method     ChildPassengersQuery rightJoinWithCarOrganization() Adds a RIGHT JOIN clause and with to the query using the CarOrganization relation
 * @method     ChildPassengersQuery innerJoinWithCarOrganization() Adds a INNER JOIN clause and with to the query using the CarOrganization relation
 *
 * @method     \Montanari\Propel\UsersQuery|\Montanari\Propel\EventsQuery|\Montanari\Propel\CarOrganizationQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPassengers findOne(ConnectionInterface $con = null) Return the first ChildPassengers matching the query
 * @method     ChildPassengers findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPassengers matching the query, or a new ChildPassengers object populated from the query conditions when no match is found
 *
 * @method     ChildPassengers findOneById(string $id) Return the first ChildPassengers filtered by the id column
 * @method     ChildPassengers findOneByIdUser(int $id_user) Return the first ChildPassengers filtered by the id_user column
 * @method     ChildPassengers findOneByInsertDate(string $insert_date) Return the first ChildPassengers filtered by the insert_date column
 * @method     ChildPassengers findOneByIdEvent(string $id_event) Return the first ChildPassengers filtered by the id_event column
 * @method     ChildPassengers findOneByMeetingPoint(string $meeting_point) Return the first ChildPassengers filtered by the meeting_point column *

 * @method     ChildPassengers requirePk($key, ConnectionInterface $con = null) Return the ChildPassengers by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPassengers requireOne(ConnectionInterface $con = null) Return the first ChildPassengers matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPassengers requireOneById(string $id) Return the first ChildPassengers filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPassengers requireOneByIdUser(int $id_user) Return the first ChildPassengers filtered by the id_user column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPassengers requireOneByInsertDate(string $insert_date) Return the first ChildPassengers filtered by the insert_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPassengers requireOneByIdEvent(string $id_event) Return the first ChildPassengers filtered by the id_event column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPassengers requireOneByMeetingPoint(string $meeting_point) Return the first ChildPassengers filtered by the meeting_point column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPassengers[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPassengers objects based on current ModelCriteria
 * @method     ChildPassengers[]|ObjectCollection findById(string $id) Return ChildPassengers objects filtered by the id column
 * @method     ChildPassengers[]|ObjectCollection findByIdUser(int $id_user) Return ChildPassengers objects filtered by the id_user column
 * @method     ChildPassengers[]|ObjectCollection findByInsertDate(string $insert_date) Return ChildPassengers objects filtered by the insert_date column
 * @method     ChildPassengers[]|ObjectCollection findByIdEvent(string $id_event) Return ChildPassengers objects filtered by the id_event column
 * @method     ChildPassengers[]|ObjectCollection findByMeetingPoint(string $meeting_point) Return ChildPassengers objects filtered by the meeting_point column
 * @method     ChildPassengers[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PassengersQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Montanari\Propel\Base\PassengersQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Montanari\\Propel\\Passengers', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPassengersQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPassengersQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPassengersQuery) {
            return $criteria;
        }
        $query = new ChildPassengersQuery();
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
     * @return ChildPassengers|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PassengersTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = PassengersTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildPassengers A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, id_user, insert_date, id_event, meeting_point FROM passengers WHERE id = :p0';
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
            /** @var ChildPassengers $obj */
            $obj = new ChildPassengers();
            $obj->hydrate($row);
            PassengersTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildPassengers|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPassengersQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PassengersTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPassengersQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PassengersTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPassengersQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PassengersTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PassengersTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PassengersTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildPassengersQuery The current query, for fluid interface
     */
    public function filterByIdUser($idUser = null, $comparison = null)
    {
        if (is_array($idUser)) {
            $useMinMax = false;
            if (isset($idUser['min'])) {
                $this->addUsingAlias(PassengersTableMap::COL_ID_USER, $idUser['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idUser['max'])) {
                $this->addUsingAlias(PassengersTableMap::COL_ID_USER, $idUser['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PassengersTableMap::COL_ID_USER, $idUser, $comparison);
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
     * @return $this|ChildPassengersQuery The current query, for fluid interface
     */
    public function filterByInsertDate($insertDate = null, $comparison = null)
    {
        if (is_array($insertDate)) {
            $useMinMax = false;
            if (isset($insertDate['min'])) {
                $this->addUsingAlias(PassengersTableMap::COL_INSERT_DATE, $insertDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($insertDate['max'])) {
                $this->addUsingAlias(PassengersTableMap::COL_INSERT_DATE, $insertDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PassengersTableMap::COL_INSERT_DATE, $insertDate, $comparison);
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
     * @return $this|ChildPassengersQuery The current query, for fluid interface
     */
    public function filterByIdEvent($idEvent = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($idEvent)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PassengersTableMap::COL_ID_EVENT, $idEvent, $comparison);
    }

    /**
     * Filter the query on the meeting_point column
     *
     * Example usage:
     * <code>
     * $query->filterByMeetingPoint('fooValue');   // WHERE meeting_point = 'fooValue'
     * $query->filterByMeetingPoint('%fooValue%', Criteria::LIKE); // WHERE meeting_point LIKE '%fooValue%'
     * </code>
     *
     * @param     string $meetingPoint The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPassengersQuery The current query, for fluid interface
     */
    public function filterByMeetingPoint($meetingPoint = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($meetingPoint)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PassengersTableMap::COL_MEETING_POINT, $meetingPoint, $comparison);
    }

    /**
     * Filter the query by a related \Montanari\Propel\Users object
     *
     * @param \Montanari\Propel\Users|ObjectCollection $users The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPassengersQuery The current query, for fluid interface
     */
    public function filterByUsers($users, $comparison = null)
    {
        if ($users instanceof \Montanari\Propel\Users) {
            return $this
                ->addUsingAlias(PassengersTableMap::COL_ID_USER, $users->getId(), $comparison);
        } elseif ($users instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PassengersTableMap::COL_ID_USER, $users->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildPassengersQuery The current query, for fluid interface
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
     * @return ChildPassengersQuery The current query, for fluid interface
     */
    public function filterByEvents($events, $comparison = null)
    {
        if ($events instanceof \Montanari\Propel\Events) {
            return $this
                ->addUsingAlias(PassengersTableMap::COL_ID_EVENT, $events->getId(), $comparison);
        } elseif ($events instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PassengersTableMap::COL_ID_EVENT, $events->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildPassengersQuery The current query, for fluid interface
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
     * @return ChildPassengersQuery The current query, for fluid interface
     */
    public function filterByCarOrganization($carOrganization, $comparison = null)
    {
        if ($carOrganization instanceof \Montanari\Propel\CarOrganization) {
            return $this
                ->addUsingAlias(PassengersTableMap::COL_ID, $carOrganization->getIdPassenger(), $comparison);
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
     * @return $this|ChildPassengersQuery The current query, for fluid interface
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
     * @param   ChildPassengers $passengers Object to remove from the list of results
     *
     * @return $this|ChildPassengersQuery The current query, for fluid interface
     */
    public function prune($passengers = null)
    {
        if ($passengers) {
            $this->addUsingAlias(PassengersTableMap::COL_ID, $passengers->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the passengers table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PassengersTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PassengersTableMap::clearInstancePool();
            PassengersTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PassengersTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PassengersTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PassengersTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PassengersTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PassengersQuery
