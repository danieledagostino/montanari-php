<?php

namespace Montanari\Propel\Base;

use \Exception;
use \PDO;
use Montanari\Propel\Events as ChildEvents;
use Montanari\Propel\EventsQuery as ChildEventsQuery;
use Montanari\Propel\Map\EventsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'events' table.
 *
 *
 *
 * @method     ChildEventsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildEventsQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildEventsQuery orderByMeetingPoint($order = Criteria::ASC) Order by the meeting_point column
 * @method     ChildEventsQuery orderByDepartureCoords($order = Criteria::ASC) Order by the departure_coords column
 * @method     ChildEventsQuery orderByEventDate($order = Criteria::ASC) Order by the event_date column
 * @method     ChildEventsQuery orderByInsertDate($order = Criteria::ASC) Order by the insert_date column
 * @method     ChildEventsQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildEventsQuery orderByMeetingPointName($order = Criteria::ASC) Order by the meeting_point_name column
 * @method     ChildEventsQuery orderByIdFb($order = Criteria::ASC) Order by the id_fb column
 * @method     ChildEventsQuery orderByUpdateDate($order = Criteria::ASC) Order by the update_date column
 *
 * @method     ChildEventsQuery groupById() Group by the id column
 * @method     ChildEventsQuery groupByDescription() Group by the description column
 * @method     ChildEventsQuery groupByMeetingPoint() Group by the meeting_point column
 * @method     ChildEventsQuery groupByDepartureCoords() Group by the departure_coords column
 * @method     ChildEventsQuery groupByEventDate() Group by the event_date column
 * @method     ChildEventsQuery groupByInsertDate() Group by the insert_date column
 * @method     ChildEventsQuery groupByName() Group by the name column
 * @method     ChildEventsQuery groupByMeetingPointName() Group by the meeting_point_name column
 * @method     ChildEventsQuery groupByIdFb() Group by the id_fb column
 * @method     ChildEventsQuery groupByUpdateDate() Group by the update_date column
 *
 * @method     ChildEventsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildEventsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildEventsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildEventsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildEventsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildEventsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildEventsQuery leftJoinCarOrganization($relationAlias = null) Adds a LEFT JOIN clause to the query using the CarOrganization relation
 * @method     ChildEventsQuery rightJoinCarOrganization($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CarOrganization relation
 * @method     ChildEventsQuery innerJoinCarOrganization($relationAlias = null) Adds a INNER JOIN clause to the query using the CarOrganization relation
 *
 * @method     ChildEventsQuery joinWithCarOrganization($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the CarOrganization relation
 *
 * @method     ChildEventsQuery leftJoinWithCarOrganization() Adds a LEFT JOIN clause and with to the query using the CarOrganization relation
 * @method     ChildEventsQuery rightJoinWithCarOrganization() Adds a RIGHT JOIN clause and with to the query using the CarOrganization relation
 * @method     ChildEventsQuery innerJoinWithCarOrganization() Adds a INNER JOIN clause and with to the query using the CarOrganization relation
 *
 * @method     ChildEventsQuery leftJoinDrivers($relationAlias = null) Adds a LEFT JOIN clause to the query using the Drivers relation
 * @method     ChildEventsQuery rightJoinDrivers($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Drivers relation
 * @method     ChildEventsQuery innerJoinDrivers($relationAlias = null) Adds a INNER JOIN clause to the query using the Drivers relation
 *
 * @method     ChildEventsQuery joinWithDrivers($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Drivers relation
 *
 * @method     ChildEventsQuery leftJoinWithDrivers() Adds a LEFT JOIN clause and with to the query using the Drivers relation
 * @method     ChildEventsQuery rightJoinWithDrivers() Adds a RIGHT JOIN clause and with to the query using the Drivers relation
 * @method     ChildEventsQuery innerJoinWithDrivers() Adds a INNER JOIN clause and with to the query using the Drivers relation
 *
 * @method     ChildEventsQuery leftJoinPassengers($relationAlias = null) Adds a LEFT JOIN clause to the query using the Passengers relation
 * @method     ChildEventsQuery rightJoinPassengers($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Passengers relation
 * @method     ChildEventsQuery innerJoinPassengers($relationAlias = null) Adds a INNER JOIN clause to the query using the Passengers relation
 *
 * @method     ChildEventsQuery joinWithPassengers($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Passengers relation
 *
 * @method     ChildEventsQuery leftJoinWithPassengers() Adds a LEFT JOIN clause and with to the query using the Passengers relation
 * @method     ChildEventsQuery rightJoinWithPassengers() Adds a RIGHT JOIN clause and with to the query using the Passengers relation
 * @method     ChildEventsQuery innerJoinWithPassengers() Adds a INNER JOIN clause and with to the query using the Passengers relation
 *
 * @method     \Montanari\Propel\CarOrganizationQuery|\Montanari\Propel\DriversQuery|\Montanari\Propel\PassengersQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildEvents findOne(ConnectionInterface $con = null) Return the first ChildEvents matching the query
 * @method     ChildEvents findOneOrCreate(ConnectionInterface $con = null) Return the first ChildEvents matching the query, or a new ChildEvents object populated from the query conditions when no match is found
 *
 * @method     ChildEvents findOneById(string $id) Return the first ChildEvents filtered by the id column
 * @method     ChildEvents findOneByDescription(string $description) Return the first ChildEvents filtered by the description column
 * @method     ChildEvents findOneByMeetingPoint(string $meeting_point) Return the first ChildEvents filtered by the meeting_point column
 * @method     ChildEvents findOneByDepartureCoords(string $departure_coords) Return the first ChildEvents filtered by the departure_coords column
 * @method     ChildEvents findOneByEventDate(string $event_date) Return the first ChildEvents filtered by the event_date column
 * @method     ChildEvents findOneByInsertDate(string $insert_date) Return the first ChildEvents filtered by the insert_date column
 * @method     ChildEvents findOneByName(string $name) Return the first ChildEvents filtered by the name column
 * @method     ChildEvents findOneByMeetingPointName(string $meeting_point_name) Return the first ChildEvents filtered by the meeting_point_name column
 * @method     ChildEvents findOneByIdFb(string $id_fb) Return the first ChildEvents filtered by the id_fb column
 * @method     ChildEvents findOneByUpdateDate(string $update_date) Return the first ChildEvents filtered by the update_date column *

 * @method     ChildEvents requirePk($key, ConnectionInterface $con = null) Return the ChildEvents by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvents requireOne(ConnectionInterface $con = null) Return the first ChildEvents matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildEvents requireOneById(string $id) Return the first ChildEvents filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvents requireOneByDescription(string $description) Return the first ChildEvents filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvents requireOneByMeetingPoint(string $meeting_point) Return the first ChildEvents filtered by the meeting_point column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvents requireOneByDepartureCoords(string $departure_coords) Return the first ChildEvents filtered by the departure_coords column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvents requireOneByEventDate(string $event_date) Return the first ChildEvents filtered by the event_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvents requireOneByInsertDate(string $insert_date) Return the first ChildEvents filtered by the insert_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvents requireOneByName(string $name) Return the first ChildEvents filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvents requireOneByMeetingPointName(string $meeting_point_name) Return the first ChildEvents filtered by the meeting_point_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvents requireOneByIdFb(string $id_fb) Return the first ChildEvents filtered by the id_fb column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvents requireOneByUpdateDate(string $update_date) Return the first ChildEvents filtered by the update_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildEvents[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildEvents objects based on current ModelCriteria
 * @method     ChildEvents[]|ObjectCollection findById(string $id) Return ChildEvents objects filtered by the id column
 * @method     ChildEvents[]|ObjectCollection findByDescription(string $description) Return ChildEvents objects filtered by the description column
 * @method     ChildEvents[]|ObjectCollection findByMeetingPoint(string $meeting_point) Return ChildEvents objects filtered by the meeting_point column
 * @method     ChildEvents[]|ObjectCollection findByDepartureCoords(string $departure_coords) Return ChildEvents objects filtered by the departure_coords column
 * @method     ChildEvents[]|ObjectCollection findByEventDate(string $event_date) Return ChildEvents objects filtered by the event_date column
 * @method     ChildEvents[]|ObjectCollection findByInsertDate(string $insert_date) Return ChildEvents objects filtered by the insert_date column
 * @method     ChildEvents[]|ObjectCollection findByName(string $name) Return ChildEvents objects filtered by the name column
 * @method     ChildEvents[]|ObjectCollection findByMeetingPointName(string $meeting_point_name) Return ChildEvents objects filtered by the meeting_point_name column
 * @method     ChildEvents[]|ObjectCollection findByIdFb(string $id_fb) Return ChildEvents objects filtered by the id_fb column
 * @method     ChildEvents[]|ObjectCollection findByUpdateDate(string $update_date) Return ChildEvents objects filtered by the update_date column
 * @method     ChildEvents[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class EventsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Montanari\Propel\Base\EventsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Montanari\\Propel\\Events', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildEventsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildEventsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildEventsQuery) {
            return $criteria;
        }
        $query = new ChildEventsQuery();
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
     * @return ChildEvents|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(EventsTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = EventsTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildEvents A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, description, meeting_point, departure_coords, event_date, insert_date, name, meeting_point_name, id_fb, update_date FROM events WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildEvents $obj */
            $obj = new ChildEvents();
            $obj->hydrate($row);
            EventsTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildEvents|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildEventsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(EventsTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildEventsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(EventsTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById('fooValue');   // WHERE id = 'fooValue'
     * $query->filterById('%fooValue%', Criteria::LIKE); // WHERE id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $id The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEventsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($id)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EventsTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%', Criteria::LIKE); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEventsQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EventsTableMap::COL_DESCRIPTION, $description, $comparison);
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
     * @return $this|ChildEventsQuery The current query, for fluid interface
     */
    public function filterByMeetingPoint($meetingPoint = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($meetingPoint)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EventsTableMap::COL_MEETING_POINT, $meetingPoint, $comparison);
    }

    /**
     * Filter the query on the departure_coords column
     *
     * Example usage:
     * <code>
     * $query->filterByDepartureCoords('fooValue');   // WHERE departure_coords = 'fooValue'
     * $query->filterByDepartureCoords('%fooValue%', Criteria::LIKE); // WHERE departure_coords LIKE '%fooValue%'
     * </code>
     *
     * @param     string $departureCoords The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEventsQuery The current query, for fluid interface
     */
    public function filterByDepartureCoords($departureCoords = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($departureCoords)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EventsTableMap::COL_DEPARTURE_COORDS, $departureCoords, $comparison);
    }

    /**
     * Filter the query on the event_date column
     *
     * Example usage:
     * <code>
     * $query->filterByEventDate('2011-03-14'); // WHERE event_date = '2011-03-14'
     * $query->filterByEventDate('now'); // WHERE event_date = '2011-03-14'
     * $query->filterByEventDate(array('max' => 'yesterday')); // WHERE event_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $eventDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEventsQuery The current query, for fluid interface
     */
    public function filterByEventDate($eventDate = null, $comparison = null)
    {
        if (is_array($eventDate)) {
            $useMinMax = false;
            if (isset($eventDate['min'])) {
                $this->addUsingAlias(EventsTableMap::COL_EVENT_DATE, $eventDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($eventDate['max'])) {
                $this->addUsingAlias(EventsTableMap::COL_EVENT_DATE, $eventDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EventsTableMap::COL_EVENT_DATE, $eventDate, $comparison);
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
     * @return $this|ChildEventsQuery The current query, for fluid interface
     */
    public function filterByInsertDate($insertDate = null, $comparison = null)
    {
        if (is_array($insertDate)) {
            $useMinMax = false;
            if (isset($insertDate['min'])) {
                $this->addUsingAlias(EventsTableMap::COL_INSERT_DATE, $insertDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($insertDate['max'])) {
                $this->addUsingAlias(EventsTableMap::COL_INSERT_DATE, $insertDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EventsTableMap::COL_INSERT_DATE, $insertDate, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEventsQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EventsTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the meeting_point_name column
     *
     * Example usage:
     * <code>
     * $query->filterByMeetingPointName('fooValue');   // WHERE meeting_point_name = 'fooValue'
     * $query->filterByMeetingPointName('%fooValue%', Criteria::LIKE); // WHERE meeting_point_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $meetingPointName The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEventsQuery The current query, for fluid interface
     */
    public function filterByMeetingPointName($meetingPointName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($meetingPointName)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EventsTableMap::COL_MEETING_POINT_NAME, $meetingPointName, $comparison);
    }

    /**
     * Filter the query on the id_fb column
     *
     * Example usage:
     * <code>
     * $query->filterByIdFb('fooValue');   // WHERE id_fb = 'fooValue'
     * $query->filterByIdFb('%fooValue%', Criteria::LIKE); // WHERE id_fb LIKE '%fooValue%'
     * </code>
     *
     * @param     string $idFb The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEventsQuery The current query, for fluid interface
     */
    public function filterByIdFb($idFb = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($idFb)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EventsTableMap::COL_ID_FB, $idFb, $comparison);
    }

    /**
     * Filter the query on the update_date column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdateDate('2011-03-14'); // WHERE update_date = '2011-03-14'
     * $query->filterByUpdateDate('now'); // WHERE update_date = '2011-03-14'
     * $query->filterByUpdateDate(array('max' => 'yesterday')); // WHERE update_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $updateDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEventsQuery The current query, for fluid interface
     */
    public function filterByUpdateDate($updateDate = null, $comparison = null)
    {
        if (is_array($updateDate)) {
            $useMinMax = false;
            if (isset($updateDate['min'])) {
                $this->addUsingAlias(EventsTableMap::COL_UPDATE_DATE, $updateDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updateDate['max'])) {
                $this->addUsingAlias(EventsTableMap::COL_UPDATE_DATE, $updateDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EventsTableMap::COL_UPDATE_DATE, $updateDate, $comparison);
    }

    /**
     * Filter the query by a related \Montanari\Propel\CarOrganization object
     *
     * @param \Montanari\Propel\CarOrganization|ObjectCollection $carOrganization the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildEventsQuery The current query, for fluid interface
     */
    public function filterByCarOrganization($carOrganization, $comparison = null)
    {
        if ($carOrganization instanceof \Montanari\Propel\CarOrganization) {
            return $this
                ->addUsingAlias(EventsTableMap::COL_ID, $carOrganization->getIdEvent(), $comparison);
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
     * @return $this|ChildEventsQuery The current query, for fluid interface
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
     * Filter the query by a related \Montanari\Propel\Drivers object
     *
     * @param \Montanari\Propel\Drivers|ObjectCollection $drivers the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildEventsQuery The current query, for fluid interface
     */
    public function filterByDrivers($drivers, $comparison = null)
    {
        if ($drivers instanceof \Montanari\Propel\Drivers) {
            return $this
                ->addUsingAlias(EventsTableMap::COL_ID, $drivers->getIdEvent(), $comparison);
        } elseif ($drivers instanceof ObjectCollection) {
            return $this
                ->useDriversQuery()
                ->filterByPrimaryKeys($drivers->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDrivers() only accepts arguments of type \Montanari\Propel\Drivers or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Drivers relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildEventsQuery The current query, for fluid interface
     */
    public function joinDrivers($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Drivers');

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
            $this->addJoinObject($join, 'Drivers');
        }

        return $this;
    }

    /**
     * Use the Drivers relation Drivers object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Montanari\Propel\DriversQuery A secondary query class using the current class as primary query
     */
    public function useDriversQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDrivers($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Drivers', '\Montanari\Propel\DriversQuery');
    }

    /**
     * Filter the query by a related \Montanari\Propel\Passengers object
     *
     * @param \Montanari\Propel\Passengers|ObjectCollection $passengers the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildEventsQuery The current query, for fluid interface
     */
    public function filterByPassengers($passengers, $comparison = null)
    {
        if ($passengers instanceof \Montanari\Propel\Passengers) {
            return $this
                ->addUsingAlias(EventsTableMap::COL_ID, $passengers->getIdEvent(), $comparison);
        } elseif ($passengers instanceof ObjectCollection) {
            return $this
                ->usePassengersQuery()
                ->filterByPrimaryKeys($passengers->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPassengers() only accepts arguments of type \Montanari\Propel\Passengers or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Passengers relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildEventsQuery The current query, for fluid interface
     */
    public function joinPassengers($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Passengers');

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
            $this->addJoinObject($join, 'Passengers');
        }

        return $this;
    }

    /**
     * Use the Passengers relation Passengers object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Montanari\Propel\PassengersQuery A secondary query class using the current class as primary query
     */
    public function usePassengersQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPassengers($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Passengers', '\Montanari\Propel\PassengersQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildEvents $events Object to remove from the list of results
     *
     * @return $this|ChildEventsQuery The current query, for fluid interface
     */
    public function prune($events = null)
    {
        if ($events) {
            $this->addUsingAlias(EventsTableMap::COL_ID, $events->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the events table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(EventsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            EventsTableMap::clearInstancePool();
            EventsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(EventsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(EventsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            EventsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            EventsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildEventsQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(EventsTableMap::COL_UPDATE_DATE, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildEventsQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(EventsTableMap::COL_UPDATE_DATE);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildEventsQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(EventsTableMap::COL_UPDATE_DATE);
    }

} // EventsQuery
