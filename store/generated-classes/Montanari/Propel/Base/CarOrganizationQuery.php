<?php

namespace Montanari\Propel\Base;

use \Exception;
use \PDO;
use Montanari\Propel\CarOrganization as ChildCarOrganization;
use Montanari\Propel\CarOrganizationQuery as ChildCarOrganizationQuery;
use Montanari\Propel\Map\CarOrganizationTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'car_organization' table.
 *
 *
 *
 * @method     ChildCarOrganizationQuery orderByIdDriver($order = Criteria::ASC) Order by the id_driver column
 * @method     ChildCarOrganizationQuery orderByIdPassenger($order = Criteria::ASC) Order by the id_passenger column
 * @method     ChildCarOrganizationQuery orderByIdEvent($order = Criteria::ASC) Order by the id_event column
 * @method     ChildCarOrganizationQuery orderByConfirmed($order = Criteria::ASC) Order by the confirmed column
 * @method     ChildCarOrganizationQuery orderByConfirmCode($order = Criteria::ASC) Order by the confirm_code column
 * @method     ChildCarOrganizationQuery orderByInsertDate($order = Criteria::ASC) Order by the insert_date column
 *
 * @method     ChildCarOrganizationQuery groupByIdDriver() Group by the id_driver column
 * @method     ChildCarOrganizationQuery groupByIdPassenger() Group by the id_passenger column
 * @method     ChildCarOrganizationQuery groupByIdEvent() Group by the id_event column
 * @method     ChildCarOrganizationQuery groupByConfirmed() Group by the confirmed column
 * @method     ChildCarOrganizationQuery groupByConfirmCode() Group by the confirm_code column
 * @method     ChildCarOrganizationQuery groupByInsertDate() Group by the insert_date column
 *
 * @method     ChildCarOrganizationQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCarOrganizationQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCarOrganizationQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCarOrganizationQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildCarOrganizationQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildCarOrganizationQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildCarOrganizationQuery leftJoinDriver($relationAlias = null) Adds a LEFT JOIN clause to the query using the Driver relation
 * @method     ChildCarOrganizationQuery rightJoinDriver($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Driver relation
 * @method     ChildCarOrganizationQuery innerJoinDriver($relationAlias = null) Adds a INNER JOIN clause to the query using the Driver relation
 *
 * @method     ChildCarOrganizationQuery joinWithDriver($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Driver relation
 *
 * @method     ChildCarOrganizationQuery leftJoinWithDriver() Adds a LEFT JOIN clause and with to the query using the Driver relation
 * @method     ChildCarOrganizationQuery rightJoinWithDriver() Adds a RIGHT JOIN clause and with to the query using the Driver relation
 * @method     ChildCarOrganizationQuery innerJoinWithDriver() Adds a INNER JOIN clause and with to the query using the Driver relation
 *
 * @method     ChildCarOrganizationQuery leftJoinPassenger($relationAlias = null) Adds a LEFT JOIN clause to the query using the Passenger relation
 * @method     ChildCarOrganizationQuery rightJoinPassenger($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Passenger relation
 * @method     ChildCarOrganizationQuery innerJoinPassenger($relationAlias = null) Adds a INNER JOIN clause to the query using the Passenger relation
 *
 * @method     ChildCarOrganizationQuery joinWithPassenger($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Passenger relation
 *
 * @method     ChildCarOrganizationQuery leftJoinWithPassenger() Adds a LEFT JOIN clause and with to the query using the Passenger relation
 * @method     ChildCarOrganizationQuery rightJoinWithPassenger() Adds a RIGHT JOIN clause and with to the query using the Passenger relation
 * @method     ChildCarOrganizationQuery innerJoinWithPassenger() Adds a INNER JOIN clause and with to the query using the Passenger relation
 *
 * @method     ChildCarOrganizationQuery leftJoinEvents($relationAlias = null) Adds a LEFT JOIN clause to the query using the Events relation
 * @method     ChildCarOrganizationQuery rightJoinEvents($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Events relation
 * @method     ChildCarOrganizationQuery innerJoinEvents($relationAlias = null) Adds a INNER JOIN clause to the query using the Events relation
 *
 * @method     ChildCarOrganizationQuery joinWithEvents($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Events relation
 *
 * @method     ChildCarOrganizationQuery leftJoinWithEvents() Adds a LEFT JOIN clause and with to the query using the Events relation
 * @method     ChildCarOrganizationQuery rightJoinWithEvents() Adds a RIGHT JOIN clause and with to the query using the Events relation
 * @method     ChildCarOrganizationQuery innerJoinWithEvents() Adds a INNER JOIN clause and with to the query using the Events relation
 *
 * @method     \Montanari\Propel\DriversQuery|\Montanari\Propel\PassengersQuery|\Montanari\Propel\EventsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCarOrganization findOne(ConnectionInterface $con = null) Return the first ChildCarOrganization matching the query
 * @method     ChildCarOrganization findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCarOrganization matching the query, or a new ChildCarOrganization object populated from the query conditions when no match is found
 *
 * @method     ChildCarOrganization findOneByIdDriver(int $id_driver) Return the first ChildCarOrganization filtered by the id_driver column
 * @method     ChildCarOrganization findOneByIdPassenger(int $id_passenger) Return the first ChildCarOrganization filtered by the id_passenger column
 * @method     ChildCarOrganization findOneByIdEvent(string $id_event) Return the first ChildCarOrganization filtered by the id_event column
 * @method     ChildCarOrganization findOneByConfirmed(int $confirmed) Return the first ChildCarOrganization filtered by the confirmed column
 * @method     ChildCarOrganization findOneByConfirmCode(string $confirm_code) Return the first ChildCarOrganization filtered by the confirm_code column
 * @method     ChildCarOrganization findOneByInsertDate(string $insert_date) Return the first ChildCarOrganization filtered by the insert_date column *

 * @method     ChildCarOrganization requirePk($key, ConnectionInterface $con = null) Return the ChildCarOrganization by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCarOrganization requireOne(ConnectionInterface $con = null) Return the first ChildCarOrganization matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCarOrganization requireOneByIdDriver(int $id_driver) Return the first ChildCarOrganization filtered by the id_driver column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCarOrganization requireOneByIdPassenger(int $id_passenger) Return the first ChildCarOrganization filtered by the id_passenger column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCarOrganization requireOneByIdEvent(string $id_event) Return the first ChildCarOrganization filtered by the id_event column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCarOrganization requireOneByConfirmed(int $confirmed) Return the first ChildCarOrganization filtered by the confirmed column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCarOrganization requireOneByConfirmCode(string $confirm_code) Return the first ChildCarOrganization filtered by the confirm_code column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCarOrganization requireOneByInsertDate(string $insert_date) Return the first ChildCarOrganization filtered by the insert_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCarOrganization[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCarOrganization objects based on current ModelCriteria
 * @method     ChildCarOrganization[]|ObjectCollection findByIdDriver(int $id_driver) Return ChildCarOrganization objects filtered by the id_driver column
 * @method     ChildCarOrganization[]|ObjectCollection findByIdPassenger(int $id_passenger) Return ChildCarOrganization objects filtered by the id_passenger column
 * @method     ChildCarOrganization[]|ObjectCollection findByIdEvent(string $id_event) Return ChildCarOrganization objects filtered by the id_event column
 * @method     ChildCarOrganization[]|ObjectCollection findByConfirmed(int $confirmed) Return ChildCarOrganization objects filtered by the confirmed column
 * @method     ChildCarOrganization[]|ObjectCollection findByConfirmCode(string $confirm_code) Return ChildCarOrganization objects filtered by the confirm_code column
 * @method     ChildCarOrganization[]|ObjectCollection findByInsertDate(string $insert_date) Return ChildCarOrganization objects filtered by the insert_date column
 * @method     ChildCarOrganization[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CarOrganizationQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Montanari\Propel\Base\CarOrganizationQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Montanari\\Propel\\CarOrganization', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCarOrganizationQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCarOrganizationQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCarOrganizationQuery) {
            return $criteria;
        }
        $query = new ChildCarOrganizationQuery();
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
     * $obj = $c->findPk(array(12, 34, 56), $con);
     * </code>
     *
     * @param array[$id_driver, $id_passenger, $id_event] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildCarOrganization|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CarOrganizationTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = CarOrganizationTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1]), (null === $key[2] || is_scalar($key[2]) || is_callable([$key[2], '__toString']) ? (string) $key[2] : $key[2])]))))) {
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
     * @return ChildCarOrganization A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id_driver, id_passenger, id_event, confirmed, confirm_code, insert_date FROM car_organization WHERE id_driver = :p0 AND id_passenger = :p1 AND id_event = :p2';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->bindValue(':p2', $key[2], PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildCarOrganization $obj */
            $obj = new ChildCarOrganization();
            $obj->hydrate($row);
            CarOrganizationTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1]), (null === $key[2] || is_scalar($key[2]) || is_callable([$key[2], '__toString']) ? (string) $key[2] : $key[2])]));
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
     * @return ChildCarOrganization|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return $this|ChildCarOrganizationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(CarOrganizationTableMap::COL_ID_DRIVER, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(CarOrganizationTableMap::COL_ID_PASSENGER, $key[1], Criteria::EQUAL);
        $this->addUsingAlias(CarOrganizationTableMap::COL_ID_EVENT, $key[2], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCarOrganizationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(CarOrganizationTableMap::COL_ID_DRIVER, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(CarOrganizationTableMap::COL_ID_PASSENGER, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $cton2 = $this->getNewCriterion(CarOrganizationTableMap::COL_ID_EVENT, $key[2], Criteria::EQUAL);
            $cton0->addAnd($cton2);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the id_driver column
     *
     * Example usage:
     * <code>
     * $query->filterByIdDriver(1234); // WHERE id_driver = 1234
     * $query->filterByIdDriver(array(12, 34)); // WHERE id_driver IN (12, 34)
     * $query->filterByIdDriver(array('min' => 12)); // WHERE id_driver > 12
     * </code>
     *
     * @see       filterByDriver()
     *
     * @param     mixed $idDriver The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCarOrganizationQuery The current query, for fluid interface
     */
    public function filterByIdDriver($idDriver = null, $comparison = null)
    {
        if (is_array($idDriver)) {
            $useMinMax = false;
            if (isset($idDriver['min'])) {
                $this->addUsingAlias(CarOrganizationTableMap::COL_ID_DRIVER, $idDriver['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idDriver['max'])) {
                $this->addUsingAlias(CarOrganizationTableMap::COL_ID_DRIVER, $idDriver['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CarOrganizationTableMap::COL_ID_DRIVER, $idDriver, $comparison);
    }

    /**
     * Filter the query on the id_passenger column
     *
     * Example usage:
     * <code>
     * $query->filterByIdPassenger(1234); // WHERE id_passenger = 1234
     * $query->filterByIdPassenger(array(12, 34)); // WHERE id_passenger IN (12, 34)
     * $query->filterByIdPassenger(array('min' => 12)); // WHERE id_passenger > 12
     * </code>
     *
     * @see       filterByPassenger()
     *
     * @param     mixed $idPassenger The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCarOrganizationQuery The current query, for fluid interface
     */
    public function filterByIdPassenger($idPassenger = null, $comparison = null)
    {
        if (is_array($idPassenger)) {
            $useMinMax = false;
            if (isset($idPassenger['min'])) {
                $this->addUsingAlias(CarOrganizationTableMap::COL_ID_PASSENGER, $idPassenger['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idPassenger['max'])) {
                $this->addUsingAlias(CarOrganizationTableMap::COL_ID_PASSENGER, $idPassenger['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CarOrganizationTableMap::COL_ID_PASSENGER, $idPassenger, $comparison);
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
     * @return $this|ChildCarOrganizationQuery The current query, for fluid interface
     */
    public function filterByIdEvent($idEvent = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($idEvent)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CarOrganizationTableMap::COL_ID_EVENT, $idEvent, $comparison);
    }

    /**
     * Filter the query on the confirmed column
     *
     * Example usage:
     * <code>
     * $query->filterByConfirmed(1234); // WHERE confirmed = 1234
     * $query->filterByConfirmed(array(12, 34)); // WHERE confirmed IN (12, 34)
     * $query->filterByConfirmed(array('min' => 12)); // WHERE confirmed > 12
     * </code>
     *
     * @param     mixed $confirmed The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCarOrganizationQuery The current query, for fluid interface
     */
    public function filterByConfirmed($confirmed = null, $comparison = null)
    {
        if (is_array($confirmed)) {
            $useMinMax = false;
            if (isset($confirmed['min'])) {
                $this->addUsingAlias(CarOrganizationTableMap::COL_CONFIRMED, $confirmed['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($confirmed['max'])) {
                $this->addUsingAlias(CarOrganizationTableMap::COL_CONFIRMED, $confirmed['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CarOrganizationTableMap::COL_CONFIRMED, $confirmed, $comparison);
    }

    /**
     * Filter the query on the confirm_code column
     *
     * Example usage:
     * <code>
     * $query->filterByConfirmCode('fooValue');   // WHERE confirm_code = 'fooValue'
     * $query->filterByConfirmCode('%fooValue%', Criteria::LIKE); // WHERE confirm_code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $confirmCode The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCarOrganizationQuery The current query, for fluid interface
     */
    public function filterByConfirmCode($confirmCode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($confirmCode)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CarOrganizationTableMap::COL_CONFIRM_CODE, $confirmCode, $comparison);
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
     * @return $this|ChildCarOrganizationQuery The current query, for fluid interface
     */
    public function filterByInsertDate($insertDate = null, $comparison = null)
    {
        if (is_array($insertDate)) {
            $useMinMax = false;
            if (isset($insertDate['min'])) {
                $this->addUsingAlias(CarOrganizationTableMap::COL_INSERT_DATE, $insertDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($insertDate['max'])) {
                $this->addUsingAlias(CarOrganizationTableMap::COL_INSERT_DATE, $insertDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CarOrganizationTableMap::COL_INSERT_DATE, $insertDate, $comparison);
    }

    /**
     * Filter the query by a related \Montanari\Propel\Drivers object
     *
     * @param \Montanari\Propel\Drivers|ObjectCollection $drivers The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCarOrganizationQuery The current query, for fluid interface
     */
    public function filterByDriver($drivers, $comparison = null)
    {
        if ($drivers instanceof \Montanari\Propel\Drivers) {
            return $this
                ->addUsingAlias(CarOrganizationTableMap::COL_ID_DRIVER, $drivers->getId(), $comparison);
        } elseif ($drivers instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CarOrganizationTableMap::COL_ID_DRIVER, $drivers->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByDriver() only accepts arguments of type \Montanari\Propel\Drivers or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Driver relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCarOrganizationQuery The current query, for fluid interface
     */
    public function joinDriver($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Driver');

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
            $this->addJoinObject($join, 'Driver');
        }

        return $this;
    }

    /**
     * Use the Driver relation Drivers object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Montanari\Propel\DriversQuery A secondary query class using the current class as primary query
     */
    public function useDriverQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDriver($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Driver', '\Montanari\Propel\DriversQuery');
    }

    /**
     * Filter the query by a related \Montanari\Propel\Passengers object
     *
     * @param \Montanari\Propel\Passengers|ObjectCollection $passengers The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCarOrganizationQuery The current query, for fluid interface
     */
    public function filterByPassenger($passengers, $comparison = null)
    {
        if ($passengers instanceof \Montanari\Propel\Passengers) {
            return $this
                ->addUsingAlias(CarOrganizationTableMap::COL_ID_PASSENGER, $passengers->getId(), $comparison);
        } elseif ($passengers instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CarOrganizationTableMap::COL_ID_PASSENGER, $passengers->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPassenger() only accepts arguments of type \Montanari\Propel\Passengers or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Passenger relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCarOrganizationQuery The current query, for fluid interface
     */
    public function joinPassenger($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Passenger');

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
            $this->addJoinObject($join, 'Passenger');
        }

        return $this;
    }

    /**
     * Use the Passenger relation Passengers object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Montanari\Propel\PassengersQuery A secondary query class using the current class as primary query
     */
    public function usePassengerQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPassenger($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Passenger', '\Montanari\Propel\PassengersQuery');
    }

    /**
     * Filter the query by a related \Montanari\Propel\Events object
     *
     * @param \Montanari\Propel\Events|ObjectCollection $events The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCarOrganizationQuery The current query, for fluid interface
     */
    public function filterByEvents($events, $comparison = null)
    {
        if ($events instanceof \Montanari\Propel\Events) {
            return $this
                ->addUsingAlias(CarOrganizationTableMap::COL_ID_EVENT, $events->getId(), $comparison);
        } elseif ($events instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CarOrganizationTableMap::COL_ID_EVENT, $events->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildCarOrganizationQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildCarOrganization $carOrganization Object to remove from the list of results
     *
     * @return $this|ChildCarOrganizationQuery The current query, for fluid interface
     */
    public function prune($carOrganization = null)
    {
        if ($carOrganization) {
            $this->addCond('pruneCond0', $this->getAliasedColName(CarOrganizationTableMap::COL_ID_DRIVER), $carOrganization->getIdDriver(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(CarOrganizationTableMap::COL_ID_PASSENGER), $carOrganization->getIdPassenger(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond2', $this->getAliasedColName(CarOrganizationTableMap::COL_ID_EVENT), $carOrganization->getIdEvent(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1', 'pruneCond2'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the car_organization table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CarOrganizationTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CarOrganizationTableMap::clearInstancePool();
            CarOrganizationTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CarOrganizationTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CarOrganizationTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CarOrganizationTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CarOrganizationTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CarOrganizationQuery
